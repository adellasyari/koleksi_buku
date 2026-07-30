@extends('layouts.pdf')

@section('content')
@php
    // derive dimensions from controller-provided values (mm)
    $padTop = 0.5; // mm (reduced so barcode sits higher)
    $padSides = 1; // mm left+right
    // make barcode smaller to reliably fit inside 18mm label
    $barcodeHeight = min(6, $labelHeight * 0.4); // 6mm or 40% of label height
    // slightly reduce max width so barcode doesn't touch label edges
    $barcodeMaxWidth = max(0, $labelWidth - ($padSides * 2) - 2);
@endphp
<style>
    @page { margin: 0mm; }
    body { font-family: DejaVu Sans, Arial, sans-serif; margin: 0; padding: 0; }
    .page { position: relative; width: 100%; height: 100%; }

    /* Labels use absolute positioning (mm values inserted inline) so width/height come from $labelWidth/$labelHeight */
    .label { position: absolute; box-sizing: border-box; padding-top: {{ $padTop }}mm; padding-left: {{ $padSides }}mm; padding-right: {{ $padSides }}mm; text-align: center; overflow: hidden; }
    .name { font-weight: 600; font-size: 6pt; margin-bottom: 0px; line-height: 1; }
    /* Barcode scaled to fit inside label using controller width/height */
    .barcode-img { display:block; margin: 0.2mm auto 0; max-width: {{ $barcodeMaxWidth }}mm; width: auto; height: {{ $barcodeHeight }}mm; object-fit:contain }
    .id { margin-top: 2px; font-size: 7pt }

    /* Keep page-break avoidance to prevent split labels */
    @media print { .label { page-break-inside: avoid; } }

    @if(!empty($calibrate))
    /* show calibration border if requested */
    .label { border: 0.5pt dashed red; }
    @endif
</style>

@foreach($pages as $pageIndex => $page)
    <div class="page" style="{{ !$loop->last ? 'page-break-after: always;' : '' }}">
        @foreach($page as $i => $slot)
            @if(!empty($slot) && isset($slot['item']))
                @php $it = $slot['item']; @endphp
                @php
                    $generator = new \Picqer\Barcode\BarcodeGeneratorPNG();
                    $barcodeBase64 = base64_encode($generator->getBarcode($it->id_barang, \Picqer\Barcode\BarcodeGeneratorPNG::TYPE_CODE_128));
                @endphp

                <div class="label" style="left: {{ $slot['x'] }}mm; top: {{ $slot['y'] }}mm; width: {{ $labelWidth }}mm; height: {{ $labelHeight }}mm;">
                    <div class="name">{{ substr($it->nama ?? $it->nama_barang, 0, 24) }}</div>
                    <img class="barcode-img" src="data:image/png;base64,{{ $barcodeBase64 }}" alt="Barcode {{ $it->id_barang }}">
                    <div class="id">{{ $it->id_barang }}</div>
                </div>
            @endif
        @endforeach
    </div>
@endforeach

@endsection

