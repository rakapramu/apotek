<?php

namespace App\Http\Controllers;

use App\Models\Obat;
use App\Models\Order;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    //  tambah data ke order
    public function store(Request $request)
    {
        $data = Obat::where('id', $request->obat_id)->get();
        $harga = $data[0]->harga;
        Order::create([
            'users_id' => Auth::user()->id,
            'obat_id' => $request->obat_id,
            'jumlah' => $request->jumlah,
            'sub_total' => $harga * $request->jumlah
        ]);

        return redirect()->route('obat.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    // hapus data order
    public function destroy($id)
    {
        $item = Order::findOrFail($id);
        $item->delete();
        return redirect()->route('obat.index');
    }

    // checkout
    public function save(Request $request)
    {
        $data = $request->all();

        // get order data
        $carts = Order::with(['obat'])->where('users_id', Auth::user()->id)->get();

        // add to transactio data
        $data['user_id'] = Auth::user()->id;
        $data['obat_id'] = $carts[0]->obat_id;
        $data['total_price'] = $carts->sum('sub_total');

        // create transaction
        $transaction = Transaction::create($data);

        // kemudian hapus data di tabel order
        Order::where('users_id', Auth::user()->id)->delete();

        return redirect()->route('obat.index');
    }
}
