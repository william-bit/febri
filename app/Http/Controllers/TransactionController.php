<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    public function index()
    {
        $transaction = Transaction::latest()->paginate(100);
        return view('admin.transaction.index',[
            'title' => 'Transaction List',
            'breadcrumb' => [
            ],
            'action' => '',
            'edit' => 'product.update',
            'table' => [
                'json' => ['product'],
                'name' => 'Transaction list',
                'data' => $transaction,
                'order' => [
                    'product' => 'list Product',
                    'location' => 'location',
                    'created_at' => 'Created At',
                    'updated_at' => 'Updated At',
                ],
            ],
        ]);
    }
}
