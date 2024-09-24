<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use Illuminate\Http\Request;

class KategoriController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $kategori = Kategori::all();
        return response()->json($kategori);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create() {}

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'nama_kategori' => 'required|unique:kategoris',
        ]);

        $kategori = Kategori::create($validatedData);
        return response()->json($kategori, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Kategori $kategori)
    {
        $kategori = Kategori::find($kategori);
        return response()->json($kategori);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Kategori $kategori) {}

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Kategori $kategori)
    {
        $validatedData = $request->validate([
            'nama_kategori' => 'required|unique:kategoris',
        ]);

        $kategori->update($validatedData);
        return response()->json([
            'message' => 'Data berhasil diupdate',
            'data' => $kategori
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Kategori $kategori)
    {
        $kategori->delete();
        return response()->json([
            'message' => 'Data berhasil dihapus'
        ],200);
    }
}
