<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\Mutasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MutasiController extends Controller
{

    public function index()
    {
        $mutasi = Mutasi::with('barang', 'user')->orderBy('tanggal', 'desc')->get();
        return response()->json($mutasi);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'tanggal' => 'required|date',
            'jenis_mutasi' => 'required|in:masuk,keluar',
            'jumlah' => 'required|integer|min:1',
            'barang_id' => 'required|exists:barangs,id',
        ]);

        $validatedData['user_id'] = Auth::id();

        $mutasi = Mutasi::create($validatedData);

        $barang = Barang::findOrFail($validatedData['barang_id']);
        if ($validatedData['jenis_mutasi'] == 'masuk') {
            $barang->stok += $validatedData['jumlah'];
        } else {
            $barang->stok -= $validatedData['jumlah'];
        }
        $barang->save();

        return response()->json($mutasi, 201);
    }

    public function show(Mutasi $mutasi)
    {
        return response()->json($mutasi->load('barang', 'user'));
    }

    public function update(Request $request, Mutasi $mutasi)
    {
        $validatedData = $request->validate([
            'tanggal' => 'sometimes|date',
            'jenis_mutasi' => 'sometimes|in:masuk,keluar',
            'jumlah' => 'sometimes|integer|min:1',
            'barang_id' => 'sometimes|exists:barangs,id',
        ]);

        if (isset($validatedData['jumlah']) || isset($validatedData['jenis_mutasi'])) {
            $barang = $mutasi->barang;

            if ($mutasi->jenis_mutasi == 'masuk') {
                $barang->stok -= $mutasi->jumlah;
            } else {
                $barang->stok += $mutasi->jumlah;
            }

            $newJenisMutasi = $validatedData['jenis_mutasi'] ?? $mutasi->jenis_mutasi;
            $newJumlah = $validatedData['jumlah'] ?? $mutasi->jumlah;

            if ($newJenisMutasi == 'masuk') {
                $barang->stok += $newJumlah;
            } else {
                $barang->stok -= $newJumlah;
            }

            $barang->save();
        }

        $mutasi->update($validatedData);

        return response()->json($mutasi);
    }
    public function destroy(Mutasi $mutasi)
    {
        $barang = $mutasi->barang;
        if ($mutasi->jenis_mutasi == 'masuk') {
            $barang->stok -= $mutasi->jumlah;
        } else {
            $barang->stok += $mutasi->jumlah;
        }
        $barang->save();

        $mutasi->delete();
        return response()->json([
            'message' => 'Data berhasil dihapus'
        ],200);
    }

    public function barangHistory($barangId)
    {
        $mutasi = Mutasi::where('barang_id', $barangId)
                        ->with('user')
                        ->orderBy('tanggal', 'desc')
                        ->get();

        return response()->json($mutasi);
    }
    public function userHistory($userId)
    {
        $mutasi = Mutasi::where('user_id', $userId)
                        ->with('barang')
                        ->orderBy('tanggal', 'desc')
                        ->get();

        return response()->json($mutasi);
    }
}
