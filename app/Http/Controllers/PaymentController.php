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
            'photo' => 'required',
        ]);
        $products = Products::whereIn('id',$request->item['id'])->get()->toArray();
        $total = 0;
        foreach($products as &$product){
            $product['quantity'] = $quantity = $request->item['quantity'][array_search($product['id'],$request->item['id'])];
            $total += $product['price'] * $quantity;
        }
        unset($product);
        $productPhoto = $request->file('photo')->getClientOriginalName();
        $insert['product'] = json_encode($products);
        $insert['location'] = $request->location;
        $insert['transport'] = 5000;
        $insert['photo'] = $productPhoto;
        $insert['total'] = $total+5000;
        $insert['user_id'] = auth()->user()->id;
        $insert['status'] = 0;
        Transaction::create($insert);
        $request->photo->move(public_path('storage/images'), $productPhoto);
        $request->session()->forget('productCheckout');
        return redirect()->route('home',['fire' => 'success','msg' => 'Success Buy']);
    }
}
