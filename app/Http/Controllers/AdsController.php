<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Ad;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use LaravelDaily\Invoices\Classes\Buyer;
use LaravelDaily\Invoices\Classes\InvoiceItem;
use LaravelDaily\Invoices\Invoice;

class AdsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Auth::user();

        if ($user && $user->is_admin === 1) {
            $ads = Ad::paginate(5);
        } else if ($user) {
            $ads = Ad::where("user_id", $user->id)->paginate(5);
        }

        return view("ads.index", compact('ads'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::all();

        return view("ads.add", compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $messages = [
            'required' => ':attribute je obavezan.',
            'email'    => ':attribute mora biti u ispravnom email formatu.',
            'numeric' => ':atribute mora biti broj'
        ];
        $this->validate($request, [
           "title" => "required",
           "content" => "required|min:10",
           "category_id" => "required",
           "image" => "required|mimes:jpeg,jpg,png,gif",
           "quantity" => "required|min:1|numeric",
            "price" => "required|integer|gt:0"
        ], $messages);

        $ad = new Ad();
        $ad->title = $request->input('title');
        $ad->content = $request->input('content');
        $ad->category_id = $request->input('category_id');
        $ad->price = (int) $request->input('price');
        $ad->quantity = $request->input('quantity');
        $user = Auth::user();
        $id = Auth::id();
        $ad->user_id = $id;

        if ($user->is_admin === 1)
            $ad->status = 'active';

        $image = $request->file("image");
        $filename = md5(uniqid()) . "." . $image->getClientOriginalExtension();
        $image->move(public_path("uploads"), $filename);

        $ad->image = $filename;
        $ad->save();

        return redirect(route('ads.index'))->with("message", "Oglas uspješno kreiran");
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $categories = Category::all();
        $ad = Ad::find($id);

        return view("ads.edit", compact('categories', 'ad'));
    }

    /**
     * Show the form for paying the ad
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function pay($id)
    {
        $ad = Ad::find($id);

        return view("ads.pay", compact( 'ad'));
    }

    /**
     * Show the form for paying the ad
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function payAdAndActivate($id)
    {
        $ad = Ad::find($id);

        $ad->status ='active';
        $ad->save();

        //generate Invoice

        return redirect(route('ads.index'))->with("message", "Oglas je plaćen i aktivan.");
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $messages = [
            'required' => ':attribute je obavezan.',
            'email'    => ':attribute mora biti u ispravnom email formatu.',
            'numeric' => ':atribute mora biti broj'
        ];
        $this->validate($request, [
            "title" => "required",
            "content" => "required|min:10",
            "category_id" => "required",
            "image" => "mimes:jpeg,jpg,png,gif",
            "quantity" => "required|min:1|numeric",
            "price" => "required|integer|gt:0"
        ], $messages);

        $ad = Ad::find($id);
        $ad->title = $request->input('title');
        $ad->content = $request->input('content');
        $ad->category_id = $request->input('category_id');
        $ad->price = $request->input('price');
        $ad->quantity = $request->input('quantity');

        if($request->hasFile("image")) {
            $image = $request->file("image");
            $filename = md5(uniqid()) . "." . $image->getClientOriginalExtension();
            $image->move(public_path("uploads"), $filename);

            $ad->image = $filename;
        }

        $ad->save();

        return redirect(route('ads.index'))->with("message", "Oglas uspješno ažuriran");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Ad::find($id)->delete();

        return redirect(route('ads.index'))->with("message", "Oglas je obrisan");
    }

    public function invoice($id)
    {
        $ad = Ad::find($id);
        $user = User::find($ad->user_id);

        $customer = new Buyer([
            'name'          => $user->name,
            'custom_fields' => [
                'email' => $user->email,
            ],
        ]);

        $item = InvoiceItem::make('Ad Payment ' . $ad->title)->pricePerUnit(20);

        $invoice = Invoice::make()
            ->series('FN')
            ->serialNumberFormat('{SEQUENCE}/{SERIES}')
            ->buyer($customer)
            ->sequence('001')
            ->status('PLAĆENO')
            ->addItem($item);

        return $invoice->stream();
    }

    public function cart()
    {
        return view('ads.cart');
    }

    public function addToCart($id)
    {
        $ad = Ad::findOrFail($id);

        $cart = session()->get('cart', []);

        if(isset($cart[$id])) {
            $cart[$id]['quantity']++;
        }  else {
            $cart[$id] = [
                "product_name" => $ad->title,
                "photo" => url('/') . '/uploads/' . $ad->image,
                "price" => $ad->price,
                "quantity" => 1
            ];
        }

        session()->put('cart', $cart);
        return redirect()->back()->with('success', 'Proizvod dodan u košaricu!');
    }

    public function updateCart(Request $request)
    {
        if($request->id && $request->quantity) {
            $ad = Ad::find($request->id);
            if ($ad->quantity >= $request->quantity) {
                $cart = session()->get('cart');
                $cart[$request->id]["quantity"] = $request->quantity;
                session()->put('cart', $cart);
                session()->flash('success', 'Košarica ažurirana!');
            } else {
                session()->flash('error', 'Trenutno nema više ovoga proizvoda na zalihi!');
            }
        }
    }

    public function removeFromCart(Request $request)
    {
        if($request->id) {
            $cart = session()->get('cart');
            if(isset($cart[$request->id])) {
                unset($cart[$request->id]);
                session()->put('cart', $cart);
            }
            session()->flash('success', 'Proizvod uspješno obrisan iz košarice!');
        }
    }
}
