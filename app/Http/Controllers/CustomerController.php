<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\File;
use Carbon\Carbon;

class CustomerController extends Controller
{
    /**
     * Show form for adding customer (store foto as BLOB)
     */
    public function createBlob()
    {
        return view('admin.customer.create', ['mode' => 'blob']);
    }

    /**
     * Show form for adding customer (store foto as file path)
     */
    public function createPath()
    {
        return view('admin.customer.create', ['mode' => 'path']);
    }

    /**
     * Store new customer. If mode == 'blob' store binary in foto_blob,
     * if mode == 'path' save PNG file to public/uploads/customers and store path in foto_path.
     */
    public function index()
    {
        // Retrieve all customers via query builder and pass to index view
        $customers = DB::table('customers')->get();
        return view('admin.customer.index', compact('customers'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nama' => 'required|string|max:255',
            'alamat' => 'nullable|string',
            'provinsi' => 'nullable|string|max:150',
            'kota' => 'nullable|string|max:150',
            'kecamatan' => 'nullable|string|max:150',
            'kodepos' => 'nullable|string|max:20',
            'foto_data' => 'nullable|string',
            'mode' => 'nullable|string|in:blob,path',
        ]);

        $mode = $request->input('mode', $data['mode'] ?? 'blob');
        $fotoData = $data['foto_data'] ?? null;

        $now = Carbon::now();

        $insert = [
            'nama' => $data['nama'],
            'alamat' => $data['alamat'] ?? null,
            'provinsi' => $data['provinsi'] ?? null,
            'kota' => $data['kota'] ?? null,
            'kecamatan' => $data['kecamatan'] ?? null,
            'kodepos' => $data['kodepos'] ?? null,
            // initialize both as null; we'll set the appropriate one below
            'foto_blob' => null,
            'foto_path' => null,
            'created_at' => $now,
            'updated_at' => $now,
        ];

        try {
            if ($fotoData) {
                // Strip data URI prefix if present
                if (strpos($fotoData, 'base64,') !== false) {
                    $parts = explode('base64,', $fotoData);
                    $base64 = end($parts);
                } else {
                    $base64 = $fotoData;
                }

                $binary = base64_decode($base64);

                if ($mode === 'blob') {
                    // store binary into foto_blob and ensure foto_path is null
                    $insert['foto_blob'] = $binary;
                    $insert['foto_path'] = null;
                } else {
                    // store file into public/uploads/customers and save filename only
                    $dir = public_path('uploads/customers');
                    if (!File::exists($dir)) {
                        File::makeDirectory($dir, 0755, true);
                    }
                    // filename per spec (unique using time)
                    $filename = time() . '.png';
                    $path = $dir . DIRECTORY_SEPARATOR . $filename;
                    file_put_contents($path, $binary);
                    // store only the filename in DB
                    $insert['foto_path'] = $filename;
                    $insert['foto_blob'] = null;
                }
            }

            $id = DB::table('customers')->insertGetId($insert);

            return redirect('/customer')->with('success', 'Customer berhasil disimpan (ID: ' . $id . ')');

        } catch (\Throwable $e) {
            Log::error('Customer store error: ' . $e->getMessage());
            return back()->withInput()->withErrors(['msg' => 'Gagal menyimpan customer: ' . $e->getMessage()]);
        }
    }
}
