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
        $transaction = Transaction::find($request->value);
        switch($request->type) {
            case 'confirm':
                $transaction->status = 1;
                break;
            case 'reject':
                $transaction->status = 4;
                break;

        }
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
                'valueConvert' => [
                    'status' => [
                        [
                            'id' => 0,
                            'value' => 'Pending'
                        ],
                        [
                            'id' => 1,
                            'value' => 'Confirm'
                        ],
                        [
                            'id' => 4,
                            'value' => 'Reject'
                        ]
                    ]
                ],
                'confirm' => [
                    'confirm_payment' =>[
                        'name' => 'Confirm Payment',
                        'color' => 'blue',
                        'value' => 'confirm',
                        'status' => [0],
                        'link' => route('transaction.confirm'),
                    ],
                    'reject_transaction' =>[
                        'name' => 'Reject Payment',
                        'color' => 'red',
                        'value' => 'reject',
                        'status' => [0],
                        'link' => route('transaction.confirm'),
                    ],
                ],
                'btn' => [
                    'pdf' => [
                        'title' => 'Print Report Transaction',
                        'link' => route('transaction.exportPdf',['from' => $from,'until' => $until]),
                        'color' => 'red'
                    ],
                ],
                'json' => ['product'],
                'currency' => ['total','transport'],
                'name' => 'Transaction list',
                'data' => $transaction,
                'photo' => ['photo'],
                'order' => [
                    'product' => 'List Product',
                    'photo' => 'Photo',
                    'transport' => 'Transport',
                    'total' => 'Total Purchase',
                    'location' => 'Location',
                    'status' => 'Status',
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
                        'title' => 'Print Report Transaction',
                        'link' => route('transaction.exportPdf'),
                        'color' => 'red'
                    ],
                ],
                'json' => ['product'],
                'currency' => ['total'],
                'order' => [
                    'location' => 'location',
                    'user.name' => 'User',
                    'photo' => 'Photo',
                    'transport' => 'Transport',
                    'product' => 'list Product',
                    'total' => 'Total Purchase',
                    'created_at' => 'Buy Date',
                    'updated_at' => 'Last Update',
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
            'created_at' => 'Buy Date',
            'updated_at' => 'Last Update',
        ];
        $data = Transaction::with('user')->latest()->paginate(100);
        $exportExcel = new ExportExcel($data,$header,'Transaction');
        $exportExcel->export();
    }
}
