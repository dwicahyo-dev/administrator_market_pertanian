<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
  <meta charset="UTF-8">
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <title>Halaman Admin - @yield('title')</title>

  <!-- CSS -->
  @include('layouts.css') @yield('css')

</head>

<body>
  <div id="app">
    <div class="main-wrapper main-wrapper-1">
      <div class="navbar-bg"></div>

      <!-- NAVBAR -->
      @include('layouts.navbar')

      <!-- SIDEBAR -->
      @include('layouts.sidebar')

      <!-- Main Content -->
      <div class="main-content">
        @yield('content')

      </div>

      <!-- FOOTER -->
      @include('layouts.footer')

    </div>
  </div>
  @include('layouts.js') @yield('script')

</body>

</html>