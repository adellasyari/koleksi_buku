<nav class="sidebar sidebar-offcanvas" id="sidebar">
  <ul class="nav">

    {{-- ── Profile Area ─────────────────────────────────── --}}
    <li class="nav-item" style="padding: 20px 16px 16px;">
      <div style="display:flex;align-items:center;gap:12px;">
        {{-- Avatar --}}
        <div style="position:relative;flex-shrink:0;">
          <div style="
            width: 42px; height: 42px; border-radius: 14px;
            background: linear-gradient(135deg, #6366f1, #818cf8);
            display: flex; align-items: center; justify-content: center;
            font-size: 1rem; font-weight: 800; color: #fff;
            box-shadow: 0 4px 12px rgba(99,102,241,.5);
            letter-spacing: -.01em;
          ">{{ strtoupper(substr(Auth::user()->name ?? 'A', 0, 1)) }}</div>
          <div style="
            position: absolute; bottom: -2px; right: -2px;
            width: 12px; height: 12px; border-radius: 50%;
            background: #10b981; border: 2px solid #0f172a;
          "></div>
        </div>
        {{-- Info --}}
        <div style="min-width:0;flex:1;">
          <div style="font-weight:700;color:#f1f5f9;font-size:.875rem;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">
            {{ Auth::user()->name ?? 'Guest' }}
          </div>
          <div style="font-size:.7rem;color:#475569;margin-top:1px;">Administrator</div>
        </div>
        {{-- Settings icon --}}
        <div style="width:28px;height:28px;border-radius:8px;background:rgba(255,255,255,.05);display:flex;align-items:center;justify-content:center;cursor:pointer;flex-shrink:0;">
          <i class="mdi mdi-dots-horizontal" style="color:#475569;font-size:1rem;"></i>
        </div>
      </div>
    </li>

    {{-- ── Divider ──────────────────────────────────────── --}}
    <li style="padding: 0 16px 12px;">
      <div style="height:1px;background:linear-gradient(90deg, rgba(99,102,241,.3), transparent);border-radius:99px;"></div>
    </li>

    {{-- ── MENU UTAMA ───────────────────────────────────── --}}
    <li class="sb-label">Menu Utama</li>

    <li class="nav-item {{ Request::is('home') ? 'active' : '' }}">
      <a class="nav-link" href="/home">
        <span class="sb-icon-wrap" style="background: rgba(99,102,241,.12);">
          <i class="mdi mdi-view-dashboard-outline" style="color:#818cf8;"></i>
        </span>
        <span class="menu-title">Dashboard</span>
      </a>
    </li>

    <li class="nav-item {{ Request::is('kategori*') ? 'active' : '' }}">
      <a class="nav-link" href="{{ route('kategori.index') }}">
        <span class="sb-icon-wrap" style="background: rgba(16,185,129,.1);">
          <i class="mdi mdi-tag-multiple-outline" style="color:#34d399;"></i>
        </span>
        <span class="menu-title">Kategori</span>
      </a>
    </li>

    <li class="nav-item {{ Request::is('buku*') ? 'active' : '' }}">
      <a class="nav-link" href="{{ route('buku.index') }}">
        <span class="sb-icon-wrap" style="background: rgba(99,102,241,.12);">
          <i class="mdi mdi-book-open-page-variant-outline" style="color:#818cf8;"></i>
        </span>
        <span class="menu-title">Buku</span>
      </a>
    </li>

    <li class="nav-item {{ Request::is('barang*') ? 'active' : '' }}">
      <a class="nav-link" href="{{ url('/barang') }}">
        <span class="sb-icon-wrap" style="background: rgba(245,158,11,.1);">
          <i class="mdi mdi-package-variant-closed" style="color:#fbbf24;"></i>
        </span>
        <span class="menu-title">Barang UMKM</span>
      </a>
    </li>

    <li class="nav-item {{ Request::is('scanner-barcode*') ? 'active' : '' }}">
      <a class="nav-link" href="{{ url('/scanner-barcode') }}">
        <span class="sb-icon-wrap" style="background: rgba(6,182,212,.1);">
          <i class="mdi mdi-barcode-scan" style="color:#22d3ee;"></i>
        </span>
        <span class="menu-title">Scanner Barcode</span>
      </a>
    </li>

    <li class="nav-item {{ Request::is('nfc*') ? 'active' : '' }}">
      <a class="nav-link" href="{{ route('nfc.index') }}">
        <span class="sb-icon-wrap" style="background: rgba(139,92,246,.12);">
          <i class="mdi mdi-cellphone-nfc" style="color:#a78bfa;"></i>
        </span>
        <span class="menu-title">Absensi NFC</span>
      </a>
    </li>

    {{-- ── TRANSAKSI ────────────────────────────────────── --}}
    <li class="sb-label">Transaksi</li>

    <li class="nav-item {{ Request::is('pos*') ? 'active' : '' }}">
      <a class="nav-link" data-bs-toggle="collapse" href="#ui-pos"
         aria-expanded="{{ Request::is('pos*') ? 'true' : 'false' }}" aria-controls="ui-pos">
        <span class="sb-icon-wrap" style="background: rgba(239,68,68,.1);">
          <i class="mdi mdi-point-of-sale" style="color:#f87171;"></i>
        </span>
        <span class="menu-title">Kasir / POS</span>
        <i class="sb-arrow mdi mdi-chevron-right"></i>
      </a>
      <div class="collapse {{ Request::is('pos*') ? 'show' : '' }}" id="ui-pos">
        <ul class="nav flex-column sub-menu">
          <li class="nav-item"><a class="nav-link" href="{{ route('pos.index') }}">AJAX jQuery</a></li>
          <li class="nav-item"><a class="nav-link" href="{{ route('pos.axios') }}">Axios</a></li>
        </ul>
      </div>
    </li>

    <li class="nav-item {{ Request::is('customer*') ? 'active' : '' }}">
      <a class="nav-link" data-bs-toggle="collapse" href="#ui-customer"
         aria-expanded="{{ Request::is('customer*') ? 'true' : 'false' }}" aria-controls="ui-customer">
        <span class="sb-icon-wrap" style="background: rgba(16,185,129,.1);">
          <i class="mdi mdi-account-multiple-outline" style="color:#34d399;"></i>
        </span>
        <span class="menu-title">Customer</span>
        <i class="sb-arrow mdi mdi-chevron-right"></i>
      </a>
      <div class="collapse {{ Request::is('customer*') ? 'show' : '' }}" id="ui-customer">
        <ul class="nav flex-column sub-menu">
          <li class="nav-item"><a class="nav-link" href="{{ route('customer.index') }}">Data Customer</a></li>
          <li class="nav-item"><a class="nav-link" href="/customer/create-blob">Tambah (BLOB)</a></li>
          <li class="nav-item"><a class="nav-link" href="/customer/create-path">Tambah (Path)</a></li>
        </ul>
      </div>
    </li>

    {{-- ── MANAJEMEN ────────────────────────────────────── --}}
    <li class="sb-label">Manajemen</li>

    <li class="nav-item {{ Request::is('wilayah*') ? 'active' : '' }}">
      <a class="nav-link" data-bs-toggle="collapse" href="#ui-wilayah"
         aria-expanded="{{ Request::is('wilayah*') ? 'true' : 'false' }}" aria-controls="ui-wilayah">
        <span class="sb-icon-wrap" style="background: rgba(6,182,212,.1);">
          <i class="mdi mdi-map-marker-radius-outline" style="color:#22d3ee;"></i>
        </span>
        <span class="menu-title">Wilayah</span>
        <i class="sb-arrow mdi mdi-chevron-right"></i>
      </a>
      <div class="collapse {{ Request::is('wilayah*') ? 'show' : '' }}" id="ui-wilayah">
        <ul class="nav flex-column sub-menu">
          <li class="nav-item"><a class="nav-link" href="{{ route('wilayah.index') }}">AJAX (jQuery)</a></li>
          <li class="nav-item"><a class="nav-link" href="{{ route('wilayah.axios') }}">Axios (Vanilla JS)</a></li>
        </ul>
      </div>
    </li>

    <li class="nav-item {{ Request::is('lokasi-toko*') || Request::is('kunjungan-toko*') ? 'active' : '' }}">
      <a class="nav-link" data-bs-toggle="collapse" href="#ui-toko"
         aria-expanded="{{ Request::is('lokasi-toko*') || Request::is('kunjungan-toko*') ? 'true' : 'false' }}" aria-controls="ui-toko">
        <span class="sb-icon-wrap" style="background: rgba(245,158,11,.1);">
          <i class="mdi mdi-store-outline" style="color:#fbbf24;"></i>
        </span>
        <span class="menu-title">Manajemen Toko</span>
        <i class="sb-arrow mdi mdi-chevron-right"></i>
      </a>
      <div class="collapse {{ Request::is('lokasi-toko*') || Request::is('kunjungan-toko*') ? 'show' : '' }}" id="ui-toko">
        <ul class="nav flex-column sub-menu">
          <li class="nav-item"><a class="nav-link" href="{{ route('lokasi_toko.index') }}">Lokasi Toko</a></li>
          <li class="nav-item"><a class="nav-link" href="{{ route('lokasi_toko.kunjungan') }}">Kunjungan Toko</a></li>
        </ul>
      </div>
    </li>

    <li class="nav-item {{ Request::is('*antrian*') ? 'active' : '' }}">
      <a class="nav-link" data-bs-toggle="collapse" href="#antrian-menu"
         aria-expanded="{{ Request::is('*antrian*') ? 'true' : 'false' }}" aria-controls="antrian-menu">
        <span class="sb-icon-wrap" style="background: rgba(139,92,246,.12);">
          <i class="mdi mdi-account-clock-outline" style="color:#a78bfa;"></i>
        </span>
        <span class="menu-title">Antrian</span>
        <i class="sb-arrow mdi mdi-chevron-right"></i>
      </a>
      <div class="collapse {{ Request::is('*antrian*') ? 'show' : '' }}" id="antrian-menu">
        <ul class="nav flex-column sub-menu">
          <li class="nav-item"><a class="nav-link" href="{{ route('antrian.guest') }}" target="_blank">Ambil Antrian (Guest)</a></li>
          <li class="nav-item"><a class="nav-link" href="{{ route('antrian.admin') }}">Kelola Antrian</a></li>
          <li class="nav-item"><a class="nav-link" href="{{ route('antrian.papan') }}" target="_blank">Papan Antrian</a></li>
        </ul>
      </div>
    </li>

    {{-- ── LAINNYA ──────────────────────────────────────── --}}
    <li class="sb-label">Lainnya</li>

    <li class="nav-item {{ Request::is('simulasi*') ? 'active' : '' }}">
      <a class="nav-link" data-bs-toggle="collapse" href="#ui-simulasi"
         aria-expanded="{{ Request::is('simulasi*') ? 'true' : 'false' }}" aria-controls="ui-simulasi">
        <span class="sb-icon-wrap" style="background: rgba(239,68,68,.1);">
          <i class="mdi mdi-flask-outline" style="color:#f87171;"></i>
        </span>
        <span class="menu-title">Simulasi Modul 4</span>
        <i class="sb-arrow mdi mdi-chevron-right"></i>
      </a>
      <div class="collapse {{ Request::is('simulasi*') ? 'show' : '' }}" id="ui-simulasi">
        <ul class="nav flex-column sub-menu">
          <li class="nav-item"><a class="nav-link" href="{{ route('simulasi.dom') }}">DOM</a></li>
          <li class="nav-item"><a class="nav-link" href="{{ route('simulasi.datatables') }}">DataTables</a></li>
          <li class="nav-item"><a class="nav-link" href="{{ route('simulasi.select') }}">Select</a></li>
        </ul>
      </div>
    </li>

    <li class="nav-item">
      <a class="nav-link" data-bs-toggle="collapse" href="#pdf-dropdown"
         aria-expanded="false" aria-controls="pdf-dropdown">
        <span class="sb-icon-wrap" style="background: rgba(239,68,68,.1);">
          <i class="mdi mdi-file-pdf-box" style="color:#f87171;"></i>
        </span>
        <span class="menu-title">Export PDF</span>
        <i class="sb-arrow mdi mdi-chevron-right"></i>
      </a>
      <div class="collapse" id="pdf-dropdown">
        <ul class="nav flex-column sub-menu">
          <li class="nav-item"><a class="nav-link" href="{{ url('/preview-sertifikat') }}">Sertifikat (Landscape)</a></li>
          <li class="nav-item"><a class="nav-link" href="{{ url('/preview-undangan') }}">Undangan (Portrait)</a></li>
        </ul>
      </div>
    </li>

    {{-- ── Bottom spacer ────────────────────────────────── --}}
    <li style="height: 20px;"></li>

  </ul>
</nav>

<style>
  /* ── Sidebar core ─────────────────────────────── */
  .sidebar {
    background: #0f172a !important;
    width: 260px !important;
    border-right: none !important;
    box-shadow: none !important;
  }
  .sidebar .nav { padding: 0; }

  /* ── Section Label ────────────────────────────── */
  .sb-label {
    list-style: none;
    padding: 14px 20px 5px;
    font-size: .6rem;
    font-weight: 800;
    letter-spacing: .14em;
    text-transform: uppercase;
    color: #334155;
  }

  /* ── Nav Item Base ────────────────────────────── */
  .sidebar .nav-item > .nav-link {
    display: flex;
    align-items: center;
    gap: 10px;
    padding: 8px 12px 8px 16px;
    margin: 1px 10px;
    border-radius: 10px;
    color: #94a3b8 !important;
    font-size: .84rem;
    font-weight: 500;
    transition: all .22s cubic-bezier(.4,0,.2,1);
    position: relative;
    text-decoration: none;
  }
  .sidebar .nav-item > .nav-link:hover {
    background: rgba(255,255,255,.05) !important;
    color: #e2e8f0 !important;
  }

  /* ── Active Item ──────────────────────────────── */
  .sidebar .nav-item.active > .nav-link {
    background: rgba(99,102,241,.15) !important;
    color: #c7d2fe !important;
  }
  .sidebar .nav-item.active > .nav-link .sb-icon-wrap {
    background: rgba(99,102,241,.25) !important;
    box-shadow: 0 0 0 1px rgba(99,102,241,.4);
  }
  .sidebar .nav-item.active > .nav-link .sb-icon-wrap i { color: #a5b4fc !important; }

  /* Active left bar indicator */
  .sidebar .nav-item.active > .nav-link::before {
    content: '';
    position: absolute;
    left: -10px; top: 25%; bottom: 25%;
    width: 3px;
    background: linear-gradient(180deg, #6366f1, #818cf8);
    border-radius: 0 4px 4px 0;
  }

  /* ── Icon Wrap ────────────────────────────────── */
  .sb-icon-wrap {
    width: 32px; height: 32px;
    border-radius: 9px;
    display: flex; align-items: center; justify-content: center;
    flex-shrink: 0;
    font-size: 1rem;
    transition: all .22s ease;
  }
  .sidebar .nav-item > .nav-link:hover .sb-icon-wrap {
    transform: scale(1.08);
  }

  /* ── Arrow ────────────────────────────────────── */
  .sb-arrow {
    margin-left: auto;
    font-size: .9rem;
    color: #334155;
    transition: transform .22s ease;
    flex-shrink: 0;
  }
  .sidebar .nav-link[aria-expanded="true"] .sb-arrow {
    transform: rotate(90deg);
    color: #6366f1;
  }

  /* ── Sub-menu ─────────────────────────────────── */
  .sidebar .sub-menu {
    padding: 3px 0 6px;
    margin-left: 26px;
    position: relative;
  }
  .sidebar .sub-menu::before {
    content: '';
    position: absolute;
    left: 15px; top: 0; bottom: 6px;
    width: 1px;
    background: linear-gradient(180deg, rgba(99,102,241,.3), transparent);
  }
  .sidebar .sub-menu .nav-item { margin: 0; }
  .sidebar .sub-menu .nav-item .nav-link {
    display: flex !important;
    align-items: center;
    gap: 8px;
    padding: 6px 12px 6px 28px !important;
    margin: 0 !important;
    border-radius: 8px !important;
    font-size: .8rem !important;
    color: #475569 !important;
    transition: all .18s ease;
    background: transparent !important;
  }
  .sidebar .sub-menu .nav-item .nav-link::before {
    content: '';
    width: 5px; height: 5px;
    border-radius: 50%;
    background: #334155;
    flex-shrink: 0;
    transition: background .18s ease;
    display: none !important; /* hide left bar for sub-items */
  }
  .sidebar .sub-menu .nav-item .nav-link:hover {
    color: #e2e8f0 !important;
    background: rgba(255,255,255,.04) !important;
    transform: translateX(3px);
  }
</style>