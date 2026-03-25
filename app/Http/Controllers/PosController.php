<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Barang;
use Illuminate\Support\Facades\DB;
use Exception;

class PosController extends Controller
{
    public function index()
    {
        return view('admin.pos.index');
    }

    public function cariBarang($id)
    {
        // Cari berdasarkan primary key model Barang (id_barang)
        $barang = Barang::find($id);

        if (!$barang) {
            return response()->json(['message' => 'Barang tidak ditemukan'], 404);
        }

        return response()->json($barang);
    }

    public function bayar(Request $request)
    {
        $cart = $request->input('cart', []);

        if (empty($cart) || !is_array($cart)) {
            return response()->json(['message' => 'Keranjang kosong'], 422);
        }

        DB::beginTransaction();
        try {
            $total = 0;
            foreach ($cart as $item) {
                $total += floatval($item['subtotal'] ?? 0);
            }

            // Insert ke tabel penjualan dan ambil id (sesuai struktur: hanya kolom `total`)
            $penjualanId = DB::table('penjualan')->insertGetId([
                'total' => $total,
            ]);

            // Insert detail
            foreach ($cart as $item) {
                DB::table('penjualan_detail')->insert([
                    'id_penjualan' => $penjualanId,
                    'id_barang' => $item['id_barang'] ?? $item['kode'] ?? null,
                    'jumlah' => intval($item['jumlah'] ?? 0),
                    'subtotal' => floatval($item['subtotal'] ?? 0),
                ]);
            }

            DB::commit();
            return response()->json(['status' => 'success', 'penjualan_id' => $penjualanId]);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json(['status' => 'error', 'message' => $e->getMessage()], 500);
        }
    }

    public function axiosIndex()
    {
        return view('admin.pos.axios');
    }
}
