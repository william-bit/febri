<?php

namespace App\Http\Controllers;

use App\Models\Products;
use Illuminate\Http\Request;

class CheckoutController extends Controller
{
    public function __construct()
    {
        $this->middleware(['web']);
    }
    public function index(Request $request)
    {
        $productCheckout = Products::whereIn('id',$request->session()->get('productCheckout'))->get();
        return view('pages.Transaction.Checkout',[
            'products' => $productCheckout
        ]);
    }
    public function store(Request $request)
    {
        if(!in_array($request->id,$request->session()->get('productCheckout',[]))){
            $request->session()->push('productCheckout', $request->id);
            $request->session()->save();
            return 1;
        }
        return 0;
    }
}
