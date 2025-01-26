<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PageController extends Controller
{
    public function index()
    {

        $products = Product::orderBy('id', 'desc')
            ->limit(20)
            ->get();

        // return "index";
        return view('front.index',compact('products'));
    }
}
