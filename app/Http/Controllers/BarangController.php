<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\Mutasi;
use GuzzleHttp\Psr7\Message;
use Illuminate\Http\Request;

class BarangController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $barang = Barang::all();
        return response()->json($barang);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'nama_barang' => 'required',
            'kode' => 'required|unique:barangs,kode',
            'kategori_id' => 'required',
            'lokasi' => 'required'
        ]);
        
        $barang = Barang::create(
            [
                'nama_barang' => $validatedData['nama_barang'],
                'kode' => $validatedData['kode'],
                'kategori_id' => $validatedData['kategori_id'],
                'lokasi' => $validatedData['lokasi']
            ]
        );
        return response()->json($barang, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Barang $barang)
    {
        $barang = Barang::find($barang);
        return response()->json($barang);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Barang $barang)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Barang $barang)
    {
       $validatedData = $request->validate([
            'nama_barang' => 'required',
            'kategori_id' => 'required',
            'lokasi' => 'required'
        ]);
        
        $barang->update(
            [
                'nama_barang' => $validatedData['nama_barang'],
                'kategori_id' => $validatedData['kategori_id'],
                'lokasi' => $validatedData['lokasi']
            ]
        );
        return response()->json([
            'message' => 'Data berhasil diupdate',
            'data' => $barang
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Barang $barang)
    {
        $barang->delete();
        return response()->json([
            'message' => 'Data berhasil dihapus',
        ], 200);
    }

}
