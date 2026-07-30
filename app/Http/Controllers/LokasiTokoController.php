<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\LokasiToko;
use Barryvdh\DomPDF\Facade\Pdf;

class LokasiTokoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $lokasis = LokasiToko::all();
        return view('lokasi_toko.index', compact('lokasis'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('lokasi_toko.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_toko' => 'required|string|max:255',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'accuracy' => 'nullable|numeric',
        ]);

        // Generate a unique 8-character barcode
        do {
            $barcode = Str::upper(Str::random(8));
            $exists = LokasiToko::where('barcode', $barcode)->exists();
        } while ($exists);

        $lokasi = new LokasiToko();
        $lokasi->barcode = $barcode;
        $lokasi->nama_toko = $validated['nama_toko'];
        $lokasi->latitude = $validated['latitude'];
        $lokasi->longitude = $validated['longitude'];
        $lokasi->accuracy = $validated['accuracy'] ?? null;
        $lokasi->save();

        return redirect()->route('lokasi_toko.index')->with('success', 'Toko berhasil ditambahkan.');
    }

    /**
     * Show printable barcode page for a toko.
     */
    public function cetakBarcode($barcode)
    {
        $lokasi = LokasiToko::findOrFail($barcode);

        // enable remote images (external barcode URL) and render PDF
        $pdf = Pdf::setOptions(['isRemoteEnabled' => true])
            ->loadView('lokasi_toko.cetak_barcode', compact('lokasi'));

        $filename = 'Barcode-' . Str::slug($lokasi->nama_toko ?? $lokasi->barcode) . '.pdf';
        return $pdf->download($filename);
    }

    /**
     * Show kunjungan page (scanner + GPS) for checking visits.
     */
    public function halamanKunjungan()
    {
        return view('lokasi_toko.kunjungan');
    }

    /**
     * Calculate distance between two coordinates (meters) using Haversine formula.
     *
     * @param float $lat1
     * @param float $lng1
     * @param float $lat2
     * @param float $lng2
     * @return float meters
     */
    private function haversine($lat1, $lng1, $lat2, $lng2)
    {
        $R = 6371000; // Earth radius in meters
        $dLat = ($lat2 - $lat1) * pi() / 180.0;
        $dLng = ($lng2 - $lng1) * pi() / 180.0;
        $a = pow(sin($dLat / 2), 2) + cos($lat1 * pi() / 180.0) * cos($lat2 * pi() / 180.0) * pow(sin($dLng / 2), 2);
        $c = 2 * atan2(sqrt($a), sqrt(1 - $a));
        return $R * $c;
    }

    /**
     * Process a visit submission from sales (barcode + gps + accuracy).
     */
    public function prosesKunjungan(Request $request)
    {
        $data = $request->validate([
            'barcode' => 'required|string',
            'lat_sales' => 'required|numeric',
            'lng_sales' => 'required|numeric',
            'acc_sales' => 'nullable|numeric',
        ]);

        $lokasi = LokasiToko::find($data['barcode']);
        if (!$lokasi) {
            return response()->json(['error' => 'Toko tidak ditemukan'], 404);
        }

        $lat_toko = (float) $lokasi->latitude;
        $lng_toko = (float) $lokasi->longitude;
        $acc_toko = isset($lokasi->accuracy) ? (float) $lokasi->accuracy : 0;

        $lat_sales = (float) $data['lat_sales'];
        $lng_sales = (float) $data['lng_sales'];
        $acc_sales = isset($data['acc_sales']) ? (float) $data['acc_sales'] : 0;

        $jarak_aktual = $this->haversine($lat_toko, $lng_toko, $lat_sales, $lng_sales);

        $threshold = 300; // meters
        $threshold_efektif = $threshold + $acc_toko + $acc_sales;

        $status = ($jarak_aktual <= $threshold_efektif) ? 'DITERIMA' : 'DITOLAK';

        return response()->json([
            'barcode' => $lokasi->barcode,
            'nama_toko' => $lokasi->nama_toko,
            'lat_toko' => $lat_toko,
            'lng_toko' => $lng_toko,
            'acc_toko' => $acc_toko,
            'lat_sales' => $lat_sales,
            'lng_sales' => $lng_sales,
            'acc_sales' => $acc_sales,
            'jarak_aktual' => $jarak_aktual,
            'threshold' => $threshold,
            'threshold_efektif' => $threshold_efektif,
            'status' => $status,
        ]);
    }
}

