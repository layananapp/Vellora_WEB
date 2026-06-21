@extends('layouts.app')

@section('title', 'Tentang Toko')

@php
    $apiUrl = config('services.marketplace_api.url');
@endphp

@section('content')

<div class="min-h-screen bg-[#FFF9F9] flex flex-col lg:flex-row" x-data>

    @include('dashboard.seller.partials.sidebar')

    {{-- CONTENT --}}
    <div class="flex-1 w-full p-4 md:p-6">

        {{-- Header --}}
        <div>
            <h3 class="text-xl md:text-2xl font-bold">Toko Saya</h3>
            <p class="text-gray-500 mt-1 text-sm">Kelola informasi dan produk toko anda</p>
        </div>

        {{-- Statistik --}}
        <div class="bg-white rounded-3xl p-4 md:p-6 mt-5 flex flex-col md:flex-row items-start md:items-center justify-between gap-4 shadow-sm">

            {{-- Left --}}
            <div class="flex items-center gap-4">

                <img
                    src="{{ isset($store) && $store['store_logo']
                        ? (str_starts_with($store['store_logo'], 'http')
                            ? $store['store_logo']
                            : $apiUrl . '/' . $store['store_logo'])
                        : asset('images/profile-store.png') }}"
                    alt=""
                    class="w-14 h-14 rounded-full object-cover">

                <div>
                    <div class="flex items-center gap-2">
                        <h3 class="text-lg font-bold">{{ $store['store_name'] ?? 'Nama Toko' }}</h3>
                        <span class="bg-[#DDE8C8] text-xs px-3 py-1 rounded-full">Aktif</span>
                    </div>
                    <p class="text-gray-500 text-xs md:text-sm mt-1">
                        Bergabung Sejak
                        {{ isset($store['created_at'])
                            ? \Carbon\Carbon::parse($store['created_at'])->translatedFormat('d F Y')
                            : '-' }}
                    </p>
                </div>

            </div>

            {{-- Right --}}
            <div class="flex items-center gap-6 w-full md:w-auto justify-between md:justify-end border-t md:border-t-0 pt-3 md:pt-0">

                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 md:w-12 md:h-12 bg-pink-100 rounded-full flex items-center justify-center">
                        <i class="ri-shopping-bag-3-line text-lg md:text-xl text-pink-400"></i>
                    </div>
                    <div>
                        <p class="text-gray-500 text-xs md:text-sm">Total Produk</p>
                        <h3 class="text-base md:text-lg font-bold">{{ $total_products ?? 0 }}</h3>
                    </div>
                </div>

                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 md:w-12 md:h-12 bg-[#DDE8C8] rounded-full flex items-center justify-center">
                        <i class="ri-phone-line text-lg md:text-xl"></i>
                    </div>
                    <div>
                        <p class="text-gray-500 text-xs md:text-sm">No. Telepon</p>
                        <h3 class="text-base md:text-lg font-bold">{{ $store['phone_number'] ?? '-' }}</h3>
                    </div>
                </div>

            </div>

        </div>

        {{-- Tabs --}}
        <div class="bg-white rounded-2xl mt-5 px-4 md:px-10 py-4 flex flex-wrap items-center justify-center gap-6 md:gap-24 shadow-sm">

            <a href="/seller/dashboard"
                class="text-[#C6CC8F] font-bold text-lg md:text-xl hover:text-pink-300 transition">
                Produk
            </a>

            <a href="/seller/reviews"
                class="text-[#C6CC8F] font-bold text-lg md:text-xl hover:text-pink-300 transition">
                Ulasan
            </a>

            {{-- Active --}}
            <a href="/seller/store"
                class="flex flex-col items-center text-[#F07A55] font-bold text-lg md:text-xl">
                Tentang Toko
                <span class="w-2 h-2 bg-[#F07A55] rounded-full mt-2"></span>
            </a>

        </div>

        {{-- Store Info --}}
        <div class="bg-white rounded-3xl p-6 mt-5 shadow-sm">

            <h3 class="text-xl md:text-2xl font-bold">Tentang Toko</h3>
            <p class="text-gray-500 mt-1 text-sm">Informasi dasar tentang toko anda</p>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-10 mt-8">

                {{-- LEFT --}}
                <div class="space-y-8">

                    {{-- Dibuat --}}
                    <div class="flex items-start gap-4">
                        <div class="w-14 h-14 rounded-2xl border border-pink-200 flex items-center justify-center flex-shrink-0">
                            <i class="ri-calendar-line text-3xl text-pink-300"></i>
                        </div>
                        <div>
                            <h4 class="font-bold text-xl">Bergabung Sejak</h4>
                            <p class="text-gray-500 mt-1 text-sm">
                                {{ isset($store['created_at'])
                                    ? \Carbon\Carbon::parse($store['created_at'])->translatedFormat('d F Y')
                                    : '-' }}
                            </p>
                        </div>
                    </div>

                    {{-- Total Produk --}}
                    <div class="flex items-start gap-4">
                        <div class="w-14 h-14 rounded-2xl border border-pink-200 flex items-center justify-center flex-shrink-0">
                            <i class="ri-shopping-bag-3-line text-3xl text-pink-300"></i>
                        </div>
                        <div>
                            <h4 class="font-bold text-xl">Total Produk</h4>
                            <p class="text-gray-500 mt-1 text-sm">{{ $total_products ?? 0 }} produk aktif</p>
                        </div>
                    </div>

                    {{-- Deskripsi --}}
                    @if(!empty($store['description']))
                        <div>
                            <h4 class="font-bold text-xl">Deskripsi Toko</h4>
                            <p class="text-gray-500 mt-3 leading-relaxed text-sm md:text-base max-w-xl">
                                {{ $store['description'] }}
                            </p>
                        </div>
                    @endif

                </div>

                {{-- RIGHT --}}
                <div class="border-t md:border-t-0 md:border-l border-gray-200 pt-8 md:pt-0 md:pl-10 space-y-8">

                    {{-- Kontak --}}
                    <div class="flex items-start gap-4">
                        <div class="w-14 h-14 rounded-full border-2 border-pink-300 flex items-center justify-center flex-shrink-0">
                            <i class="ri-phone-line text-3xl text-pink-300"></i>
                        </div>
                        <div>
                            <h4 class="font-bold text-xl">No. Telepon</h4>
                            <p class="text-gray-500 mt-1 text-sm">{{ $store['phone_number'] ?? '-' }}</p>
                        </div>
                    </div>

                    {{-- Email pemilik --}}
                    <div class="flex items-start gap-4">
                        <div class="w-14 h-14 rounded-full border-2 border-pink-300 flex items-center justify-center flex-shrink-0">
                            <i class="ri-time-line text-3xl text-pink-300"></i>
                        </div>
                        <div>
                            <h4 class="font-bold text-xl">Jam Operasional</h4>
                            <p class="text-gray-500 mt-1 text-sm">Setiap Hari,</p>
                            <p class="text-gray-500 text-sm">08:00 – 22:00 WIB</p>
                        </div>
                    </div>

                </div>

            </div>

        </div>

        {{-- Edit link --}}
        <div class="mt-4 flex justify-end">
            <a href="/seller/akun-toko"
                class="flex items-center gap-2 text-[#F07A55] font-medium hover:text-pink-600 transition text-sm">
                <i class="ri-edit-line"></i>
                Edit Informasi Toko
            </a>
        </div>

    </div>

</div>

@endsection