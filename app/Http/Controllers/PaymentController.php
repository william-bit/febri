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
        $products = Products::whereIn('id',$request->item['id'])->get()->toArray();
        $total = 0;
        foreach($products as &$product){
            $product['quantity'] = $quantity = $request->item['quantity'][array_search($product['id'],$request->item['id'])];
            $total += $product['price'] * $quantity;
        }
        unset($product);
        $insert['product'] = json_encode($products);
        $insert['location'] = $request->location;
        $insert['total'] = $total;
        $insert['user_id'] = auth()->user()->id;
        $insert['status'] = 0;
        Transaction::create($insert);
        $request->session()->forget('productCheckout');
        return redirect()->route('home');
    }
}
