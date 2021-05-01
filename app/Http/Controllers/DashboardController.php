<?php

namespace App\Http\Controllers;

use App\Models\Products;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth']);
    }
    public function index()
    {
        return view('admin.welcome',[
            'title' => 'dashboard'
        ]);
    }
}
