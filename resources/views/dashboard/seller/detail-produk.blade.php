@extends('layouts.app')

@section('title', 'Detail Produk')

@php
    $apiUrl = config('services.marketplace_api.url');
@endphp

@section('content')

<div class="min-h-screen bg-[#FFF9F9] flex flex-col lg:flex-row" x-data>

    {{-- SIDEBAR --}}
    @include('dashboard.seller.partials.sidebar')

    {{-- CONTENT --}}
    <div class="flex-1">

        {{-- TOP BAR --}}
        @include('dashboard.seller.partials.topbar')

        {{-- MAIN --}}
        <div class="p-5">

            {{-- HEADER --}}
            <div class="flex items-center gap-3">

                <a href="/seller/produk">

                    <i class="ri-arrow-left-line text-4xl text-black"></i>

                </a>

                <h2 class="text-3xl font-bold">
                    Produk
                </h2>

                <i class="ri-arrow-right-s-line text-3xl"></i>

                <h2 class="text-3xl font-bold">
                    Detail Produk
                </h2>

                </div>

            <p class="text-gray-500 mt-2 ml-12">
                Informasi lengkap mengenai produk toko Anda
            </p>

            {{-- CARD --}}
            <div class="bg-white rounded-3xl mt-6 p-6 shadow-sm">

                {{-- TOP --}}
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 lg:gap-10">

                    {{-- LEFT --}}
                    <div class="flex flex-col sm:flex-row gap-5">

                        {{-- IMAGE --}}
                        <div>

                            <img
                            src="{{ isset($product['images'][0])
                                ? $apiUrl . '/' . $product['images'][0]['image']
                                : 'https://picsum.photos/300'
                            }}"
                            class="w-36 h-36 rounded-2xl object-cover">

                            {{-- THUMBNAIL --}}
                            <div class="flex gap-3 mt-4">

                                @foreach ($product['images'] as $image)

                                    <img
                                    src="{{ $apiUrl . '/' . $image['image'] }}"
                                    class="w-14 h-14 rounded-xl object-cover">

                                @endforeach

                            </div>

                        </div>

                        {{-- INFO --}}
                        <div class="space-y-4">

                            {{-- NAMA --}}
                            <div class="flex gap-10 text-sm">

                                <span class="text-gray-500 w-20">
                                    Nama
                                </span>

                                <span class="font-medium">
                                    {{ $product['product_name'] }}
                                </span>

                            </div>

                            {{-- KATEGORI --}}
                            <div class="flex gap-10 text-sm">

                                <span class="text-gray-500 w-20">
                                    Kategori
                                </span>

                                <span class="font-medium">
                                    {{ $product['category']['category_name'] ?? '-' }}
                                </span>

                            </div>

                            {{-- STATUS --}}
                            <div class="flex gap-10 items-center text-sm">

                                <span class="text-gray-500 w-20">
                                    Status
                                </span>

                                <span class="{{ $product['deleted_at']
                                    ? 'bg-red-100 text-red-500'
                                    : ($product['is_active']
                                        ? 'bg-[#C6DB92]'
                                        : 'bg-[#FFD6A5] text-[#C96B00]')
                                }} px-4 py-1 rounded-full text-xs font-medium">

                                    {{ $product['deleted_at']
                                        ? 'Terhapus'
                                        : ($product['is_active']
                                            ? 'Aktif'
                                            : 'Nonaktif')
                                    }}

                                </span>

                            </div>

                            {{-- DIBUAT --}}
                            <div class="flex gap-10 text-sm">

                                <span class="text-gray-500 w-20">
                                    Dibuat
                                </span>

                                <span class="font-medium">
                                    {{ \Carbon\Carbon::parse($product['created_at'])->translatedFormat('d F Y') }}
                                </span>

                            </div>

                        </div>

                    </div>

                    {{-- RIGHT --}}
                    <div class="border-t lg:border-t-0 lg:border-l border-gray-200 lg:border-gray-300 pt-6 lg:pt-0 pl-0 lg:pl-8">

                        <h3 class="text-2xl font-bold">
                            Deskripsi Produk
                        </h3>

                        <p class="mt-4 text-gray-600 leading-relaxed">
                            {{ $product['description'] ?? '-' }}
                        </p>

                    </div>

                </div>

                {{-- BOTTOM --}}
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 lg:gap-10 mt-10">

                    {{-- LEFT --}}
                    <div>

                        <h3 class="text-2xl font-bold">
                            Variasi dan Harga
                        </h3>

                        <div class="mt-5 overflow-x-auto rounded-2xl border border-gray-200">

                            <div class="min-w-[600px]">

                                {{-- HEADER --}}
                            <div class="grid grid-cols-4 bg-pink-100 px-5 py-4 font-medium">

                                <h3>Variasi</h3>
                                <h3>Harga</h3>
                                <h3>Stok</h3>
                                <h3>Status</h3>

                            </div>

                            {{-- ROW --}}
                            @forelse ($product['variants'] as $variant)

                            <div class="grid grid-cols-4 px-5 py-4 items-center border-t border-gray-100">

                                <span>
                                    {{ $variant['variant_name'] }}
                                </span>

                                <span>
                                    Rp{{ number_format($variant['price'], 0, ',', '.') }}
                                </span>

                                <span>
                                    {{ $variant['stock'] }}
                                </span>

                                <span class="bg-[#C6DB8B] px-3 py-1 rounded-full text-center text-xs w-fit">

                                    Aktif

                                </span>

                            </div>

                            @empty

                            <div class="px-5 py-5 text-sm text-gray-400">

                                Belum ada variasi produk

                            </div>

                            @endforelse

                            </div>

                        </div>

                    </div>

                    {{-- RIGHT --}}
                    <div class="border-t lg:border-t-0 lg:border-l border-gray-200 lg:border-gray-300 pt-6 lg:pt-0 pl-0 lg:pl-8">

                        <h3 class="text-2xl font-bold">
                            Stok Produk
                        </h3>

                        <div class="flex items-center gap-10 mt-4">

                            <span class="text-gray-500">
                                Total Stok
                            </span>

                            <span class="font-medium">
                                {{ $product['stock'] }}
                            </span>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>

</div>

@endsection
