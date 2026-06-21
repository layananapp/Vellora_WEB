@extends('layouts.app')

@section('title', 'Cara Belanja')

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

        <div class="flex items-center gap-2 md:gap-4 text-xl md:text-3xl font-bold flex-wrap justify-center sm:justify-start">

            <a href="/">
                ←
            </a>

            <span>Belanja</span>

            <span>›</span>

            <span>Cara Belanja</span>

        </div>

        {{-- Login --}}
        <div class="flex items-center gap-2">

            <i class="ri-user-line text-2xl md:text-3xl"></i>

            <span class="font-semibold">
                Masuk
            </span>

        </div>

    </div>

    {{-- Content --}}
    <div class="max-w-4xl mx-auto mt-4 px-4 pb-12">

        <h1 class="text-3xl md:text-5xl font-bold text-center">
            Cara Belanja di
            <span class="text-pink-400">
                Vellora
            </span>
        </h1>

        <p class="text-center text-gray-600 text-lg md:text-xl mt-4 mb-12">
            Ikuti langkah mudah berikut untuk mulai belanja
        </p>

        <div class="space-y-8">

            {{-- Item --}}
            <div class="flex flex-col sm:flex-row items-center sm:items-start text-center sm:text-left gap-5 bg-white p-6 rounded-2xl border border-gray-100 shadow-sm">

                <div class="w-16 h-16 rounded-full bg-pink-300 text-white flex items-center justify-center text-3xl font-bold flex-shrink-0">
                    1
                </div>

                <div>

                    <h2 class="text-2xl md:text-3xl font-bold">
                        Buka Aplikasi
                    </h2>

                    <p class="text-gray-600 text-base md:text-lg mt-1">
                        Buka aplikasi Vellora di smartphone kamu
                    </p>

                </div>

            </div>

            <div class="flex flex-col sm:flex-row items-center sm:items-start text-center sm:text-left gap-5 bg-white p-6 rounded-2xl border border-gray-100 shadow-sm">

                <div class="w-16 h-16 rounded-full bg-pink-300 text-white flex items-center justify-center text-3xl font-bold flex-shrink-0">
                    2
                </div>

                <div>

                    <h2 class="text-2xl md:text-3xl font-bold">
                        Pilih Produk
                    </h2>

                    <p class="text-gray-600 text-base md:text-lg mt-1">
                        Cari atau pilih produk yang kamu inginkan
                    </p>

                </div>

            </div>

            <div class="flex flex-col sm:flex-row items-center sm:items-start text-center sm:text-left gap-5 bg-white p-6 rounded-2xl border border-gray-100 shadow-sm">

                <div class="w-16 h-16 rounded-full bg-pink-300 text-white flex items-center justify-center text-3xl font-bold flex-shrink-0">
                    3
                </div>

                <div>

                    <h2 class="text-2xl md:text-3xl font-bold">
                        Pilih & Tambah ke Keranjang
                    </h2>

                    <p class="text-gray-600 text-base md:text-lg mt-1">
                        Pilih produk yang kamu suka, lalu tambah ke keranjang
                    </p>

                </div>

            </div>

            <div class="flex flex-col sm:flex-row items-center sm:items-start text-center sm:text-left gap-5 bg-white p-6 rounded-2xl border border-gray-100 shadow-sm">

                <div class="w-16 h-16 rounded-full bg-pink-300 text-white flex items-center justify-center text-3xl font-bold flex-shrink-0">
                    4
                </div>

                <div>

                    <h2 class="text-2xl md:text-3xl font-bold">
                        Checkout
                    </h2>

                    <p class="text-gray-600 text-base md:text-lg mt-1">
                        Isi alamat pengiriman dan pilih metode pembayaran
                    </p>

                </div>

            </div>

            <div class="flex flex-col sm:flex-row items-center sm:items-start text-center sm:text-left gap-5 bg-white p-6 rounded-2xl border border-gray-100 shadow-sm">

                <div class="w-16 h-16 rounded-full bg-pink-300 text-white flex items-center justify-center text-3xl font-bold flex-shrink-0">
                    5
                </div>

                <div>

                    <h2 class="text-2xl md:text-3xl font-bold">
                        Bayar
                    </h2>

                    <p class="text-gray-600 text-base md:text-lg mt-1">
                        Lakukan pembayaran sesuai metode yang dipilih
                    </p>

                </div>

            </div>

            <div class="flex flex-col sm:flex-row items-center sm:items-start text-center sm:text-left gap-5 bg-white p-6 rounded-2xl border border-gray-100 shadow-sm">

                <div class="w-16 h-16 rounded-full bg-pink-300 text-white flex items-center justify-center text-3xl font-bold flex-shrink-0">
                    6
                </div>

                <div>

                    <h2 class="text-2xl md:text-3xl font-bold">
                        Pesanan Diproses
                    </h2>

                    <p class="text-gray-600 text-base md:text-lg mt-1">
                        Pesanan akan kami proses dan dikirim ke alamatmu
                    </p>

                </div>

            </div>

        </div>

    </div>

    {{-- Footer --}}
    @include('landing.components.footer')

</div>

@endsection