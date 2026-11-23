@extends('layouts.app')

@section('content')
  <div class="error-page">
    <h1>403</h1>
    <p>Anda tidak memiliki hak akses untuk halaman atau aksi ini.</p>
    <a class="link" href="{{ url('/') }}">Kembali ke beranda</a>
  </div>
@endsection
