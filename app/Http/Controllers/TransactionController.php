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
            case 'arrive':
                $transaction->status = 2;
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
                            'color' => 'yellow',
                            'value' => 'Pending'
                        ],
                        [
                            'id' => 2,
                            'color' => 'green',
                            'value' => 'Arrive'
                        ],
                        [
                            'id' => 1,
                            'color' => 'blue',
                            'value' => 'Confirm'
                        ],
                        [
                            'id' => 4,
                            'color' => 'red',
                            'value' => 'Reject'
                        ]
                    ]
                ],
                'confirm' => [
                    'confirm_arrive' =>[
                        'name' => 'Confirm Arrive',
                        'color' => 'green',
                        'value' => 'arrive',
                        'status' => [1],
                        'link' => route('transaction.confirm'),
                    ],
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
                    'pdf2' => [
                        'title' => 'Print Report Transaksi Summary',
                        'link' => route('transaction.exportPdfSummary',['from' => $from,'until' => $until]),
                        'color' => 'red'
                    ],
                    'pdf3' => [
                        'title' => 'Print Report Transaksi Rekap',
                        'link' => route('transaction.exportPdfRekap',['from' => $from,'until' => $until]),
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
    public function exportPdfRekap(Request $request)
    {
        $transaction = Transaction::selectRaw('year(created_at) year, monthname(created_at) month,status, count(*) data,sum(total) total');
        if($request->from || $request->until){
            $this->validate($request,[
                'from' => 'required',
                'until' => 'required',
            ]);
            $transaction->where('created_at' ,'>',$request->from)
            ->where('created_at','<',$request->until);
        }
        $transaction = $transaction->orderBy('status')
        ->orderBy('year')
        ->orderBy('month')
        ->groupBy('status')
        ->groupBy('year')
        ->groupBy('month')
        ->paginate(100);

        $transArray = $transaction->toArray();


        $transArray['data'] =  array_filter($transArray['data'],function ($var) {
            return ($var['status'] != '4');
        });

        $sum = array_sum(array_column($transArray['data'],'total'));

        $count = array_sum(array_column($transArray['data'],'data'));

        $pdf = PDF::loadView('admin.transaction.report',[
            'title' => 'Report Transaction Rekap',
            'table' => [
                'total' => [
                    'total' => 'Rp.'.number_format($sum),
                    'data' => $count,
                ],
                'valueConvert' => [
                    'status' => [
                        [
                            'id' => 0,
                            'value' => 'Pending'
                        ],
                        [
                            'id' => 2,
                            'value' => 'Arrive'
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
                    'month' => 'Bulan',
                    'year' => 'Tahun',
                    'data' => 'Jumlah Transaksi',
                    'total' => 'Total Purchase',
                    'status' => 'status Pembayaran',
                ]
            ]
        ])->setPaper('a3');
        return $pdf->stream('transaction.pdf');
    }
    public function exportPdfSummary(Request $request)
    {
        $transaction = Transaction::with('user')->where('status','!=','0');
        if($request->from || $request->until){
            $this->validate($request,[
                'from' => 'required',
                'until' => 'required',
            ]);
            $transaction = $transaction->where('created_at' ,'>',$request->from)
            ->where('created_at','<',$request->until);
        }
        $transaction = $transaction->latest()->paginate(100);
        $sum = $transaction->toArray();
        $sum['data'] =  array_filter($sum['data'],function ($var) {
            return ($var['status'] != '4');
        });
        $sum = array_sum(array_column($sum['data'],'total'));
        $pdf = PDF::loadView('admin.transaction.report',[
            'title' => 'Report Transaction Summary',
            'table' => [
                'valueConvert' => [
                    'status' => [
                        [
                            'id' => 0,
                            'value' => 'Pending'
                        ],
                        [
                            'id' => 2,
                            'value' => 'Arrive'
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
                'total' => [
                    'total' => 'Rp.'.number_format($sum),
                ],
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
                'currency' => ['total','transport'],
                'order' => [
                    'user.name' => 'User',
                    'transport' => 'Transport',
                    'total' => 'Total Purchase',
                    'status' => 'Status',
                    'created_at' => 'Buy Date',
                ]
            ]
        ])->setPaper('a3');
        return $pdf->stream('transaction.pdf');
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
        $sum = $transaction->toArray();
        $sum['data'] =  array_filter($sum['data'],function ($var) {
            return ($var['status'] != '4');
        });
        $sum = array_sum(array_column($sum['data'],'total'));
        $pdf = PDF::loadView('admin.transaction.report',[
            'title' => 'Report Transaction',
            'table' => [
                'valueConvert' => [
                    'status' => [
                        [
                            'id' => 0,
                            'value' => 'Pending'
                        ],
                        [
                            'id' => 2,
                            'value' => 'Arrive'
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
                'currency' => ['total','transport'],
                'total' => [
                    'total' => 'Rp.'.number_format($sum),
                ],
                'order' => [
                    'user.name' => 'User',
                    'product' => 'list Product',
                    'transport' => 'Transport',
                    'total' => 'Total Purchase',
                    'status' => 'Status',
                    'created_at' => 'Buy Date',
                ]
            ]
        ])->setPaper('a3');
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
