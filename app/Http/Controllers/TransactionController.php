<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    public function index()
    {
        $datas = Transaction::with(['user', 'obat'])->paginate(5);
        return view('admin.transaction.index', compact('datas'));
    }
}
