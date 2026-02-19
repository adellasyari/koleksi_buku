<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Undangan</title>
    <style>
        /* Page & reset */
        @page { size: a4 portrait; margin: 2cm 2.5cm; }
        * { margin-top: 0; box-sizing: border-box; }
        html, body { padding:0; font-family: 'Times New Roman', Times, serif; font-size:12pt; color:#000; }
        body { line-height:1.12; }

        .container { width:100%; padding-top:10mm; }

        /* Kop surat */
        .kop-table { width:100%; border-collapse:collapse; margin-bottom:6px; }
        .kop-left { width:15%; vertical-align:middle; }
        .kop-right { width:85%; text-align:center; vertical-align:middle; }
        .logo-placeholder { width:64px; height:64px; background:#ddd; border-radius:8px; display:inline-block; }
        .kop-title { font-size:16pt; font-weight:700; margin-bottom:4px; }
        .kop-sub { font-size:13pt; margin-bottom:3px; }
        .kop-info { font-size:9.5pt; }

        /* Double border under kop */
        .kop-border { border-bottom:3px solid #000; }
        .kop-border-2 { height:1px; background:#000; margin-top:3px; }

        /* Meta (nomor & tanggal) */
        .meta-table { width:100%; border-collapse:collapse; margin-top:6px; margin-bottom:6px; }
        .meta-left { vertical-align:top; }
        .meta-right { vertical-align:top; text-align:right; width:30%; }
        .meta-left td { padding:0; vertical-align:top; }
        .meta-label { width:110px; }

        /* Yth list */
        .yth { margin-top:6px; margin-bottom:4px; }
        .yth ol { margin:0 0 0 18px; padding:0; }
        .yth ol li { margin:0; padding:0; line-height:1.02; font-size:11.5pt; }

        /* Isi surat */
        .content { text-align:justify; margin-top:6px; font-size:12pt; }

        /* Detail acara table */
        .details { margin-left:20px; margin-top:6px; border-collapse:collapse; }
        .details td { padding:2px 4px; vertical-align:top; }
        .details .label { width:140px; }

        /* Penutup */
        .closing { text-align:justify; margin-top:8px; }

        /* Tanda tangan */
        .signature { float:right; width:250px; text-align:center; margin-top:12px; font-size:12pt; }
        .signature .name { font-weight:700; text-decoration:underline; display:block; margin-top:6px; }
        .clear { clear:both; }

    </style>
</head>
<body>
    <div class="container">
        <!-- Kop surat -->
        <table class="kop-table kop-border">
            <tr>
                <td class="kop-left">
                    <div style="text-align:left;">
                        <span class=""></span>
                    </div>
                </td>
                <td class="kop-right">
                    <div class="kop-title">UNIVERSITAS AIRLANGGA</div>
                    <div class="kop-sub">FAKULTAS VOKASI</div>
                    <div class="kop-info">Kampus B Jl. Dharmawangsa Dalam Surabaya 60286 Telp. (031) 5033869 Fax (031) 5053156</div>
                    <div class="kop-info">Laman : [], e-mail : info@vokasi.unair.ac.id</div>
                </td>
            </tr>
        </table>
        <div class="kop-border-2"></div>

        <!-- Nomor & Tanggal -->
        <table class="meta-table">
            <tr>
                <td class="meta-left" style="width:70%;">
                    <table style="border-collapse:collapse;">
                        <tr>
                            <td class="meta-label">Nomor</td>
                            <td>: 556/B/DST/UN3.FV/TU.01.00/2026</td>
                        </tr>
                        <tr>
                            <td class="meta-label">Lampiran</td>
                            <td>: Satu Lembar</td>
                        </tr>
                        <tr>
                            <td class="meta-label">Perihal</td>
                            <td>: Undangan</td>
                        </tr>
                    </table>
                </td>
                <td class="meta-right">
                    13 Januari 2026
                </td>
            </tr>
        </table>

        <!-- Yth -->
        <div class="yth">
            <div>Yth.</div>
            <ol>
                <li>Para Wakil Dekan</li>
                <li>Para Ketua Departemen</li>
                <li>Para Sekretaris Departemen</li>
                <li>Para Koordinator Program Studi</li>
                <li>Kepala Bagian Tata Usaha</li>
                <li>Para Kepala Subbagian</li>
                <li>Seluruh Dosen</li>
                <li>Seluruh Tenaga Kependidikan Fakultas Vokasi Universitas Airlangga</li>
            </ol>
        </div>

        <!-- Isi surat -->
        <div class="content">
            <p>Dalam rangka mempererat tali silaturahmi serta mengawali kegiatan tahun 2026, Fakultas Vokasi Universitas Airlangga akan menyelenggarakan Silaturahmi Awal Tahun Keluarga Besar Fakultas Vokasi. Sehubungan dengan hal tersebut, kami mengundang Bapak/Ibu untuk hadir pada kegiatan yang akan dilaksanakan pada:</p>

            <!-- Detail acara -->
            <table class="details">
                <tr>
                    <td class="label">Hari, Tanggal</td>
                    <td>:&nbsp;Selasa, 20 Januari 2026</td>
                </tr>
                <tr>
                    <td class="label">Waktu</td>
                    <td>:&nbsp;10.00 - 13.00 WIB</td>
                </tr>
                <tr>
                    <td class="label">Tempat</td>
                    <td>:&nbsp;Aula Gedung A Lt.3 Fakultas Vokasi Universitas Airlangga</td>
                </tr>
                <tr>
                    <td class="label">Agenda</td>
                    <td>:&nbsp;Silaturahmi Awal Tahun Keluarga Besar Fakultas Vokasi</td>
                </tr>
            </table>

            <p class="closing">Demikian undangan ini kami sampaikan. Atas perhatian dan kehadiran Bapak/Ibu, kami ucapkan terima kasih.</p>

            <!-- Tanda tangan -->
            <div class="signature">
                <div>Dekan</div>
                <div style="height:70px;"></div>
                <div class="name">Prof. Dian Yulie Reindrawati, S.Sos., M.M., Ph.D</div>
                <div>NIP 197607071999032001</div>
            </div>
            <div class="clear"></div>
        </div>
    </div>
</body>
</html>
