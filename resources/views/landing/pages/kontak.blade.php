@extends('layouts.app')

@section('title', 'Kontak')

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
                Kontak
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

    {{-- Main Content --}}
    <div class="max-w-6xl mx-auto mt-6 px-4 pb-12">

        {{-- Title --}}
        <div class="text-center">

            <h1 class="text-3xl md:text-5xl font-bold">
                Kontak Kami
            </h1>

            <p class="text-lg md:text-2xl text-gray-600 mt-3">
                Kami siap membantu untuk anda.
            </p>

        </div>

        {{-- Content --}}
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-10 lg:gap-16 mt-14 items-center">

            {{-- Left Info --}}
            <div class="space-y-10">

                {{-- Email --}}
                <div class="flex items-start gap-5 bg-white p-6 rounded-2xl border border-gray-100 shadow-sm">

                    <div class="text-4xl md:text-5xl">
                        ✉️
                    </div>

                    <div>

                        <h3 class="text-2xl md:text-3xl font-bold">
                            Email
                        </h3>

                        <p class="text-lg md:text-xl text-gray-600 mt-1">
                            layananapp@gmail.com
                        </p>

                    </div>

                </div>

                {{-- WhatsApp --}}
                <div class="flex items-start gap-5 bg-white p-6 rounded-2xl border border-gray-100 shadow-sm">

                    <div class="text-4xl md:text-5xl">
                        📱
                    </div>

                    <div>

                        <h3 class="text-2xl md:text-3xl font-bold">
                            WhatsApp
                        </h3>

                        <p class="text-lg md:text-xl text-gray-600 mt-1">
                            +62 734-5679-9822
                        </p>

                    </div>

                </div>

                {{-- Operational --}}
                <div class="flex items-start gap-5 bg-white p-6 rounded-2xl border border-gray-100 shadow-sm">

                    <div class="text-4xl md:text-5xl">
                        🕒
                    </div>

                    <div>

                        <h3 class="text-2xl md:text-3xl font-bold">
                            Jam Operasional
                        </h3>

                        <p class="text-lg md:text-xl text-gray-600 mt-1">
                            Senin - Jumat
                        </p>

                        <p class="text-lg md:text-xl text-gray-600">
                            08:00 - 17:00
                        </p>

                    </div>

                </div>

            </div>

            {{-- Right Illustration --}}
            <div class="flex justify-center">

                <div class="text-[120px] md:text-[200px]">
                    🙋‍♀️
                </div>

            </div>

        </div>

        {{-- Form --}}
        <div class="mt-16 bg-white p-6 md:p-10 rounded-3xl border border-gray-100 shadow-sm">

            <h2 class="text-2xl md:text-4xl font-bold mb-8">
                Kirim Pesan
            </h2>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 md:gap-10 items-end">

                {{-- Left Inputs --}}
                <div class="space-y-6 md:col-span-1">

                    <div>

                        <label class="block text-lg font-semibold mb-2">
                            Nama
                        </label>

                        <input
                            type="text"
                            class="w-full border border-gray-300 rounded-full px-6 py-3 outline-none focus:border-pink-400 transition">

                    </div>

                    <div>

                        <label class="block text-lg font-semibold mb-2">
                            Email
                        </label>

                        <input
                            type="email"
                            class="w-full border border-gray-300 rounded-full px-6 py-3 outline-none focus:border-pink-400 transition">

                    </div>

                </div>

                {{-- Message --}}
                <div class="md:col-span-1">

                    <label class="block text-lg font-semibold mb-2">
                        Pesan Anda
                    </label>

                    <textarea
                        rows="5"
                        class="w-full border border-gray-300 rounded-[24px] px-6 py-3 outline-none resize-none focus:border-pink-400 transition"></textarea>

                </div>

                {{-- Button --}}
                <div class="flex items-end md:col-span-1 w-full">

                    <button class="bg-pink-400 hover:bg-pink-500 transition text-white font-bold px-10 py-3.5 rounded-full text-lg md:text-xl w-full">
                        Kirim Pesan
                    </button>

                </div>

            </div>

        </div>

    </div>

    {{-- Footer --}}
    @include('landing.components.footer')

</div>

@endsection