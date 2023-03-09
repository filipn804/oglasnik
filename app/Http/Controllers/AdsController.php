<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Ad;
use Illuminate\Http\Request;

class AdsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $ads = Ad::paginate(10);

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
        $this->validate($request, [
           "title" => "required",
           "content" => "required|min:10",
           "category_id" => "required",
           "image" => "required|mimes:jpeg,jpg,png,gif"
        ]);

        $ad = new Ad();
        $ad->title = $request->input('title');
        $ad->content = $request->input('content');
        $ad->category_id = $request->input('category_id');
        $ad->price = $request->input('price');

        $image = $request->file("image");
        $filename = md5(uniqid()) . "." . $image->getClientOriginalExtension();
        $image->move(public_path("uploads"), $filename);

        $ad->image = $filename;
        $ad->save();

        return redirect(route('ads.index'))->with("message", "Ad created successfully");
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
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            "title" => "required",
            "content" => "required|min:10",
            "category_id" => "required",
            "image" => "mimes:jpeg,jpg,png,gif"
        ]);

        $ad = Ad::find($id);
        $ad->title = $request->input('title');
        $ad->content = $request->input('content');
        $ad->category_id = $request->input('category_id');
        $ad->price = $request->input('price');

        if($request->hasFile("image")) {
            $image = $request->file("image");
            $filename = md5(uniqid()) . "." . $image->getClientOriginalExtension();
            $image->move(public_path("uploads"), $filename);

            $ad->image = $filename;
        }

        $ad->save();

        return redirect(route('ads.index'))->with("message", "Ad updated successfully");
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

        return redirect(route('ads.index'))->with("message", "Ad deleted successfully");
    }
}