<?php

namespace App\Http\Controllers;

use PDF;
use App\Models\Transaction;
use App\Service\ExportExcel;
use Illuminate\Http\Request;
use Route;

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
    public function index(Request $request)
    {
        if($request->from || $request->until){
            $this->validate($request,[
                'from' => 'required',
                'until' => 'required',
            ]);
            $transaction = Transaction::where('created_at' ,'>',$request->from)
            ->where('created_at','<',$request->until)
            ->latest()->paginate(100);
            $from =$request->from;
            $until =$request->until;
        }else{
            $from ='';
            $until ='';
            $transaction = Transaction::latest()->paginate(100);
        }
        return view('admin.transaction.index',[
            'title' => 'Transaction List',
            'breadcrumb' => [
            ],
            'action' => 'transaction',
            'DataSearch' => [
                'action' => 'transaction',
                'submit' => 'search'
            ],
            'table' => [
                'btn' => [
                    'pdf' => [
                        'title' => 'Print Report Transaksi',
                        'link' => route('transaction.exportPdf',['from' => $from,'until' => $until]),
                        'color' => 'red'
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
            'forms' => [
                'name' => '',
                'type' => 'add',
                'method' => 'get',
                'data' => [
                    'from' => [
                        'type' => 'date',
                        'value' => $from,
                        'label' =>'Form',
                        'placeholder' =>'Product Name'
                    ],
                    'until' => [
                        'type' => 'date',
                        'value' => $until,
                        'label' =>'Until',
                        'placeholder' =>'Product Code'
                    ],
                ]
            ]
        ]);
    }
    public function exportPdf(Request $request)
    {
        if($request->from || $request->until){
            $this->validate($request,[
                'from' => 'required',
                'until' => 'required',
            ]);
            $transaction = Transaction::with('user')->where('created_at' ,'>',$request->from)
            ->where('created_at','<',$request->until)
            ->latest()->paginate(100);
        }else{
            $transaction = Transaction::with('user')->latest()->paginate(100);
        }
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
