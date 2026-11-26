<x-app-layout>

    <!-- WELCOME BANNER -->
    <div class="welcome-banner">
        <h1>Selamat Datang, {{ Auth::user()->name }}! 👋</h1>

        <p>
            Selamat datang di Sistem Operasional Laundry.
            Kelola seluruh aktivitas operasional laundry melalui
            satu aplikasi yang terintegrasi.
        </p>
    </div>

    <!-- JUDUL -->
    <h2 class="section-title">
        Manajemen Laundry
    </h2>

    <!-- KARTU MODUL -->
    <div class="stats-grid">

        <!-- LAYANAN & TARIF -->
        <a href="{{ route('layanan.index') }}" class="module-card module-link">
            <div class="module-icon icon-blue">💰</div>

            <h3>Layanan & Tarif</h3>

            <p>
                Mengelola paket layanan, jenis laundry,
                dan harga setiap layanan.
            </p>
        </a>

        <!-- PESANAN -->
        <a href="{{ route('pesanan.index') }}" class="module-card module-link">
            <div class="module-icon icon-orange">📋</div>

            <h3>Pesanan</h3>

            <p>
                Mencatat pesanan pelanggan dan memantau
                status pengerjaan laundry.
            </p>
        </a>

        <!-- MESIN & PERALATAN -->
        <a href="{{ route('mesin.index') }}" class="module-card module-link">
            <div class="module-icon icon-green">🧺</div>

            <h3>Mesin & Peralatan</h3>

            <p>
                Mengelola data mesin, kapasitas,
                merek, dan status operasional.
            </p>
        </a>

        <!-- DATA PELANGGAN -->
        <a href="{{ route('pelanggan.index') }}" class="module-card module-link">
            <div class="module-icon icon-purple">👥</div>

            <h3>Data Pelanggan</h3>

            <p>
                Mengelola informasi pelanggan,
                kontak, dan catatan khusus.
            </p>
        </a>

        <!-- BAHAN PEMBERSIH -->
        <div class="module-card">
            <div class="module-icon icon-orange">🧴</div>

            <h3>Bahan Pembersih</h3>

            <p>
                Mengelola persediaan deterjen,
                pewangi, dan bahan pembersih.
            </p>
        </div>

        </div>

    <!-- INFORMASI -->
    <div class="info-panel">
        <h2>Informasi Sistem</h2>

        <p>
            Sistem Operasional Laundry merupakan aplikasi
            untuk membantu pengelolaan layanan dan tarif,
            mesin dan peralatan, data pelanggan, serta
            persediaan bahan pembersih secara terintegrasi.
        </p>
    </div>

</x-app-layout>
