@extends('errors.minimal')

@section('title', '404 - Halaman tidak ditemukan')

@section('content')


<div style="min-height: 70vh; display: flex; flex-direction: column; justify-content: center; align-items: center; text-align: center; background: #fff;">
    <div style="font-size: 64px; font-weight: bold; color: #764ba2; margin-bottom: 16px;">404 😢</div>
    <div style="font-size: 18px; margin-bottom: 32px;">Halaman yang kamu cari tidak ditemukan.</div>
    <a href="{{ url('/') }}" style="display:inline-block; padding:12px 25px; background:#764ba2; color:#fff; border-radius:50px; text-decoration:none; font-weight:bold; margin-top:8px;">⬅ Kembali ke Beranda</a>
</div>
@endsection