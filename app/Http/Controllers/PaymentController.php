<?php

namespace App\Http\Controllers;

use App\Models\Products;
use App\Models\Transaction;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function store(Request $request)
    {
        $this->validate($request,[
            'location' => 'required',
        ]);
        $insert['product'] = Products::whereIn('id',$request->session()->get('productCheckout'))->get()->toJson();
        $insert['user_id'] = auth()->user()->id;
        Transaction::create($insert);
        return redirect()->route('home');
    }
}
