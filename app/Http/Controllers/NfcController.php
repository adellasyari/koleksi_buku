<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\NfcKartu;
use App\Models\NfcAbsensi;

class NfcController extends Controller
{
    public function index()
    {
        return view('nfc.index');
    }

    public function prosesScan(Request $request)
    {
        $serialNumber = $request->serial_number;

        $kartu = NfcKartu::where('serial_number', $serialNumber)->first();

        if (!$kartu) {
            return response()->json([
                'success' => false,
                'message' => 'Kartu belum terdaftar!'
            ]);
        }

        NfcAbsensi::create([
            'serial_number' => $serialNumber,
            'waktu_absen' => now(),
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Absensi berhasil!',
            'nama' => $kartu->nama_mahasiswa
        ]);
    }
}
