<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Barang;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
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
            // Try to generate QR for immediate client display (Endroid v6)
            try {
                $builder = new \Endroid\QrCode\Builder\Builder(
                    new \Endroid\QrCode\Writer\PngWriter(),
                    [],
                    false
                );

                $result = $builder->build(
                    null,
                    null,
                    null,
                    $penjualanId,
                    null,
                    null,
                    150,
                    0
                );

                if (method_exists($result, 'getDataUri')) {
                    $qrCode = $result->getDataUri();
                } elseif (method_exists($result, 'getString')) {
                    $qrCode = 'data:image/png;base64,' . base64_encode($result->getString());
                } else {
                    $qrCode = null;
                }
            } catch (\Throwable $e) {
                Log::error('QR generation failed (bayar): ' . $e->getMessage());
                $qrCode = null;
            }

            return response()->json(['status' => 'success', 'penjualan_id' => $penjualanId, 'qrCode' => $qrCode]);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json(['status' => 'error', 'message' => $e->getMessage()], 500);
        }
    }

    public function axiosIndex()
    {
        return view('admin.pos.axios');
    }

    /**
     * Show POS page with generated QR code for a given order id.
     * Returns view with $id_pesanan and $qrCode (base64 string) available.
     */
    public function showReceipt($id_pesanan)
    {
        try {
            // Endroid v6: Builder is instantiated (no static create()).
            $builder = new \Endroid\QrCode\Builder\Builder(
                new \Endroid\QrCode\Writer\PngWriter(),
                [],
                false
            );

            // Call build() with data + size + margin (data is 4th parameter)
            $result = $builder->build(
                null, // writer
                null, // writerOptions
                null, // validateResult
                $id_pesanan, // data
                null, // encoding
                null, // errorCorrectionLevel
                150, // size
                0 // margin
            );

            // ResultInterface in v6 has getDataUri() and getString()
            if (method_exists($result, 'getDataUri')) {
                $qrCode = $result->getDataUri();
            } elseif (method_exists($result, 'getString')) {
                $bin = $result->getString();
                $qrCode = 'data:image/png;base64,' . base64_encode($bin);
            } else {
                $qrCode = null;
                Log::warning('QR result object missing expected methods for order ' . $id_pesanan);
            }

            if ($qrCode) {
                Log::info('QR generated for order ' . $id_pesanan);
            }

        } catch (\Throwable $e) {
            // log the error and set null
            Log::error('QR generation error: ' . $e->getMessage());
            $qrCode = null;
        }

        return view('admin.pos.receipt', ['id_pesanan' => $id_pesanan, 'qrCode' => $qrCode]);
    }
}
