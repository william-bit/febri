<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Products;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function indexSearch(Request $request)
    {
        $products = Products::query()->where('name','LIKE',"%{$request->search}%")->get();
        $categories = Category::get();
        $top = Products::take(5)->latest()->get();
        return view('welcome',[
            'top' => $top,
            'products' => $products,
            'categories' => $categories
        ]);
    }
    public function index()
    {
        $products = Products::latest()->paginate(100);
        $categories = Category::get();
        $top = Products::take(5)->latest()->get();
        return view('welcome',[
            'top' => $top,
            'products' => $products,
            'categories' => $categories
        ]);
    }
    public function indexWithCategory(Request $request){
        if($request->category != "all"){
            $products = Products::where('category_id',$request->category)->latest()->paginate(100);
        }else{
            $products = Products::latest()->paginate(100);
        }
        $categories = Category::get();
        $top = Products::take(5)->latest()->get();
        return view('welcome',[
            'top' => $top,
            'products' => $products,
            'categories' => $categories
        ]);
    }
    public function detail(Products $products)
    {
        return view('detail',[
            'product' => $products,
        ]);
    }
}
