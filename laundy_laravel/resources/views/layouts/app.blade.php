<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Layanan Laundry</title>
  <link rel="stylesheet" href="{{ asset('css/laundry_laravel.css') }}">
</head>
<body>
  @auth
    <nav class="topbar">
      <div class="menu">
        @can('layanan.lihat') <a href="{{ route('layanan.index') }}">Layanan &amp; Tarif</a> @endcan
        @can('pesanan.lihat') <a href="{{ route('pesanan.index') }}">Pesanan</a> @endcan
      </div>
      <div class="user">
        <span>{{ auth()->user()->name }} <span class="badge badge-{{ auth()->user()->role }}">{{ auth()->user()->role }}</span></span>
        <form method="POST" action="{{ route('logout') }}" class="inline-form">
          @csrf
          <button type="submit" class="btn btn-sm">Keluar</button>
        </form>
      </div>
    </nav>
  @endauth

  <main class="container wide">
    @yield('content')
  </main>
</body>
</html>
