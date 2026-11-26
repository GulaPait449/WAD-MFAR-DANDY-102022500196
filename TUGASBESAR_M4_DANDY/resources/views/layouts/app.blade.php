<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Sistem Operasional Laundry') }}</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="{{ asset('css/laundry_layanan.css') }}">
</head>

<body>

    <div class="app-container">

        <!-- NAVBAR -->
        <nav class="topbar">

            <div class="brand">
                <div class="brand-icon">🧺</div>
                <span>Sistem Operasional Laundry</span>
            </div>

            <div class="topbar-actions">
                <span class="user-chip">
                    👤 {{ Auth::user()->name }}
                </span>

                <a href="{{ route('profile.edit') }}"
                   style="color:white; text-decoration:none; font-size:13px;">
                    Profile
                </a>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="logout-btn">
                        Logout
                    </button>
                </form>
            </div>

        </nav>

        <div class="app-body">

            <!-- SIDEBAR -->
            <aside class="sidebar">

                <div class="sidebar-heading">
                    MENU UTAMA
                </div>

                <a href="{{ route('dashboard') }}"
                   class="sidebar-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                    <span class="sidebar-icon">🏠</span>
                    Dashboard
                </a>

                @can('mesin.lihat')
                <a href="{{ route('mesin.index') }}"
                   class="sidebar-link {{ request()->routeIs('mesin.*') ? 'active' : '' }}">
                    <span class="sidebar-icon">🧺</span>
                    Mesin & Peralatan
                </a>
                @endcan

                @can('layanan.lihat')
                <a href="{{ route('layanan.index') }}"
                   class="sidebar-link {{ request()->routeIs('layanan.*') ? 'active' : '' }}">
                    <span class="sidebar-icon">💰</span>
                    Layanan & Tarif
                </a>
                @endcan

                @can('pesanan.lihat')
                <a href="{{ route('pesanan.index') }}"
                   class="sidebar-link {{ request()->routeIs('pesanan.*') ? 'active' : '' }}">
                    <span class="sidebar-icon">📋</span>
                    Pesanan
                </a>
                @endcan

                @can('pelanggan.lihat')
                <a href="{{ route('pelanggan.index') }}"
                    class="sidebar-link {{ request()->routeIs('pelanggan.*') ? 'active' : '' }}">
                    <span class="sidebar-icon">👥</span>
                    Data Pelanggan
                </a>
                @endcan
                
            </aside>

            <!-- KONTEN -->
            <main class="main-content">

                {{-- Mendukung <x-app-layout> ($slot) dan @extends('layouts.app') (@section('content')) --}}
                @isset($slot)
                    {{ $slot }}
                @else
                    <div class="laundry-page">
                        @yield('content')
                    </div>
                @endisset

            </main>

        </div>

    </div>

</body>
</html>
