<x-app-layout>

    <div class="welcome-banner">
        <h1>Tambah Pelanggan 👥</h1>
        <p>Masukkan biodata, nomor telepon, dan catatan penanganan khusus pakaian.</p>
    </div>

    <div class="info-panel">
        <h2 style="margin-bottom: 8px;">Form Tambah Pelanggan</h2>
        <p style="color: #8290A3; font-size: 13px; margin-bottom: 24px;">
            Lengkapi informasi pelanggan di bawah ini.
        </p>

        <form action="{{ route('pelanggan.store') }}" method="POST">
            @include('pelanggan._form')
        </form>
    </div>

</x-app-layout>
