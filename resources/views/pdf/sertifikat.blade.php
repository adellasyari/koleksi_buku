<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Sertifikat</title>
    <style>
        /* Page reset and A4 landscape */
        *{margin:0;padding:0;box-sizing:border-box}
        @page{size:a4 landscape;margin:0}
        html,body{width:297mm;height:210mm;margin:0;padding:0}
        body{font-family: 'Times New Roman', serif; background:#fff}

        /* Main container: full page, relative positioning */
        .certificate-container{width:100%;height:100%;position:relative;overflow:hidden}

        /* Outer spacing from edge (30px) to create the framed look */
        .frame-outer{position:absolute;inset:30px;border:0;box-sizing:border-box}

        /* Double border: outer thick and inner thin */
        .border-outer{width:100%;height:100%;border:8px solid #111;box-sizing:border-box;position:relative}
        .border-inner{position:absolute;inset:18px;border:2px solid #111;box-sizing:border-box;padding:28px;display:flex;flex-direction:column;align-items:center}

        /* Decorative corner shapes using CSS triangles (no images) */
        .border-inner::before,
        .border-inner::after{
            content:'';position:absolute;width:72px;height:72px;opacity:0.12;z-index:2}
        .border-inner::before{left:18px;top:18px;background:linear-gradient(135deg,#0b5ed7 0%,#2ec4b6 100%);clip-path:polygon(0 0,100% 0,0 100%);}
        .border-inner::after{right:18px;bottom:18px;background:linear-gradient(315deg,#0b5ed7 0%,#2ec4b6 100%);clip-path:polygon(100% 100%,0 100%,100% 0);}

        /* Content center area */
        .content{width:100%;height:100%;display:flex;flex-direction:column;align-items:center;justify-content:flex-start;position:relative}
        .header-univ{font-size:16px;font-weight:700;color:#222;margin-top:6px}
        .header-fakultas{font-size:12px;margin-top:6px;border-bottom:1px solid #111;padding-bottom:6px;display:inline-block;margin-bottom:18px}

        .main{width:100%;flex:1;display:flex;flex-direction:column;align-items:center}
        .main-title{font-size:64px;letter-spacing:8px;font-weight:800;margin-top:6px;color:#000}
        .subtitle{font-size:18px;font-style:italic;margin-top:6px;color:#444}
        .recipient-name{font-size:48px;font-weight:900;margin-top:14px;padding-bottom:6px;font-family:Arial,Helvetica,sans-serif;border-bottom:3px solid #222}

        .description{width:78%;font-size:14px;line-height:1.6;color:#222;margin-top:18px;text-align:center}

        /* Signature block pinned absolutely to bottom: 60px */
        .signatures{position:absolute;left:28px;right:28px;bottom:60px;width:calc(100% - 56px)}
        .signature-table{width:100%;border-collapse:collapse}
        .signature-table td{width:33.333%;text-align:center;vertical-align:bottom;padding:0 8px}
        .sig-space{display:block;height:56px}
        .sig-line{width:70%;margin:0 auto;border-top:1px solid #000;display:block}
        .jabatan{font-weight:700;font-size:13px;margin-top:8px}
        .nama-pejabat{font-weight:700;font-size:13px;text-decoration:underline;margin-top:6px}
        .nip{font-size:11px;margin-top:4px}

        /* Ensure no page-breaks inside main components */
        .border-outer, .border-inner, .content, .main, .signatures { page-break-inside: avoid }
    </style>
</head>
<body>
    <div class="certificate-container">
        <div class="frame-outer">
            <div class="border-outer">
                <div class="border-inner">
                    <div class="content">
                        <div class="header-univ">UNIVERSITAS AIRLANGGA</div>
                        <div class="header-fakultas">Fakultas Vokasi - D4 Teknik Informatika</div>

                        <div class="main">
                            <div class="main-title">SERTIFIKAT</div>
                            <div class="subtitle">Diberikan kepada:</div>
                            <div class="recipient-name">Adella Putri Asy'ari</div>

                            <div class="description">
                                Dengan ini diberikan penghargaan atas partisipasi dan kontribusi aktif dalam kegiatan
                                <strong>Praktikum Pemrograman Web Lanjut - Studi Kasus 2</strong>, termasuk kehadiran, kerja tim,
                                serta penyelesaian tugas akhir praktik. Diharapkan ilmu yang diperoleh dapat dimanfaatkan
                                untuk pengembangan kompetensi dan profesionalitas dalam bidang teknologi informasi.
                            </div>
                        </div>

                        <div class="signatures">
                            <table class="signature-table">
                                <tr>
                                    <td>
                                        <span class="sig-space"></span>
                                        <span class="sig-line"></span>
                                        <div class="jabatan">Dekan Fakultas Vokasi</div>
                                        <div class="nama-pejabat">Prof. Dian Yulie Reindrawati, S.Sos., MM, PhD</div>
                                        <div class="nip">NIP. 197001011995121001</div>
                                    </td>
                                    <td>
                                        <span class="sig-space"></span>
                                        <span class="sig-line"></span>
                                        <div class="jabatan">Koordinator Program Studi</div>
                                        <div class="nama-pejabat">Fitri Retrialisca, S.Kom., M.Kom.</div>
                                        <div class="nip">NIP. 198505202010122003</div>
                                    </td>
                                    <td>
                                        <span class="sig-space"></span>
                                        <span class="sig-line"></span>
                                        <div class="jabatan">Ketua Pelaksana</div>
                                        <div class="nama-pejabat">Adella Putri Asy'ari</div>
                                        <div class="nip">NIM. 434241023</div>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
