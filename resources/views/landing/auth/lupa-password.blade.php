@extends('layouts.app')

@section('title', 'Lupa Password')

@section('content')

<div class="min-h-screen bg-[#FFF8F8] pb-12">

    {{-- TOPBAR --}}
    <div class="h-14 bg-gradient-to-r from-pink-100 to-[#DCE8B4] flex items-center justify-between px-4 md:px-10">

        {{-- LOGO --}}
        <div class="flex items-center gap-2">

            <h1 class="text-2xl md:text-3xl font-bold text-[#F07A8D]">
                Vellora
            </h1>

            <span class="text-lg md:text-xl font-bold text-gray-500">
                Seller
            </span>

        </div>

        {{-- RIGHT --}}
        <p class="text-sm md:text-lg">
            Butuh bantuan?
            <span class="text-[#FF5A5A] font-semibold cursor-pointer">
                Hubungi Kami
            </span>
        </p>

    </div>

    {{-- CONTENT --}}
    <div class="flex flex-col lg:flex-row items-center justify-center gap-10 lg:gap-20 px-4 md:px-14 py-12">

        {{-- LEFT --}}
        <div class="w-full max-w-[500px]">

            {{-- TITLE --}}
            <h2 class="text-3xl md:text-4xl font-bold text-center leading-snug">
                Buat
                <span class="text-[#F07A8D]">
                    Password Baru
                </span>
            </h2>

            <p class="text-center text-lg md:text-xl mt-3 leading-relaxed">
                Masukkan email yang terdaftar
                <br class="hidden sm:block">
                pada akun Vellora Seller untuk
                <br class="hidden sm:block">
                menerima kode verifikasi.
            </p>

            {{-- IMAGE --}}
            <div class="flex justify-center mt-8">

                <img
                    src="{{ asset('images/illustrasi2.png') }}"
                    class="w-[180px] md:w-[220px] h-auto"
                    alt="Illustration">

            </div>

            {{-- FEATURES --}}
            <div class="grid grid-cols-3 gap-3 md:gap-6 mt-8">

                {{-- ITEM --}}
                <div class="text-center">

                    <div class="w-12 h-12 md:w-16 md:h-16 rounded-full bg-[#D9E8B4] flex items-center justify-center mx-auto">
                        <i class="ri-shield-check-line text-2xl md:text-3xl text-[#FF6A6A]"></i>
                    </div>

                    <h3 class="font-bold text-xs md:text-base mt-3">
                        Aman & Terpercaya
                    </h3>

                    <p class="text-xs text-gray-500 mt-1 leading-relaxed hidden sm:block">
                        Kami menjaga keamanan akun Anda
                    </p>

                </div>

                {{-- ITEM --}}
                <div class="text-center">

                    <div class="w-12 h-12 md:w-16 md:h-16 rounded-full bg-[#D9E8B4] flex items-center justify-center mx-auto">
                        <i class="ri-mail-line text-2xl md:text-3xl text-[#FF6A6A]"></i>
                    </div>

                    <h3 class="font-bold text-xs md:text-base mt-3">
                        Kode Verifikasi
                    </h3>

                    <p class="text-xs text-gray-500 mt-1 leading-relaxed hidden sm:block">
                        Kode dikirim ke email terdaftar Anda
                    </p>

                </div>

                {{-- ITEM --}}
                <div class="text-center">

                    <div class="w-12 h-12 md:w-16 md:h-16 rounded-full bg-[#D9E8B4] flex items-center justify-center mx-auto">
                        <i class="ri-refresh-line text-2xl md:text-3xl text-[#FF6A6A]"></i>
                    </div>

                    <h3 class="font-bold text-xs md:text-base mt-3">
                        Proses Mudah
                    </h3>

                    <p class="text-xs text-gray-500 mt-1 leading-relaxed hidden sm:block">
                        Atur ulang password hanya dalam beberapa langkah
                    </p>

                </div>

            </div>

        </div>

        {{-- RIGHT --}}
        <div class="w-full max-w-[420px] bg-white/95 backdrop-blur-sm rounded-[28px] px-6 py-10 md:px-10 md:py-12 shadow-lg border border-white">

            {{-- TITLE --}}
            <h1 class="text-3xl md:text-4xl font-bold text-center">
                Lupa Password
            </h1>

            <p class="text-center text-sm md:text-lg mt-2 leading-relaxed text-gray-500">
                Masukkan email Anda untuk menerima kode verifikasi
            </p>

            {{-- FORM --}}
            <form
            method="POST"
            class="mt-8"
            action="{{ route('lupa-password.send') }}">
                @csrf

                @if(session('error'))
                    <div class="mb-4 rounded-2xl bg-red-500/10 border border-red-200 px-5 py-3 text-red-600 text-sm font-semibold">
                        {{ session('error') }}
                    </div>
                @endif

                {{-- EMAIL --}}
                <div>

                    <label class="text-lg font-bold">
                        Email
                    </label>

                    <input
                    type="email"
                    name="email"
                    value="{{ old('email') }}"
                    required
                    class="w-full h-[48px] bg-[#FCFCFC] border border-[#B8C0C7] rounded-full px-5 text-sm mt-2 outline-none shadow-sm focus:border-pink-300 transition">

                </div>

                {{-- BUTTON --}}
                <button
                type="submit"
                class="w-full h-[50px] bg-pink-100 rounded-full text-base md:text-lg font-bold mt-6 hover:bg-pink-200 transition">
                    Kirim Kode Verifikasi
                </button>

            </form>

            {{-- INFO --}}
            <div class="bg-[#F5F8FF] border border-[#DCE7FF] rounded-2xl px-4 py-3 mt-8 flex gap-3">

                {{-- ICON --}}
                <div class="flex-shrink-0">

                    <div class="w-9 h-9 rounded-full bg-[#3B82F6] flex items-center justify-center">
                        <i class="ri-information-line text-lg text-white"></i>
                    </div>

                </div>

                {{-- TEXT --}}
                <div>

                    <h3 class="font-semibold text-sm text-[#24446B]">
                        Informasi Verifikasi
                    </h3>

                    <p class="text-xs text-[#4F647D] leading-relaxed mt-1">
                        Kami akan mengirimkan kode verifikasi ke email Anda. 
                        Pastikan untuk memeriksa folder Spam atau Promosi jika email tidak ditemukan di inbox.
                    </p>

                </div>

            </div>

            {{-- BACK --}}
            <div class="flex justify-center mt-8">

                <a
                href="{{ route('login') }}"
                class="flex items-center gap-2 text-base md:text-lg font-semibold hover:text-[#F07A8D] transition">
                    <i class="ri-arrow-left-line text-2xl"></i>
                    <span>Kembali ke Login</span>
                </a>

            </div>

        </div>

    </div>

</div>

@endsection