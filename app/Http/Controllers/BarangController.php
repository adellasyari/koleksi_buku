<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Barang;
use Barryvdh\DomPDF\Facade\Pdf;

class BarangController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $barang = Barang::all();
        return view('admin.barang.index', compact('barang'));
    }

    /**
     * Process barcode scan (AJAX).
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function prosesScan(Request $request)
    {
        $barcode = $request->barcode;

        if (empty($barcode)) {
            return response()->json(['error' => 'Barcode tidak dikirim'], 422);
        }

        $barang = Barang::where('id_barang', $barcode)->first();

        if (!$barang) {
            return response()->json(['error' => 'Barang tidak ditemukan'], 404);
        }

        return response()->json([
            'idbarang' => $barang->id_barang,
            'nama_barang' => $barang->nama,
            'harga_barang' => $barang->harga,
        ]);
    }

    /**
     * Show the form for creating a new barang.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('admin.barang.create');
    }

    /**
     * Store a newly created barang in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'harga' => 'required|numeric',
        ]);

        Barang::create([
            'nama' => $request->nama,
            'harga' => $request->harga,
        ]);

        return redirect('/barang')->with('success', 'Data berhasil disimpan!');
    }

    /**
     * Generate and stream labels PDF (Tom & Jerry 108 layout).
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function labelsPrint(Request $request)
    {
        // Accept items from form field 'barang_id' or 'items'
        $ids = $request->input('barang_id', $request->input('items', []));

        // Start positions (1-based) with fallbacks
        $startX = max(1, (int) $request->input('start_x', $request->input('posisi_x', 1)));
        $startY = max(1, (int) $request->input('start_y', $request->input('posisi_y', 1)));

        $cols = 5;
        $rows = 8;
        $slotsPerPage = $cols * $rows; // 40 labels per sheet

        $startX = min($cols, $startX);
        $startY = min($rows, $startY);

        // compute start index (0-based)
        $startIndex = ($startY - 1) * $cols + ($startX - 1);

        $selected = Barang::whereIn('id_barang', $ids)->orderBy('id_barang')->get();

        // Label size (TnJ 108) and paper size in mm
        $labelWidth = 38.0;  // mm
        $labelHeight = 18.0; // mm

        $paperWidth = 210.0; // mm (21 cm)
        $paperHeight = 165.0; // mm (16.5 cm)

        // Margins and gaps in mm
        $marginTop = 7.5;  // mm
        $marginLeft = 1.5; // mm
        $gapX = 3.5; // horizontal gap (mm)
        $gapY = 2.0; // vertical gap (mm)

        $pages = [];
        foreach ($selected as $idx => $item) {
            $pos = $startIndex + $idx;
            $pageNo = intdiv($pos, $slotsPerPage);
            $posInPage = $pos % $slotsPerPage;

            $col = $posInPage % $cols;
            $row = intdiv($posInPage, $cols);

            $x = $marginLeft + ($col * ($labelWidth + $gapX));
            $y = $marginTop + ($row * ($labelHeight + $gapY));

            $pages[$pageNo][] = [
                'item' => $item,
                'x' => $x,
                'y' => $y,
            ];
        }

        // convert mm to point for Dompdf (1 mm = 2.83465 pt)
        $mmToPt = 2.83465;
        $customPaper = [0, 0, $paperWidth * $mmToPt, $paperHeight * $mmToPt];

        $barang = $selected;

        $data = [
            'pages' => $pages,
            'labelWidth' => $labelWidth,
            'labelHeight' => $labelHeight,
            'calibrate' => (bool) $request->input('calibrate', false),
            'barang' => $barang,
        ];

        $viewName = $request->query('type') === 'barcode'
            ? 'admin.barang.labels_print_barcode'
            : 'admin.barang.labels_print';

        $pdf = Pdf::loadView($viewName, $data)->setPaper($customPaper);
        return $pdf->stream('labels_tnj_108.pdf');
    }

    /**
     * Compatibility wrapper for legacy route name `cetakLabel`.
     * Calls the new `labelsPrint` implementation so existing routes keep working.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function cetakLabel(Request $request)
    {
        return $this->labelsPrint($request);
    }
    /**
     * Show the form for editing the specified barang.
     *
     * @param  string  $id
     * @return \Illuminate\View\View
     */
    public function edit($id)
    {
        $barang = Barang::where('id_barang', $id)->first();
        return view('admin.barang.edit', compact('barang'));
    }

    /**
     * Update the specified barang in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'nama' => 'required',
            'harga' => 'required',
        ]);

        Barang::where('id_barang', $id)->update([
            'nama' => $request->nama,
            'harga' => $request->harga,
        ]);

        return redirect('/barang')->with('success', 'Data berhasil diubah!');
    }

    /**
     * Remove the specified barang from storage.
     *
     * @param  string  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Barang::where('id_barang', $id)->delete();
        return back()->with('success', 'Data dihapus!');
    }
}
