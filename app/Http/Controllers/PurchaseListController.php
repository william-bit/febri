<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;

class PurchaseListController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth']);
    }
    public function index()
    {
        $transaction = Transaction::where('user_id',auth()->user()->id)->latest()->paginate(100);
        return view('pages.purchase_list.index',[
            'transactions' => $transaction
        ]);
    }
}
