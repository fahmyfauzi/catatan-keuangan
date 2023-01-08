<?php

namespace App\Http\Controllers;

use App\Models\Money;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class MoneyController extends Controller
{
    public function index()
    {
        // $money = Money::latest()->paginate(8);
        $money = Money::where('user_id', Auth::user()->id)->latest()->paginate(8);

        return view('pages.index', [
            'moneys' => $money
        ]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required',
            'keterangan' => 'required',
            'jumlah' => 'required',
            'jenis' => 'required',
        ]);

        //cek validasi salah
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
        //create store
        $money = Money::create([
            'user_id' => Auth::user()->id,
            'keterangan' => $request->keterangan,
            'jumlah' => $request->jumlah,
            'jenis' => $request->jenis,
        ]);
        //berhasil
        return response()->json([
            'success' => true,
            'message' => 'Data Berhasil Ditambahkan!',
            'data' => $money
        ]);
    }

    public function show(Money $money)
    {
        //menampilkan data contact
        return response()->json([
            'success' => true,
            'message' => 'Data Ditampilkan',
            'data' => $money
        ]);
    }

    public function update(Request $request, Money $money)
    {
        //cek validasi
        $validator = Validator::make($request->all(), [
            'id' => 'required',
            'user_id' => 'required',
            'keterangan' => 'required',
            'jumlah' => 'required',
            'jenis' => 'required',
        ]);

        //cek validasi salah
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
        //update store
        $money->update([
            'user_id' => Auth::user()->id,
            'keterangan' => $request->keterangan,
            'jumlah' => $request->jumlah,
            'jenis' => $request->jenis,
        ]);
        //berhasil
        return response()->json([
            'success' => true,
            'message' => 'Data Berhasil diupdate',
            'data' => $money
        ]);
    }

    public function destroy($id)
    {
        //pilih money berdasarkan id
        Money::where('id', $id)->delete();

        //berhasil
        return response()->json([
            'success' => true,
            'message' => 'Data Post Berhasil Dihapus!.',
        ]);
    }
}
