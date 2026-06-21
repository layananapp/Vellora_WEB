@extends('layouts.app')

@section('title', 'Tentang Kami')

@section('content')

<div class="w-full min-h-screen bg-[#F5F5F5]">

    {{-- Top Bar --}}
    <div class="bg-[#DDE8C8] px-4 md:px-10 py-3 flex items-center gap-3">

        <span class="text-[#FF8E8E] text-lg">
            🚚
        </span>

        <p class="text-sm font-medium text-[#3B302A]">
            Gratis Pengiriman untuk Semua Order
        </p>

    </div>

    {{-- Header --}}
    <div class="flex flex-col sm:flex-row items-center justify-between gap-4 px-4 md:px-10 py-6">

        {{-- Left --}}
        <div class="flex items-center gap-2 md:gap-4 text-xl md:text-3xl font-bold flex-wrap justify-center sm:justify-start">

            <a href="/">
                ←
            </a>

            <span>
                Belanja
            </span>

            <span>
                ›
            </span>

            <span>
                Tentang Kami
            </span>

        </div>

        {{-- Login --}}
        <div class="flex items-center gap-2">

            <span class="text-2xl md:text-3xl">
                👤
            </span>

            <span class="font-semibold">
                Masuk
            </span>

        </div>

    </div>

    {{-- Content --}}
    <div class="flex flex-col items-center justify-center mt-10 px-4">

        <h1 class="text-3xl md:text-5xl font-bold text-[#1E1E1E] text-center">
            Tentang Kami
        </h1>

        {{-- Icon --}}
        <div class="mt-8 text-7xl md:text-9xl">
            🛍️
        </div>

        {{-- Description --}}
        <p class="text-center text-lg md:text-2xl text-[#3B302A] leading-relaxed max-w-4xl mt-10">
            Vellora hadir untuk memberikan pengalaman belanja
            fashion & lifestyle modern yang lebih mudah,
            aman, dan menyenangkan bagi semua orang.
        </p>

        {{-- Button --}}
        <button class="mt-10 bg-pink-400 hover:bg-pink-500 transition text-white font-bold px-8 py-3 md:px-10 md:py-4 rounded-full text-xl md:text-2xl">
            Belanja Sekarang
        </button>

    </div>

    {{-- Footer --}}
    @include('landing.components.footer')

</div>

@endsection