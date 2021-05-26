<?php

namespace App\Http\Controllers;

use App\Models\Products;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function index(Request $request)
    {
        $products = Products::query()->where('name','LIKE',"%{$request->search}%")->get();
        return response()->json([
            $products
        ]);

    }
}
