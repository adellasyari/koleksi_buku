<?php

namespace App\Http\Controllers;

use App\Models\Antrian;
use Illuminate\Http\Request;
use Carbon\Carbon;

class AntrianController extends Controller
{
    // Menampilkan halaman form guest
    public function halamanGuest()
    {
        return view('antrian.guest');
    }

    // Memproses pendaftaran antrian
    public function daftarGuest(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
        ]);

        $hariIni = Carbon::today();

        // Cari nomor antrian tertinggi khusus hari ini
        $nomorTerakhir = Antrian::whereDate('created_at', $hariIni)->max('nomor_antrian');

        // Jika belum ada antrian hari ini, mulai dari 1. Jika ada, tambah 1.
        $nomorBaru = $nomorTerakhir ? $nomorTerakhir + 1 : 1;

        // Simpan data ke database
        $antrian = Antrian::create([
            'nomor_antrian' => $nomorBaru,
            'nama' => $request->nama,
            'status' => 'menunggu',
        ]);

        // Redirect kembali dengan membawa pesan sukses dan nomor antrian
        return redirect()->back()->with([
            'success' => 'Berhasil mengambil antrian!',
            'nomor_antrian' => $antrian->nomor_antrian
        ]);
    }

    // Menampilkan halaman admin
    public function halamanAdmin()
    {
        return view('antrian.admin');
    }

    // Menampilkan halaman layar TV/Papan
    public function halamanPapan()
    {
        return view('antrian.papan');
    }

    // Method memanggil antrian berikutnya
    public function panggilAntrian()
    {
        $hariIni = Carbon::today();
        
        $antrian = Antrian::whereDate('created_at', $hariIni)
            ->where('status', 'menunggu')
            ->orderBy('nomor_antrian', 'asc')
            ->first();

        if ($antrian) {
            $antrian->status = 'dipanggil';
            $antrian->save();
            return response()->json(['success' => true, 'message' => 'Antrian dipanggil', 'data' => $antrian]);
        }

        return response()->json(['success' => false, 'message' => 'Tidak ada antrian yang menunggu']);
    }

    public function tandaiTerlambat($id)
    {
        $antrian = Antrian::find($id);
        if ($antrian) {
            $antrian->status = 'terlambat';
            $antrian->save();
            return response()->json(['success' => true]);
        }
        return response()->json(['success' => false], 404);
    }

    public function panggilUlang($id)
    {
        $antrian = Antrian::find($id);
        if ($antrian) {
            $antrian->status = 'dipanggil';
            $antrian->updated_at = now();
            $antrian->save();
            return response()->json(['success' => true]);
        }
        return response()->json(['success' => false], 404);
    }

    // Method untuk Server-Sent Events (SSE)
    public function stream()
    {
        return response()->stream(function () {
            // Lepaskan session lock agar tab/request lain tidak ikut blocking.
            // Selama SSE berjalan (while-true), Laravel menahan file lock pada
            // session. Memanggil save() di sini menutup lock tersebut lebih awal.
            request()->session()->save();

            while (true) {
                // Hentikan loop jika client menutup koneksi (tutup tab/browser)
                if (connection_aborted()) {
                    break;
                }

                $hariIni = Carbon::today();

                // Ambil semua data antrian hari ini
                $dataAntrian = Antrian::whereDate('created_at', $hariIni)->get();

                // Kirim event beserta data dalam format JSON
                echo "event: queue-update\n";
                echo "data: " . json_encode($dataAntrian) . "\n\n";

                // Bersihkan output buffer dan kirim ke client
                ob_flush();
                flush();

                // Jeda 1 detik agar tidak memberatkan server
                sleep(1);
            }
        }, 200, [
            'Content-Type' => 'text/event-stream',
            'Cache-Control' => 'no-cache',
            'Connection' => 'keep-alive',
            'X-Accel-Buffering' => 'no', // Penting jika menggunakan Nginx
        ]);
    }

    // Method untuk AJAX polling data antrian (Halaman Admin)
    public function dataAjax()
    {
        $hariIni = Carbon::today();
        $dataAntrian = Antrian::whereDate('created_at', $hariIni)->orderBy('nomor_antrian', 'asc')->get();
        
        return response()->json($dataAntrian);
    }

    // Method untuk AJAX polling Papan Antrian (Layar)
    public function dataPapan()
    {
        $hariIni = Carbon::today();
        
        $dipanggil = Antrian::whereDate('created_at', $hariIni)
                            ->where('status', 'dipanggil')
                            ->orderBy('updated_at', 'desc')
                            ->first();
                            
        $selanjutnya = Antrian::whereDate('created_at', $hariIni)
                            ->where('status', 'menunggu')
                            ->orderBy('nomor_antrian', 'asc')
                            ->take(5)
                            ->get();
                            
        return response()->json([
            'dipanggil' => $dipanggil,
            'selanjutnya' => $selanjutnya
        ]);
    }
}
