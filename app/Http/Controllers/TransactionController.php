<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;

class TransactionController extends Controller
{

    public function __construct()
    {
        $this->middleware(['auth']);
    }
    public function confirm(Request $request)
    {
        $transaction = Transaction::find($request->confirm);
        $transaction->status = 1;
        $transaction->save();
        return redirect()->route('transaction');
    }
    public function index()
    {
        $transaction = Transaction::latest()->paginate(100);
        return view('admin.transaction.index',[
            'title' => 'Transaction List',
            'breadcrumb' => [
            ],
            'action' => '',
            'table' => [
                'confirm' => ['link' => route('transaction.confirm'),'status' => 0],
                'json' => ['product'],
                'currency' => ['total'],
                'name' => 'Transaction list',
                'data' => $transaction,
                'order' => [
                    'product' => 'list Product',
                    'total' => 'Total Purchase',
                    'location' => 'location',
                    'created_at' => 'Created At',
                    'updated_at' => 'Updated At',
                ],
            ],
        ]);
    }
}
