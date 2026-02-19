<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class PdfController extends Controller
{
    /**
     * Stream A4 landscape sertifikat PDF.
     */
    public function downloadSertifikat()
    {
        $data = []; // add data as needed
        $pdf = Pdf::loadView('pdf.sertifikat', $data)
            ->setPaper('a4', 'landscape');

        return $pdf->stream();
    }

    /**
     * Stream A4 portrait undangan PDF.
     */
    public function downloadUndangan()
    {
        $data = []; // add data as needed
        $pdf = Pdf::loadView('pdf.undangan', $data)
            ->setPaper('a4', 'portrait');

        return $pdf->stream();
    }

    /**
     * Show preview page for sertifikat (non-pdf stream).
     */
    public function previewSertifikat()
    {
        return view('pdf.preview-sertifikat');
    }

    /**
     * Show preview page for undangan (non-pdf stream).
     */
    public function previewUndangan()
    {
        return view('pdf.preview-undangan');
    }

    /**
     * Force download Sertifikat PDF.
     */
    public function unduhSertifikat()
    {
        $data = []; // add data as needed
        $pdf = Pdf::loadView('pdf.sertifikat', $data)
            ->setPaper('a4', 'landscape');

        return $pdf->download('Sertifikat_Vokasi.pdf');
    }

    /**
     * Force download Undangan PDF.
     */
    public function unduhUndangan()
    {
        $data = []; // add data as needed
        $pdf = Pdf::loadView('pdf.undangan', $data)
            ->setPaper('a4', 'portrait');

        return $pdf->download('Undangan_Silaturahmi.pdf');
    }
}
