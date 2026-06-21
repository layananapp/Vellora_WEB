@extends('layouts.app')

@section('title', 'Login')

@section('content')

<div
x-data="{
    role: '{{ session('switchRole', 'seller') }}'
}"
class="min-h-screen bg-[#FFF8F8] pb-12">

    {{-- TOPBAR --}}
    <div class="h-14 bg-gradient-to-r from-pink-100 to-[#DCE8B4] flex items-center justify-between px-4 md:px-10">

        {{-- LOGO --}}
        <h1 class="text-2xl md:text-3xl font-bold text-[#F07A8D]">
            Vellora
        </h1>

        {{-- CONTACT --}}
        <p class="text-sm md:text-lg">
            Butuh bantuan?
            <span class="text-[#FF5A5A] font-semibold cursor-pointer">
                Hubungi Kami
            </span>
        </p>

    </div>

    {{-- BACK --}}
    <div class="px-4 md:px-10 pt-6">

        <a
        href="/"
        class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-white shadow-sm hover:bg-gray-50 transition">

            <i class="ri-arrow-left-line text-xl"></i>

            <span class="font-medium text-sm md:text-base">
                Kembali
            </span>

        </a>

    </div>

    {{-- CONTENT --}}
    <div class="flex flex-col lg:flex-row items-center justify-center gap-10 lg:gap-16 px-4 md:px-12 py-6">

        {{-- LEFT --}}
        <div class="w-full max-w-[500px]">

            {{-- TITLE --}}
            <h2 class="text-2xl md:text-3xl font-bold text-center leading-snug">
                Kelola tokomu dengan mudah
                <br>
                bersama
                <span class="text-[#F07A8D]">
                    Vellora Seller
                </span>
            </h2>

            {{-- IMAGE --}}
            <div class="flex justify-center mt-6">

                <img
                src="{{ asset('images/illustrasi.png') }}"
                class="w-[180px] md:w-[240px] h-auto"
                alt="Illustration">

            </div>

            {{-- FEATURES --}}
            <div class="grid grid-cols-3 gap-3 md:gap-6 mt-8">

                {{-- ITEM --}}
                <div class="text-center">

                    <div class="w-12 h-12 md:w-16 md:h-16 rounded-full bg-[#D9E8B4] flex items-center justify-center mx-auto">
                        <i class="ri-line-chart-line text-2xl md:text-3xl text-[#FF6A6A]"></i>
                    </div>

                    <h3 class="font-bold text-sm md:text-lg mt-3">
                        Pantau Penjualan
                    </h3>

                    <p class="text-xs text-gray-500 mt-1 leading-relaxed hidden sm:block">
                        Lihat performa tokomu secara real-time
                    </p>

                </div>

                {{-- ITEM --}}
                <div class="text-center">

                    <div class="w-12 h-12 md:w-16 md:h-16 rounded-full bg-[#D9E8B4] flex items-center justify-center mx-auto">
                        <i class="ri-file-list-3-line text-2xl md:text-3xl text-[#FF6A6A]"></i>
                    </div>

                    <h3 class="font-bold text-sm md:text-lg mt-3">
                        Kelola Pesanan
                    </h3>

                    <p class="text-xs text-gray-500 mt-1 leading-relaxed hidden sm:block">
                        Proses pesanan dengan cepat dan mudah
                    </p>

                </div>

                {{-- ITEM --}}
                <div class="text-center">

                    <div class="w-12 h-12 md:w-16 md:h-16 rounded-full bg-[#D9E8B4] flex items-center justify-center mx-auto">
                        <i class="ri-chat-3-line text-2xl md:text-3xl text-[#FF6A6A]"></i>
                    </div>

                    <h3 class="font-bold text-sm md:text-lg mt-3">
                        Balas Chat
                    </h3>

                    <p class="text-xs text-gray-500 mt-1 leading-relaxed hidden sm:block">
                        Jangan lewatkan pesan dari pembeli
                    </p>

                </div>

            </div>

        </div>

        {{-- RIGHT --}}
        <div class="w-full max-w-[420px] bg-white/95 backdrop-blur-sm rounded-[32px] px-6 py-10 md:px-10 md:py-12 shadow-lg border border-white">

            {{-- TITLE --}}
            <h1 class="text-3xl md:text-4xl font-bold text-center">
                Selamat Datang!
            </h1>

            {{-- SWITCH --}}
            <div class="bg-[#E5E5E5] rounded-full p-1.5 flex mt-8">

                {{-- SELLER --}}
                <button
                type="button"
                @click="role='seller'"
                class="flex-1 h-[44px] md:h-[48px] rounded-full text-lg md:text-xl font-bold transition focus:outline-none"
                :class="role === 'seller'
                    ? 'bg-white text-[#F07A8D]'
                    : 'text-black'">
                    Seller
                </button>

                {{-- ADMIN --}}
                <button
                type="button"
                @click="role='admin'"
                class="flex-1 h-[44px] md:h-[48px] rounded-full text-lg md:text-xl font-bold transition focus:outline-none"
                :class="role === 'admin'
                    ? 'bg-white text-[#F07A8D]'
                    : 'text-black'">
                    Admin
                </button>

            </div>

            {{-- FORM --}}
            <form
            action="{{ route('login.authenticate') }}"
            method="POST"
            class="mt-8">

                @csrf

                {{-- ROLE --}}
                <input
                type="hidden"
                name="role"
                :value="role">

                {{-- EMAIL --}}
                <div>

                    <label class="text-lg font-bold">
                        Email
                    </label>

                    <input
                    type="email"
                    name="email"
                    class="w-full h-[48px] md:h-[52px] border border-gray-300 rounded-full px-5 text-sm md:text-base mt-2 outline-none focus:border-pink-300 transition"
                    required>

                </div>

                {{-- PASSWORD --}}
                <div class="mt-4">

                    <label class="text-lg font-bold">
                        Password
                    </label>

                    <input
                    type="password"
                    name="password"
                    class="w-full h-[48px] md:h-[52px] border border-gray-300 rounded-full px-5 text-sm md:text-base mt-2 outline-none focus:border-pink-300 transition"
                    required>

                </div>

                {{-- LUPA PASSWORD --}}
                <div
                class="flex justify-end mt-2 transition-all duration-200"
                :class="role === 'seller'
                    ? 'opacity-100'
                    : 'opacity-0 pointer-events-none'">

                    <a
                    href="{{ route('lupa-password') }}"
                    class="text-[#3B5BDB] text-sm hover:underline">
                        Lupa Password?
                    </a>

                </div>

                {{-- LOGIN SUCCESS --}}
                @if(session('success'))
                    <div class="mt-4 mb-4 rounded-2xl bg-green-500/10 border border-green-200 px-5 py-4 text-green-600 font-semibold text-sm">
                        {{ session('success') }}
                    </div>
                @endif

                {{-- LOGIN ERROR --}}
                @if(session('error'))

                    <div class="mt-4 mb-4 rounded-2xl bg-red-100 border border-red-300 px-5 py-4 text-red-700">

                        <div class="font-bold">
                            {{ session('error') }}
                        </div>

                        {{-- ATTEMPT --}}
                        @if(session('remaining_attempt') !== null)

                            <div class="text-sm mt-1">
                                Sisa percobaan: {{ session('remaining_attempt') }}
                            </div>

                        @endif

                        {{-- RETRY --}}
                        @if(session('retry_after'))

                            <div class="text-sm mt-1">
                                Coba lagi dalam {{ session('retry_after') }} menit
                            </div>

                        @endif

                    </div>

                @endif

                {{-- BUTTON --}}
                <button
                type="submit"
                class="w-full h-[48px] md:h-[52px] bg-pink-100 rounded-full text-lg md:text-xl font-bold mt-6 hover:bg-pink-200 transition">
                    Login
                </button>

            </form>

        </div>

    </div>

</div>

@endsection