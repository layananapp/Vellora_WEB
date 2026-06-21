@extends('layouts.app')

@section('title', 'Reset Password')

@section('content')

<div class="min-h-screen bg-[#FFF8F8] pb-12">

    {{-- TOPBAR --}}
    <div class="h-12 bg-gradient-to-r from-pink-100 to-[#DCE8B4] flex items-center justify-between px-4 md:px-10">

        {{-- LOGO --}}
        <div class="flex items-center gap-2">

            <h1 class="text-xl md:text-2xl font-bold text-[#F07A8D]">
                Vellora
            </h1>

            <span class="text-base md:text-lg font-bold text-gray-500">
                Seller
            </span>

        </div>

        {{-- RIGHT --}}
        <p class="text-sm md:text-base">
            Butuh bantuan?
            <span class="text-[#FF5A5A] font-semibold cursor-pointer">
                Hubungi Kami
            </span>
        </p>

    </div>

    {{-- CONTENT --}}
    <div class="max-w-6xl mx-auto flex flex-col lg:flex-row items-center justify-center gap-10 lg:gap-16 px-4 md:px-10 py-10">

        {{-- LEFT --}}
        <div class="w-full max-w-[400px] text-center">

            {{-- TITLE --}}
            <h2 class="text-3xl md:text-4xl font-bold leading-snug">
                Buat
                <span class="text-[#F07A8D]">
                    Password Baru
                </span>
            </h2>

            <p class="text-lg md:text-xl mt-3 leading-relaxed text-gray-700">
                Buat password baru yang kuat untuk menjaga keamanan akun anda
            </p>

            {{-- ICON --}}
            <div class="flex justify-center mt-6 md:mt-10">

                <div class="w-24 h-24 md:w-32 md:h-32 rounded-full bg-[#FFE5EA] flex items-center justify-center shadow-sm">
                    <i class="ri-lock-password-line text-4xl md:text-6xl text-[#F07A8D]"></i>
                </div>

            </div>

            {{-- TIPS --}}
            <div class="bg-[#D9E8B4] rounded-[24px] px-6 py-5 mt-8 md:mt-10 text-left shadow-sm">

                <h3 class="font-bold text-[#F07A8D] text-base">
                    Tips Membuat Password yang Kuat
                </h3>

                <ul class="mt-3 space-y-1 text-sm leading-relaxed">
                    <li>- Minimal 8 karakter</li>
                    <li>- Mengandung huruf besar dan kecil</li>
                    <li>- Mengandung angka</li>
                </ul>

            </div>

        </div>

        {{-- RIGHT --}}
        <div class="w-full max-w-[400px] bg-white rounded-[30px] px-6 py-10 md:px-10 md:py-12 shadow-md border border-gray-100">

            {{-- TITLE --}}
            <h1 class="text-2xl md:text-3xl font-bold text-center">
                Reset Password
            </h1>

            <p class="text-center text-sm md:text-base mt-2 leading-relaxed text-gray-500">
                Masukkan password baru untuk akun anda
            </p>

            {{-- FORM --}}
            <form
            method="POST"
            action="{{ route('reset-password.submit') }}"
            class="mt-8"
            x-data="{
                password: '',
                confirmPassword: ''
            }">
                @csrf

                @if(session('error'))
                    <div class="mb-4 rounded-2xl bg-red-500/10 border border-red-200 px-5 py-3 text-red-600 text-sm font-semibold">
                        {{ session('error') }}
                    </div>
                @endif

                {{-- PASSWORD --}}
                <div>

                    <label class="text-base md:text-lg font-bold">
                        Password Baru
                    </label>

                    <input
                    type="password"
                    name="password"
                    x-model="password"
                    required
                    class="w-full h-[48px] bg-[#FCFCFC] border border-[#B8C0C7] rounded-full px-5 text-sm mt-2 outline-none shadow-sm focus:border-pink-300 transition">

                </div>

                {{-- KONFIRMASI --}}
                <div class="mt-5">

                    <label class="text-base md:text-lg font-bold">
                        Konfirmasi Password
                    </label>

                    <input
                    type="password"
                    name="password_confirmation"
                    x-model="confirmPassword"
                    required
                    class="w-full h-[48px] bg-[#FCFCFC] border border-[#B8C0C7] rounded-full px-5 text-sm mt-2 outline-none shadow-sm focus:border-pink-300 transition">

                    {{-- ERROR --}}
                    <p
                    x-show="confirmPassword && password !== confirmPassword"
                    class="text-red-500 text-xs mt-2"
                    style="display: none;">
                        Password tidak sama
                    </p>

                </div>

                {{-- BUTTON --}}
                <button
                type="submit"
                :disabled="password !== confirmPassword || !password || !confirmPassword || password.length < 8"
                :class="
                    password === confirmPassword && password && confirmPassword && password.length >= 8
                    ? 'bg-pink-100 hover:bg-pink-200 cursor-pointer'
                    : 'bg-gray-200 text-gray-400 cursor-not-allowed'
                "
                class="w-full h-[50px] rounded-full text-base md:text-lg font-bold mt-8 transition">
                    Simpan Password
                </button>

            </form>

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