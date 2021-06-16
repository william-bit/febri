<?php

namespace App\Http\Controllers;

use PDF;
use App\Models\Transaction;
use App\Service\ExportExcel;
use Illuminate\Http\Request;

class TransactionController extends Controller
{

    public function __construct()
    {
        $this->middleware(['auth','check.user']);
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
                'btn' => [
                    'pdf' => [
                        'title' => 'Print Report Transaksi',
                        'link' => route('transaction.exportPdf'),
                        'color' => 'red'
                    ],
                    'excel' => [
                        'title' => 'Export Report Transaksi',
                        'link' => route('transaction.exportExcel'),
                        'color' => 'blue'
                    ],
                ],
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
    public function exportPdf()
    {
        $transaction = Transaction::with('user')->latest()->paginate(100);
        $pdf = PDF::loadView('admin.transaction.report',[
            'title' => 'Report Penjualan',
            'table' => [
                'confirm' => ['link' => route('transaction.confirm'),'status' => 0],
                'name' => 'Transaction list',
                'data' => $transaction,
                'btn' => [
                    'pdf' => [
                        'title' => 'Print Report Transaksi',
                        'link' => route('transaction.exportPdf'),
                        'color' => 'red'
                    ],
                ],
                'json' => ['product'],
                'currency' => ['total'],
                'order' => [
                    'location' => 'location',
                    'user.name' => 'User',
                    'product' => 'list Product',
                    'total' => 'Total Purchase',
                    'created_at' => 'Created At',
                    'updated_at' => 'Updated At',
                ]
            ]
        ]);
        return $pdf->stream('transaction.pdf');
    }
    public function exportExcel()
    {
        $header = [
            'location' => 'location',
            'user.name' => 'User',
            'product' => 'list Product',
            'total' => 'Total Purchase',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
        $data = Transaction::with('user')->latest()->paginate(100);
        $exportExcel = new ExportExcel($data,$header,'Transaction');
        $exportExcel->export();
    }
}
