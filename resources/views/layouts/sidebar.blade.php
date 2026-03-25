<nav class="sidebar sidebar-offcanvas" id="sidebar">
  <ul class="nav">
    <li class="nav-item nav-profile">
      <a href="#" class="nav-link">
        <div class="nav-profile-image">
          <img src="{{ asset('assets/images/faces/face1.jpg') }}" alt="profile" />
          <span class="login-status online"></span>
        </div>
        <div class="nav-profile-text d-flex flex-column">
          <span class="font-weight-bold mb-2">{{ Auth::user()->name ?? 'Guest' }}</span>
          <span class="text-secondary text-small">Project Manager</span>
        </div>
        <i class="mdi mdi-bookmark-check text-success nav-profile-badge"></i>
      </a>
    </li>
    
    <li class="nav-item {{ Request::is('home') ? 'active' : '' }}">
      <a class="nav-link" href="/home">
        <span class="menu-title">Dashboard</span>
        <i class="mdi mdi-home menu-icon"></i>
      </a>
    </li>

    <li class="nav-item {{ Request::is('kategori*') ? 'active' : '' }}">
      <a class="nav-link" href="{{ route('kategori.index') }}">
        <span class="menu-title">Kategori</span>
        <i class="mdi mdi-format-list-bulleted menu-icon"></i>
      </a>
    </li>

    <li class="nav-item {{ Request::is('buku*') ? 'active' : '' }}">
      <a class="nav-link" href="{{ route('buku.index') }}">
        <span class="menu-title">Buku</span>
        <i class="mdi mdi-book-open-page-variant menu-icon"></i>
      </a>
    </li>
    <li class="nav-item {{ Request::is('barang*') ? 'active' : '' }}">
      <a class="nav-link" href="{{ url('/barang') }}">
        <span class="menu-title">Barang UMKM</span>
        <i class="mdi mdi-package-variant-closed menu-icon"></i>
      </a>
    </li>
    <li class="nav-item {{ Request::is('pos*') ? 'active' : '' }}">
      <a class="nav-link" data-bs-toggle="collapse" href="#ui-pos" aria-expanded="{{ Request::is('pos*') ? 'true' : 'false' }}" aria-controls="ui-pos">
        <span class="menu-title">Kasir / POS</span>
        <i class="mdi mdi-cart menu-icon"></i>
        <i class="menu-arrow"></i>
      </a>
      <div class="collapse {{ Request::is('pos*') ? 'show' : '' }}" id="ui-pos">
        <ul class="nav flex-column sub-menu">
          <li class="nav-item">
            <a class="nav-link" href="{{ route('pos.index') }}">AJAX jQuery</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="{{ route('pos.axios') }}">Axios</a>
          </li>
        </ul>
      </div>
    </li>
    <li class="nav-item {{ Request::is('wilayah*') ? 'active' : '' }}">
      <a class="nav-link" data-bs-toggle="collapse" href="#ui-wilayah" aria-expanded="{{ Request::is('wilayah*') ? 'true' : 'false' }}" aria-controls="ui-wilayah">
        <span class="menu-title">Wilayah</span>
        <i class="mdi mdi-map-marker menu-icon"></i>
        <i class="menu-arrow"></i>
      </a>
      <div class="collapse {{ Request::is('wilayah*') ? 'show' : '' }}" id="ui-wilayah">
        <ul class="nav flex-column sub-menu">
          <li class="nav-item">
            <a class="nav-link" href="{{ route('wilayah.index') }}">AJAX (jQuery)</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="{{ route('wilayah.axios') }}">Axios (Vanilla JS)</a>
          </li>
        </ul>
      </div>
    </li>
    <li class="nav-item {{ Request::is('simulasi*') ? 'active' : '' }}">
      <a class="nav-link" data-bs-toggle="collapse" href="#ui-simulasi" aria-expanded="{{ Request::is('simulasi*') ? 'true' : 'false' }}" aria-controls="ui-simulasi">
        <span class="menu-title">Simulasi Modul 4</span>
        <i class="mdi mdi-flask menu-icon"></i>
        <i class="menu-arrow"></i>
      </a>
      <div class="collapse {{ Request::is('simulasi*') ? 'show' : '' }}" id="ui-simulasi">
        <ul class="nav flex-column sub-menu">
          <li class="nav-item">
            <a class="nav-link" href="{{ route('simulasi.dom') }}">DOM</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="{{ route('simulasi.datatables') }}">DataTables</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="{{ route('simulasi.select') }}">Select</a>
          </li>
        </ul>
      </div>
    </li>
    <li class="nav-item">
      <a class="nav-link" data-bs-toggle="collapse" href="#pdf-dropdown" aria-expanded="false" aria-controls="pdf-dropdown">
        <span class="menu-title">Export PDF</span>
        <i class="mdi mdi-file-pdf menu-icon"></i>
        <i class="menu-arrow"></i>
      </a>
      <div class="collapse" id="pdf-dropdown">
        <ul class="nav flex-column sub-menu">
          <li class="nav-item">
            <a class="nav-link" href="{{ url('/preview-sertifikat') }}">Sertifikat (Landscape)</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="{{ url('/preview-undangan') }}">Undangan (Portrait)</a>
          </li>
        </ul>
      </div>
    </li>
  </ul>
</nav>