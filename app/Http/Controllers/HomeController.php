<?php

namespace App\Http\Controllers;

use App\Models\Products;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $product = Products::latest()->paginate(100);
        dd($product);
        return view('welcome',[
            'listProduct' => $product
        ]);
    }
}
