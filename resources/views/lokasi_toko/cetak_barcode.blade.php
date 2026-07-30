<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Cetak Barcode - {{ $lokasi->nama_toko ?? $lokasi->barcode }}</title>
    <style>
        /* Basic page reset */
        html,body{margin:0;padding:0;background:#fff;font-family:Arial,Helvetica,sans-serif;color:#000}

        /* Center the sticker on the page */
        .container{display:flex;justify-content:center;align-items:center;padding:24px}

        /* Sticker card */
        .sticker{width:360px;border:2px dashed #000;padding:18px;box-sizing:border-box;text-align:center;background:#fff}
        .nama{font-size:20px;font-weight:700;margin-bottom:12px}
        .barcode-img{max-height:100px;margin-bottom:8px}

        /* Hide manual text (duplicate) but keep for accessibility if needed */
        .sr-only{position:absolute;width:1px;height:1px;padding:0;margin:-1px;overflow:hidden;clip:rect(0,0,0,0);white-space:nowrap;border:0}

        /* Print adjustments: force single-page sticker and remove default margins */
        @page { margin: 0; }
        @media print {
            html,body{background:#fff}
            body{margin:0;padding:0}
            .container{padding:8mm;}
            .sticker{border:2px dashed #000;padding:10mm;margin:0 auto;page-break-inside:avoid;box-shadow:none}
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="sticker">
            <div class="nama">{{ $lokasi->nama_toko }}</div>

            <div>
                <img class="barcode-img" src="https://barcode.tec-it.com/barcode.ashx?data={{ urlencode($lokasi->barcode) }}&code=Code128&dpi=96" alt="Barcode {{ $lokasi->barcode }}" style="max-height:100px;">
            </div>

            {{-- Barcode text intentionally hidden to avoid duplicate label from barcode image; kept for screen readers --}}
            <div class="sr-only">{{ $lokasi->barcode }}</div>
        </div>
</div>

</body>
</html>
