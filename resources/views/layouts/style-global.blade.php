{{-- Google Fonts --}}
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

{{-- Global CSS links --}}
<link rel="stylesheet" href="{{ asset('assets/vendors/mdi/css/materialdesignicons.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/vendors/ti-icons/css/themify-icons.css') }}">
<link rel="stylesheet" href="{{ asset('assets/vendors/css/vendor.bundle.base.css') }}">
<link rel="stylesheet" href="{{ asset('assets/vendors/font-awesome/css/font-awesome.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/vendors/bootstrap-datepicker/bootstrap-datepicker.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
<link rel="shortcut icon" href="{{ asset('assets/images/favicon.png') }}" />

{{-- ======================================================
     CUSTOM THEME OVERRIDE — Koleksi Buku Premium UI
     ====================================================== --}}
<style>
  /* ── Base & Typography ─────────────────────────────── */
  :root {
    --primary:        #6366f1;
    --primary-dark:   #4f46e5;
    --primary-light:  #818cf8;
    --accent:         #06b6d4;
    --success:        #10b981;
    --warning:        #f59e0b;
    --danger:         #ef4444;
    --sidebar-bg:     #0f172a;
    --sidebar-text:   #94a3b8;
    --sidebar-active: #6366f1;
    --navbar-h:       70px;
    --sidebar-w:      260px;
    --body-bg:        #f1f5f9;
    --card-bg:        #ffffff;
    --border-radius:  14px;
    --shadow-sm:      0 1px 3px rgba(0,0,0,.08), 0 1px 2px rgba(0,0,0,.06);
    --shadow-md:      0 4px 16px rgba(99,102,241,.12);
    --shadow-lg:      0 10px 40px rgba(99,102,241,.18);
    --transition:     all .25s cubic-bezier(.4,0,.2,1);
  }

  *, *::before, *::after { box-sizing: border-box; }

  body {
    font-family: 'Inter', sans-serif !important;
    background: var(--body-bg) !important;
    color: #334155 !important;
    -webkit-font-smoothing: antialiased;
  }

  /* ── Scrollbar ─────────────────────────────────────── */
  ::-webkit-scrollbar { width: 6px; height: 6px; }
  ::-webkit-scrollbar-track { background: #f1f5f9; }
  ::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 99px; }
  ::-webkit-scrollbar-thumb:hover { background: var(--primary-light); }

  /* ── Navbar ────────────────────────────────────────── */
  .navbar.default-layout-navbar {
    background: linear-gradient(135deg, #0f172a 0%, #1e1b4b 100%) !important;
    box-shadow: 0 2px 20px rgba(15,23,42,.35) !important;
    border: none !important;
    height: var(--navbar-h) !important;
    z-index: 1030 !important;
  }

  .navbar .navbar-brand-wrapper {
    background: transparent !important;
    border-right: 1px solid rgba(255,255,255,.07) !important;
    width: var(--sidebar-w) !important;
  }

  .navbar .navbar-brand img { max-height: 36px; }

  /* search bar in navbar */
  .navbar .search-field .input-group-text,
  .navbar .search-field .form-control {
    background: rgba(255,255,255,.06) !important;
    border: 1px solid rgba(255,255,255,.1) !important;
    color: #e2e8f0 !important;
    border-radius: 10px !important;
  }
  .navbar .search-field .form-control::placeholder { color: #64748b; }
  .navbar .search-field .input-group-text { border-right: none !important; border-radius: 10px 0 0 10px !important; }
  .navbar .search-field .form-control { border-left: none !important; border-radius: 0 10px 10px 0 !important; }

  /* navbar right icons */
  .navbar .navbar-nav-right .nav-item { margin-left: 4px; }
  .navbar .navbar-toggler { color: #94a3b8 !important; border: none !important; }
  .navbar .navbar-toggler .mdi { font-size: 1.4rem; color: #94a3b8; }

  /* profile dropdown in navbar */
  .navbar .nav-profile-img { position: relative; }
  .navbar .nav-profile-img img {
    width: 38px; height: 38px;
    border-radius: 50%;
    border: 2px solid var(--primary);
    object-fit: cover;
  }
  .navbar .availability-status {
    width: 10px; height: 10px;
    border: 2px solid #1e293b;
  }
  .navbar .nav-profile-text p {
    color: #e2e8f0 !important;
    font-weight: 500;
    font-size: .875rem;
  }
  .navbar .dropdown-menu.navbar-dropdown {
    background: #1e293b;
    border: 1px solid rgba(255,255,255,.08);
    border-radius: 12px;
    box-shadow: 0 8px 32px rgba(0,0,0,.35);
    padding: 8px;
    min-width: 180px;
  }
  .navbar .dropdown-menu.navbar-dropdown .dropdown-item {
    color: #cbd5e1;
    border-radius: 8px;
    padding: 8px 14px;
    font-size: .875rem;
    transition: var(--transition);
  }
  .navbar .dropdown-menu.navbar-dropdown .dropdown-item:hover {
    background: rgba(99,102,241,.15);
    color: #fff;
  }

  /* ── Sidebar ───────────────────────────────────────── */
  .sidebar {
    background: var(--sidebar-bg) !important;
    width: var(--sidebar-w) !important;
    box-shadow: 4px 0 24px rgba(0,0,0,.25) !important;
    border-right: none !important;
  }

  .sidebar .nav { padding: 12px 0; }

  /* profile area */
  .sidebar .nav-item.nav-profile {
    border-bottom: 1px solid rgba(255,255,255,.06);
    margin-bottom: 12px;
    padding-bottom: 12px;
  }
  .sidebar .nav-profile-image { position: relative; }
  .sidebar .nav-profile-image img {
    width: 44px; height: 44px;
    border-radius: 12px;
    object-fit: cover;
    border: 2px solid var(--primary);
  }
  .sidebar .login-status {
    width: 11px; height: 11px;
    border: 2px solid var(--sidebar-bg);
  }
  .sidebar .nav-profile-text .font-weight-bold {
    color: #f1f5f9 !important;
    font-size: .9rem;
    font-weight: 600;
  }
  .sidebar .nav-profile-text .text-secondary {
    color: #64748b !important;
    font-size: .75rem;
  }
  .sidebar .nav-profile-badge { color: var(--success) !important; }

  /* nav items */
  .sidebar .nav-item > .nav-link {
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 10px 20px;
    margin: 2px 10px;
    border-radius: 10px;
    color: var(--sidebar-text) !important;
    font-size: .875rem;
    font-weight: 500;
    transition: var(--transition);
    position: relative;
    overflow: hidden;
  }

  .sidebar .nav-item > .nav-link::before {
    content: '';
    position: absolute;
    inset: 0;
    background: linear-gradient(90deg, rgba(99,102,241,.15), transparent);
    opacity: 0;
    transition: var(--transition);
    border-radius: 10px;
  }

  .sidebar .nav-item > .nav-link:hover {
    color: #e2e8f0 !important;
    background: rgba(255,255,255,.05) !important;
    transform: translateX(3px);
  }
  .sidebar .nav-item > .nav-link:hover::before { opacity: 1; }

  .sidebar .nav-item.active > .nav-link {
    background: linear-gradient(90deg, rgba(99,102,241,.3), rgba(99,102,241,.1)) !important;
    color: #fff !important;
    box-shadow: 0 4px 12px rgba(99,102,241,.25);
  }
  .sidebar .nav-item.active > .nav-link::after {
    content: '';
    position: absolute;
    left: 0; top: 20%; bottom: 20%;
    width: 3px;
    background: var(--primary);
    border-radius: 0 4px 4px 0;
  }

  /* icons */
  .sidebar .menu-icon {
    font-size: 1.2rem;
    color: inherit;
    width: 22px;
    text-align: center;
    flex-shrink: 0;
    order: -1;
  }
  .sidebar .menu-title { flex: 1; }
  .sidebar .menu-arrow {
    font-size: .75rem;
    margin-left: auto;
    color: #475569;
    transition: transform .25s ease;
  }
  .sidebar .nav-link[aria-expanded="true"] .menu-arrow { transform: rotate(90deg); }

  /* sub-menu */
  .sidebar .sub-menu {
    background: rgba(0,0,0,.15);
    border-radius: 10px;
    margin: 2px 10px;
    padding: 4px 0;
  }
  .sidebar .sub-menu .nav-item .nav-link {
    padding: 7px 20px 7px 48px !important;
    color: #64748b !important;
    font-size: .82rem;
    border-radius: 8px;
    margin: 1px 6px;
    transition: var(--transition);
  }
  .sidebar .sub-menu .nav-item .nav-link:hover { color: #e2e8f0 !important; background: rgba(255,255,255,.05) !important; }

  /* section label inside sidebar */
  .sidebar .nav-item.nav-category {
    padding: 14px 20px 4px;
    font-size: .65rem;
    font-weight: 700;
    letter-spacing: .1em;
    text-transform: uppercase;
    color: #334155;
  }

  /* ── Main Panel ────────────────────────────────────── */
  .main-panel { background: var(--body-bg) !important; }

  .content-wrapper {
    padding: 28px 24px !important;
    min-height: calc(100vh - var(--navbar-h) - 56px);
  }

  /* ── Page Header ───────────────────────────────────── */
  .page-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 24px;
    padding-bottom: 20px;
    border-bottom: 1px solid #e2e8f0;
  }

  .page-title {
    font-size: 1.5rem !important;
    font-weight: 700 !important;
    color: #0f172a !important;
    margin: 0 !important;
    letter-spacing: -.02em;
  }

  /* ── Cards ─────────────────────────────────────────── */
  .card {
    background: var(--card-bg) !important;
    border: 1px solid #e2e8f0 !important;
    border-radius: var(--border-radius) !important;
    box-shadow: var(--shadow-sm) !important;
    transition: var(--transition) !important;
  }
  .card:hover { box-shadow: var(--shadow-md) !important; }

  .card-title {
    font-size: 1rem !important;
    font-weight: 600 !important;
    color: #0f172a !important;
    margin-bottom: 16px !important;
  }

  .card-body { padding: 24px !important; }

  /* ── Stat Cards (Dashboard) ────────────────────────── */
  .stat-card {
    overflow: hidden;
    position: relative;
  }
  .stat-card::after {
    content: '';
    position: absolute;
    right: -20px; bottom: -20px;
    width: 120px; height: 120px;
    border-radius: 50%;
    background: rgba(255,255,255,.08);
  }
  .stat-card .card-body { padding: 28px !important; }
  .stat-card h4 { font-size: .875rem !important; font-weight: 600; text-transform: uppercase; letter-spacing: .07em; opacity: .85; }
  .stat-card h2 { font-size: 2.5rem !important; font-weight: 800; line-height: 1; }
  .stat-card .stat-icon {
    position: absolute;
    right: 24px; top: 50%;
    transform: translateY(-50%);
    font-size: 3.5rem;
    opacity: .15;
  }

  .bg-gradient-info  { background: linear-gradient(135deg, #6366f1, #818cf8) !important; }
  .bg-gradient-success { background: linear-gradient(135deg, #10b981, #34d399) !important; }
  .bg-gradient-warning { background: linear-gradient(135deg, #f59e0b, #fbbf24) !important; }
  .bg-gradient-danger  { background: linear-gradient(135deg, #ef4444, #f87171) !important; }

  /* ── Tables ────────────────────────────────────────── */
  .table-responsive { border-radius: 10px; overflow: hidden; }
  .table {
    margin-bottom: 0 !important;
    font-size: .875rem;
  }
  .table thead th {
    background: #f8fafc !important;
    color: #64748b !important;
    font-weight: 600 !important;
    font-size: .75rem !important;
    text-transform: uppercase;
    letter-spacing: .07em;
    border-bottom: 1px solid #e2e8f0 !important;
    padding: 12px 16px !important;
    border-top: none !important;
  }
  .table tbody td {
    border-bottom: 1px solid #f1f5f9 !important;
    padding: 13px 16px !important;
    vertical-align: middle !important;
    color: #334155 !important;
    border-top: none !important;
  }
  .table tbody tr { transition: background .15s ease; }
  .table tbody tr:hover { background: #f8fafc !important; }
  .table.table-striped tbody tr:nth-of-type(odd) { background: transparent !important; }
  .table.table-striped tbody tr:hover { background: #f8fafc !important; }

  /* ── Buttons ───────────────────────────────────────── */
  .btn {
    font-family: 'Inter', sans-serif !important;
    font-weight: 500 !important;
    border-radius: 8px !important;
    transition: var(--transition) !important;
    padding: .45rem 1rem !important;
    font-size: .875rem !important;
    border: none !important;
    box-shadow: none !important;
  }
  .btn:active { transform: scale(.97) !important; }

  .btn-primary, .btn-gradient-primary {
    background: linear-gradient(135deg, var(--primary), var(--primary-dark)) !important;
    color: #fff !important;
  }
  .btn-primary:hover, .btn-gradient-primary:hover {
    background: linear-gradient(135deg, var(--primary-dark), #3730a3) !important;
    box-shadow: 0 4px 14px rgba(99,102,241,.4) !important;
    transform: translateY(-1px);
  }

  .btn-secondary {
    background: #f1f5f9 !important;
    color: #64748b !important;
  }
  .btn-secondary:hover { background: #e2e8f0 !important; color: #334155 !important; }

  .btn-warning {
    background: linear-gradient(135deg, #f59e0b, #fbbf24) !important;
    color: #fff !important;
  }
  .btn-warning:hover { box-shadow: 0 4px 12px rgba(245,158,11,.35) !important; transform: translateY(-1px); }

  .btn-danger {
    background: linear-gradient(135deg, #ef4444, #f87171) !important;
    color: #fff !important;
  }
  .btn-danger:hover { box-shadow: 0 4px 12px rgba(239,68,68,.35) !important; transform: translateY(-1px); }

  .btn-sm { padding: .32rem .75rem !important; font-size: .8rem !important; }

  .btn-block { width: 100% !important; display: block !important; }

  .btn-lg { padding: .72rem 1.5rem !important; font-size: 1rem !important; border-radius: 10px !important; }

  /* ── Forms ─────────────────────────────────────────── */
  .form-control, .form-select {
    font-family: 'Inter', sans-serif !important;
    border: 1.5px solid #e2e8f0 !important;
    border-radius: 10px !important;
    padding: .65rem 1rem !important;
    font-size: .875rem !important;
    color: #334155 !important;
    background: #fff !important;
    transition: var(--transition) !important;
  }
  .form-control:focus, .form-select:focus {
    border-color: var(--primary) !important;
    box-shadow: 0 0 0 3px rgba(99,102,241,.12) !important;
    outline: none !important;
  }
  .form-control-lg { padding: .8rem 1.1rem !important; font-size: 1rem !important; }
  .form-label {
    font-weight: 600 !important;
    font-size: .8rem !important;
    color: #64748b !important;
    text-transform: uppercase;
    letter-spacing: .05em;
    margin-bottom: 6px !important;
  }
  .form-group { margin-bottom: 1rem; }

  /* ── Alerts ────────────────────────────────────────── */
  .alert {
    border: none !important;
    border-radius: 10px !important;
    padding: 12px 16px !important;
    font-size: .875rem !important;
    font-weight: 500 !important;
  }
  .alert-danger { background: #fef2f2 !important; color: #dc2626 !important; border-left: 3px solid #ef4444 !important; }
  .alert-success { background: #f0fdf4 !important; color: #16a34a !important; border-left: 3px solid #10b981 !important; }

  /* ── Footer ────────────────────────────────────────── */
  .footer {
    background: #fff !important;
    border-top: 1px solid #e2e8f0 !important;
    padding: 16px 24px !important;
    font-size: .8rem !important;
    color: #94a3b8 !important;
  }
  .footer a { color: var(--primary) !important; text-decoration: none !important; }
  .footer a:hover { text-decoration: underline !important; }

  /* ── Breadcrumb ─────────────────────────────────────── */
  .breadcrumb-nav {
    display: flex;
    align-items: center;
    gap: 8px;
    margin-bottom: 6px;
    font-size: .8rem;
    color: #94a3b8;
  }
  .breadcrumb-nav a { color: var(--primary); text-decoration: none; }
  .breadcrumb-nav a:hover { text-decoration: underline; }
  .breadcrumb-nav .sep { color: #cbd5e1; }

  /* ── Badge ─────────────────────────────────────────── */
  .badge-category {
    display: inline-flex;
    align-items: center;
    background: #ede9fe;
    color: var(--primary-dark);
    border-radius: 20px;
    padding: 3px 10px;
    font-size: .75rem;
    font-weight: 600;
  }

  /* ── Collapse animation ─────────────────────────────── */
  .collapse { transition: height .3s ease; }

  /* ── Auth pages global ──────────────────────────────── */
  .auth-full-screen {
    min-height: 100vh;
    background: linear-gradient(135deg, #0f172a 0%, #1e1b4b 60%, #0f172a 100%);
    display: flex;
    align-items: center;
    justify-content: center;
    position: relative;
    overflow: hidden;
  }
  .auth-full-screen::before {
    content: '';
    position: absolute;
    width: 600px; height: 600px;
    background: radial-gradient(circle, rgba(99,102,241,.25) 0%, transparent 70%);
    top: -100px; right: -100px;
    pointer-events: none;
  }
  .auth-full-screen::after {
    content: '';
    position: absolute;
    width: 400px; height: 400px;
    background: radial-gradient(circle, rgba(6,182,212,.15) 0%, transparent 70%);
    bottom: -80px; left: -80px;
    pointer-events: none;
  }

  /* ── Utility ────────────────────────────────────────── */
  .text-muted { color: #94a3b8 !important; }
  .font-weight-bold { font-weight: 700 !important; }
  .grid-margin { margin-bottom: 24px !important; }
  .stretch-card { display: flex !important; }
  .stretch-card > .card { width: 100%; }
  .page-body-wrapper { padding-top: var(--navbar-h) !important; }

  /* ── Responsive ──────────────────────────────────────── */
  @media (max-width: 991px) {
    .sidebar { width: 100% !important; }
    .content-wrapper { padding: 20px 16px !important; }
    .page-title { font-size: 1.25rem !important; }
  }
</style>