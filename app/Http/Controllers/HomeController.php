<?php

namespace App\Http\Controllers;

use App\Models\Ad;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class HomeController extends Controller
{


    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function welcome()
    {
        $ads = Ad::where('status', 'active')->get();
        return view('home')->with(['ads' => $ads]);
    }


    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function getAdsInCategory($id)
    {

        $ads = Ad::where('status', 'active')
            ->where('category_id', $id)
            ->get();
        return view('home')->with(['ads' => $ads]);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function show($id)
    {

        $ad = Ad::find($id);
        return view('ads.show')->with(['ad' => $ad]);
    }

}


