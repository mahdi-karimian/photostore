<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cookie;

use Illuminate\Http\Request;

class CheckoutController extends Controller
{
    public function show()
    {
        $products = !is_null(Cookie::get('basket')) ?  json_decode(Cookie::get('basket'),true) : [] ;
        return view('frontend.products.checkout',compact('products'));
    }
}
