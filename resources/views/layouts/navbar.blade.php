<nav class="navbar default-layout-navbar col-lg-12 col-12 p-0 fixed-top d-flex flex-row">
  <div class="text-center navbar-brand-wrapper d-flex align-items-center justify-content-start">
    <a class="navbar-brand brand-logo d-flex align-items-center gap-2" href="{{ url('/') }}">
      <div style="width:36px;height:36px;background:linear-gradient(135deg,#6366f1,#818cf8);border-radius:10px;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
        <i class="mdi mdi-book-open-variant" style="color:#fff;font-size:1.2rem;"></i>
      </div>
      <span style="color:#f1f5f9;font-weight:700;font-size:1rem;letter-spacing:-.02em;line-height:1.2;">Koleksi<br><span style="color:#818cf8;font-weight:400;font-size:.75rem;letter-spacing:.02em;">Buku</span></span>
    </a>
    <a class="navbar-brand brand-logo-mini" href="{{ url('/') }}">
      <div style="width:32px;height:32px;background:linear-gradient(135deg,#6366f1,#818cf8);border-radius:9px;display:flex;align-items:center;justify-content:center;">
        <i class="mdi mdi-book-open-variant" style="color:#fff;font-size:1rem;"></i>
      </div>
    </a>
  </div>

  <div class="navbar-menu-wrapper d-flex align-items-stretch">
    {{-- Sidebar Toggle --}}
    <button class="navbar-toggler navbar-toggler align-self-center" type="button" data-toggle="minimize">
      <span class="mdi mdi-menu"></span>
    </button>

    {{-- Search --}}
    <div class="search-field d-none d-md-block ms-3" style="max-width:280px;">
      <form class="d-flex align-items-center h-100" action="#">
        <div class="input-group">
          <div class="input-group-prepend bg-transparent">
            <i class="input-group-text border-0 mdi mdi-magnify" style="color:#64748b;"></i>
          </div>
          <input type="text" class="form-control bg-transparent border-0" placeholder="Cari...">
        </div>
      </form>
    </div>

    {{-- Right Icons --}}
    <ul class="navbar-nav navbar-nav-right">
      {{-- Profile Dropdown --}}
      <li class="nav-item nav-profile dropdown">
        <a class="nav-link dropdown-toggle d-flex align-items-center gap-2 pe-0" id="profileDropdown" href="#" data-bs-toggle="dropdown" aria-expanded="false">
          <div class="nav-profile-img" style="position:relative;">
            <div style="width:36px;height:36px;border-radius:50%;background:linear-gradient(135deg,#6366f1,#818cf8);display:flex;align-items:center;justify-content:center;border:2px solid rgba(99,102,241,.5);font-weight:700;color:#fff;font-size:.9rem;">
              {{ strtoupper(substr(Auth::user()->name ?? 'U', 0, 1)) }}
            </div>
            <span class="availability-status online" style="position:absolute;bottom:0;right:0;width:9px;height:9px;background:#10b981;border-radius:50%;border:2px solid #0f172a;"></span>
          </div>
          <div class="nav-profile-text d-none d-sm-block">
            <p class="mb-0" style="font-size:.83rem;font-weight:600;color:#e2e8f0;">{{ Auth::user()->name ?? 'User' }}</p>
          </div>
        </a>
        <div class="dropdown-menu navbar-dropdown dropdown-menu-end" aria-labelledby="profileDropdown">
          <div class="px-3 py-2 mb-1" style="border-bottom:1px solid rgba(255,255,255,.07);">
            <p class="mb-0" style="font-size:.85rem;font-weight:600;color:#f1f5f9;">{{ Auth::user()->name ?? 'User' }}</p>
            <p class="mb-0" style="font-size:.75rem;color:#64748b;">{{ Auth::user()->email ?? '' }}</p>
          </div>
          <a class="dropdown-item d-flex align-items-center gap-2" href="#"
             onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
            <i class="mdi mdi-logout" style="font-size:1rem;color:#ef4444;"></i>
            <span>Keluar</span>
          </a>
          <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
            @csrf
          </form>
        </div>
      </li>
    </ul>

    {{-- Mobile Toggle --}}
    <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button" data-toggle="offcanvas">
      <span class="mdi mdi-menu"></span>
    </button>
  </div>
</nav>