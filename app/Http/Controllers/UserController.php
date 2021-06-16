<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth','check.user']);
    }
    public function index()
    {
        $transaction = Transaction::latest()->paginate(100);
        return view('pages.users.index',[
            'transactions' => $transaction
        ]);
    }
}
