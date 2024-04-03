<?php

namespace App\Http\Controllers;

use App\Models\Ad;
use App\Models\User;


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

        $relatedAds = Ad::where('category_id', $ad->category_id)
            ->whereNot('id', $ad->id)
            ->limit(3)
            ->get();

        $user = User::find($ad->user_id);

        return view('ads.show')->with(['ad' => $ad, 'user' => $user, 'relatedAds' => $relatedAds]);
    }

}


