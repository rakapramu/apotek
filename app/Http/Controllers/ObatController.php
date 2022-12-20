<?php

namespace App\Http\Controllers;

use App\Models\Obat;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ObatController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $obats = Obat::all();
        $orders = Order::with(['obat'])->where('users_id', Auth::user()->id)->get();
        return view('admin.obat.index', compact('obats', 'orders'));
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
    public function store(Request $request)
    {
        $request->validate([
            'nama_obat' => 'required',
            'harga' => 'required|integer'
        ], [
            'nama_obat.required' => 'Nama Obat Harus Di Isi',
            'harga.required' => 'Harga Obat Harus Di Isi',
        ]);
        Obat::create($request->all());
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
        $data = Obat::findOrFail($id);
        return view('admin.obat.edit', compact('data'));
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
        $request->validate([
            'nama_obat' => 'required',
            'harga' => 'required|integer'
        ], [
            'nama_obat.required' => 'Nama Obat Harus Di Isi',
            'harga.required' => 'Harga Obat Harus Di Isi',
        ]);

        $data = Obat::findOrFail($id);
        $data->update($request->all());
        return redirect()->route('obat.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $data = Obat::where('id', $id);
        $data->delete();
        return redirect()->route('obat.index');
    }
}
