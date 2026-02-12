<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', config('app.name', 'Laravel'))</title>

    {{-- Global CSS (Style Global) --}}
    @include('layouts.style-global')

    {{-- Style Page: per-page CSS --}}
    @stack('style-page')
  </head>
  <body>
    <div class="container-scroller">

      {{-- Navbar --}}
      @include('layouts.navbar')

      <div class="container-fluid page-body-wrapper">

        {{-- Sidebar --}}
        @include('layouts.sidebar')

        {{-- Main content wrapper --}}
        <div class="main-panel">
          <div class="content-wrapper">
            @yield('content')
          </div>

          {{-- Footer --}}
          @include('layouts.footer')
        </div>
      </div>
    </div>

    {{-- Global JS (Script Global) --}}
    @include('layouts.script-global')

    {{-- Script Page: per-page JS --}}
    @stack('script-page')
  </body>
</html>