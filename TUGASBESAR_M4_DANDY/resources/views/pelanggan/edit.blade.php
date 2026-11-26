<x-app-layout>

    <div class="welcome-banner">
        <h1>Edit Pelanggan 👥</h1>
        <p>Perbarui biodata dan catatan penanganan pelanggan.</p>
    </div>

    <div class="info-panel">
        <h2 style="margin-bottom: 8px;">Form Edit Pelanggan</h2>
        <p style="color: #8290A3; font-size: 13px; margin-bottom: 24px;">
            Ubah data yang diperlukan, lalu simpan.
        </p>

        <form action="{{ route('pelanggan.update', $pelanggan) }}" method="POST">
            @method('PUT')
            @include('pelanggan._form')
        </form>
    </div>

</x-app-layout>
