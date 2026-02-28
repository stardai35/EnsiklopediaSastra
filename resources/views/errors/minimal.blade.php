@extends('layouts.app')

@section('title', __('Terjadi Galat'))

@section('content')
<div class="container min-vh-100 d-flex flex-column justify-content-center align-items-center bg-light">
    <div class="text-center">
        <h1 class="display-1 text-danger">@yield('code', 'Oops!')</h1>
        <h2 class="mb-4">@yield('message', __('Terjadi kesalahan pada sistem.'))</h2>
        <a href="{{ url('/') }}" class="btn btn-primary mt-3">Kembali ke Beranda</a>
    </div>
</div>
@endsection
