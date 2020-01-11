<?php

namespace App\Http\Controllers\Front\Client;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class MainController extends Controller
{
    //
    public  function cart(Request $request)
    {
        //$orders = $request->user()->orders()->latest()->paginate(20);
        return view('front.client.cart');
    }
}
