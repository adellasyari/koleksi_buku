@extends('layouts.master')

@push('style-page')
<style>
  /* ── Welcome Banner ─────────────────────────────── */
  .welcome-banner {
    background: linear-gradient(135deg, #0f172a 0%, #1e1b4b 60%, #162032 100%);
    border-radius: 20px;
    padding: 36px 40px;
    margin-bottom: 32px;
    position: relative;
    overflow: hidden;
    border: 1px solid rgba(99,102,241,.2);
    box-shadow: 0 8px 40px rgba(15,23,42,.3);
  }
  .welcome-banner::before {
    content: '';
    position: absolute;
    width: 320px; height: 320px;
    background: radial-gradient(circle, rgba(99,102,241,.35) 0%, transparent 65%);
    right: -60px; top: -80px;
    pointer-events: none;
  }
  .welcome-banner::after {
    content: '';
    position: absolute;
    width: 200px; height: 200px;
    background: radial-gradient(circle, rgba(6,182,212,.18) 0%, transparent 65%);
    left: 40%; bottom: -60px;
    pointer-events: none;
  }
  .welcome-banner .wb-content { position: relative; z-index: 1; }
  .welcome-banner h2 {
    font-size: 1.75rem; font-weight: 800;
    color: #f1f5f9; margin-bottom: 8px; letter-spacing: -.03em;
  }
  .welcome-banner h2 span { color: #818cf8; }
  .welcome-banner p { color: #64748b; margin: 0; font-size: .9rem; line-height: 1.6; }
  .welcome-badge {
    display: inline-flex; align-items: center; gap: 6px;
    background: rgba(16,185,129,.15); color: #34d399;
    border: 1px solid rgba(16,185,129,.25);
    border-radius: 20px; padding: 4px 14px;
    font-size: .7rem; font-weight: 700; letter-spacing: .08em;
    margin-bottom: 14px; text-transform: uppercase;
  }
  .welcome-badge .dot {
    width: 6px; height: 6px; background: #10b981;
    border-radius: 50%; animation: pulse-dot 2s ease-in-out infinite;
  }
  @keyframes pulse-dot {
    0%, 100% { opacity: 1; transform: scale(1); }
    50% { opacity: .5; transform: scale(.8); }
  }
  .welcome-date {
    position: absolute; right: 40px; top: 50%; transform: translateY(-50%);
    text-align: right; z-index: 1;
  }
  .welcome-date .date-num {
    font-size: 6rem; font-weight: 900; line-height: 1;
    background: linear-gradient(135deg, rgba(99,102,241,.25), rgba(99,102,241,.05));
    -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text;
    letter-spacing: -.04em;
  }
  .welcome-date .date-str { font-size: .78rem; color: #475569; margin-top: 2px; letter-spacing: .02em; }

  /* ── Quick Links ───────────────────────────────── */
  .section-label {
    font-size: .68rem; font-weight: 700; letter-spacing: .1em;
    text-transform: uppercase; color: #94a3b8; margin-bottom: 16px;
    display: flex; align-items: center; gap: 8px;
  }
  .section-label::after { content: ''; flex: 1; height: 1px; background: #f1f5f9; }

  .quick-link-card {
    background: #fff;
    border: 1.5px solid #e2e8f0;
    border-radius: 16px;
    padding: 20px 22px;
    text-decoration: none;
    display: flex; align-items: center; gap: 16px;
    transition: all .25s cubic-bezier(.4,0,.2,1);
    color: #334155;
    height: 100%;
  }
  .quick-link-card:hover {
    border-color: #6366f1;
    box-shadow: 0 6px 24px rgba(99,102,241,.14);
    transform: translateY(-3px);
    color: #0f172a;
    text-decoration: none;
  }
  .quick-link-icon {
    width: 48px; height: 48px; border-radius: 14px;
    display: flex; align-items: center; justify-content: center;
    flex-shrink: 0; font-size: 1.4rem; color: #fff;
    box-shadow: 0 4px 12px rgba(0,0,0,.12);
  }
  .quick-link-text .ql-title { font-weight: 700; font-size: .9rem; margin-bottom: 3px; }
  .quick-link-text .ql-sub { font-size: .76rem; color: #94a3b8; line-height: 1.4; }
  .quick-link-arrow {
    margin-left: auto; color: #e2e8f0; font-size: 1.2rem;
    transition: all .2s ease; flex-shrink: 0;
  }
  .quick-link-card:hover .quick-link-arrow { color: #6366f1; transform: translateX(3px); }
</style>
@endpush

@section('title', 'Dashboard — Koleksi Buku')

@section('content')

  {{-- Welcome Banner --}}
  <div class="welcome-banner">
    <div class="wb-content">
      <div class="welcome-badge">
        <span class="dot"></span>
        Sistem Aktif
      </div>
      <h2>Halo, <span>{{ Auth::user()->name ?? 'Admin' }}</span> 👋</h2>
      <p>Selamat datang di dashboard Koleksi Buku.<br>Berikut ringkasan data hari ini.</p>
    </div>
    <div class="welcome-date d-none d-lg-block">
      <div class="date-num">{{ date('d') }}</div>
      <div class="date-str">{{ now()->translatedFormat('l, M Y') }}</div>
    </div>
  </div>

  {{-- Quick Links --}}
  <div class="section-label">Akses Cepat</div>

  <div class="row g-3 mb-4">
    <div class="col-md-4">
      <a href="{{ route('buku.index') }}" class="quick-link-card">
        <div class="quick-link-icon" style="background: linear-gradient(135deg, #6366f1, #818cf8);">
          <i class="mdi mdi-book-open-variant"></i>
        </div>
        <div class="quick-link-text">
          <div class="ql-title">Kelola Buku</div>
          <div class="ql-sub">Tambah, edit, hapus buku</div>
        </div>
        <i class="mdi mdi-chevron-right quick-link-arrow"></i>
      </a>
    </div>

    <div class="col-md-4">
      <a href="{{ route('kategori.index') }}" class="quick-link-card">
        <div class="quick-link-icon" style="background: linear-gradient(135deg, #10b981, #34d399);">
          <i class="mdi mdi-tag-multiple-outline"></i>
        </div>
        <div class="quick-link-text">
          <div class="ql-title">Kelola Kategori</div>
          <div class="ql-sub">Atur kategori buku</div>
        </div>
        <i class="mdi mdi-chevron-right quick-link-arrow"></i>
      </a>
    </div>

    <div class="col-md-4">
      <a href="{{ route('buku.create') }}" class="quick-link-card">
        <div class="quick-link-icon" style="background: linear-gradient(135deg, #f59e0b, #fbbf24);">
          <i class="mdi mdi-plus-circle-outline"></i>
        </div>
        <div class="quick-link-text">
          <div class="ql-title">Tambah Buku Baru</div>
          <div class="ql-sub">Input buku ke koleksi</div>
        </div>
        <i class="mdi mdi-chevron-right quick-link-arrow"></i>
      </a>
    </div>
  </div>

@endsection
