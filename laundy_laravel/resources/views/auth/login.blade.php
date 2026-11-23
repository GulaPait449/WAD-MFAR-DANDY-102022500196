@extends('layouts.app')

@section('content')
  <div class="login-box">
    <h2>Masuk</h2>

    @if ($errors->any())
      <div class="alert error">{{ $errors->first() }}</div>
    @endif

    <form method="POST" action="{{ route('login') }}">
      @csrf
      <label for="email">Email</label>
      <input type="email" id="email" name="email" value="{{ old('email') }}" required autofocus>

      <label for="password">Password</label>
      <input type="password" id="password" name="password" required>

      <button type="submit" class="btn">Masuk</button>
    </form>

    <div class="akun-uji">
      Akun uji (password: <code>password</code>):<br>
      admin@laundry.test, petugas@laundry.test, pemilik@laundry.test
    </div>
  </div>
@endsection
