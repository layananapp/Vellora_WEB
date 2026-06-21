@extends('layouts.app')

@section('title', ucfirst($category))

@php
    $apiUrl = config('services.marketplace_api.url');
@endphp

@section('content')

<div class="w-full min-h-screen bg-[#F8F6F6]">

    {{-- Top Bar --}}
    <div class="bg-[#DDE8C8] px-4 md:px-10 py-3 flex items-center gap-3">

        <span class="text-[#FF8E8E] text-lg">
            🚚
        </span>

        <p class="text-sm font-medium text-[#3B302A]">
            Gratis Pengiriman untuk Semua Order
        </p>

    </div>

    <div class="px-4 md:px-12 pt-6">

        <a href="/"
        class="flex items-center gap-2 text-xl md:text-2xl font-bold hover:text-pink-400 transition w-fit">

            <i class="ri-arrow-left-line"></i>

            <span>
                Kembali
            </span>

        </a>

    </div>

    {{-- Header --}}
    <div class="relative flex flex-col md:flex-row items-center justify-center gap-4 px-4 md:px-12 py-6 text-center">

        <div>

            <h1 class="text-3xl md:text-5xl font-bold text-pink-200">
                Vellora
            </h1>

            <p class="text-lg md:text-2xl text-[#3B302A] mt-2">
                Temukan koleksi {{ $category }} terbaru dan terbaik.
            </p>

        </div>
        
    </div>

    {{-- Category Tab --}}
    <div class="max-w-7xl mx-4 lg:mx-auto bg-white rounded-2xl py-4 md:py-6 px-4 md:px-10 flex items-center gap-6 overflow-x-auto whitespace-nowrap scrollbar-none justify-start md:justify-around mb-10">

        <a href="/products/fashion"
        class="font-bold text-lg md:text-2xl transition flex-shrink-0
        {{ $category == 'fashion' ? 'text-pink-300' : 'text-[#C9D18F]' }}">
            Fashion
        </a>

        <a href="/products/beauty"
        class="font-bold text-lg md:text-2xl transition flex-shrink-0
        {{ $category == 'beauty' ? 'text-pink-300' : 'text-[#C9D18F]' }}">
            Beauty
        </a>

        <a href="/products/rumah"
        class="font-bold text-lg md:text-2xl transition flex-shrink-0
        {{ $category == 'rumah' ? 'text-pink-300' : 'text-[#C9D18F]' }}">
            Rumah
        </a>

        <a href="/products/elektronik"
        class="font-bold text-lg md:text-2xl transition flex-shrink-0
        {{ $category == 'elektronik' ? 'text-pink-300' : 'text-[#C9D18F]' }}">
            Elektronik
        </a>

        <a href="/products/makanan"
        class="font-bold text-lg md:text-2xl transition flex-shrink-0
        {{ $category == 'makanan' ? 'text-pink-300' : 'text-[#C9D18F]' }}">
            Makanan
        </a>

        <a href="/products/olahraga"
        class="font-bold text-lg md:text-2xl transition flex-shrink-0
        {{ $category == 'olahraga' ? 'text-pink-300' : 'text-[#C9D18F]' }}">
            Olahraga
        </a>

        <a href="/products/lainnya"
        class="font-bold text-lg md:text-2xl transition flex-shrink-0
        {{ $category == 'lainnya' ? 'text-pink-300' : 'text-[#C9D18F]' }}">
            Lainnya
        </a>

    </div>
    
    {{-- Product Grid --}}
    <div class="max-w-7xl mx-4 lg:mx-auto grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-4 md:gap-6 pb-16">

        @forelse($products as $product)

        <div class="bg-white rounded-[20px] md:rounded-[28px] p-3 md:p-4 relative hover:shadow-lg transition flex flex-col justify-between">

            <div>
                {{-- Wishlist --}}
                <div class="absolute top-3 right-3 md:top-4 md:right-4 z-10">

                    <div class="bg-pink-100 w-8 h-8 rounded-full flex items-center justify-center">

                        <i class="ri-shopping-bag-line text-pink-400"></i>

                    </div>

                </div>

                {{-- Image --}}
                <img
                    src="{{ isset($product['images'][0]) ? $apiUrl . '/' . $product['images'][0]['image'] : ($product['image'] ?? 'https://picsum.photos/300') }}"
                    alt="{{ $product['product_name'] ?? ($product['name'] ?? 'Product') }}"
                    class="w-full h-36 md:h-48 object-cover rounded-xl">

                {{-- Info --}}
                <div class="mt-4">

                    <h3 class="font-semibold text-sm md:text-lg leading-tight line-clamp-2 min-h-[2.5rem]">
                        {{ $product['product_name'] ?? ($product['name'] ?? 'Produk Vellora') }}
                    </h3>

                    <p class="text-xs md:text-sm text-gray-400 mt-1">
                        {{ isset($product['rating_count']) && $product['rating_count'] > 0 ? $product['rating_count'] : '10RB+' }} terjual
                    </p>
                </div>
            </div>

            <div class="flex items-center justify-between mt-3 pt-2 border-t border-gray-50">

                <p class="text-pink-400 font-bold text-sm md:text-base">
                    Rp{{ is_numeric($product['price']) ? number_format($product['price'], 0, ',', '.') : $product['price'] }}
                </p>

                <div class="text-yellow-400 text-xs md:text-sm flex">
                    @if(isset($product['rating_avg']) && $product['rating_avg'] > 0)
                        {{ str_repeat('★', floor($product['rating_avg'])) }}{{ str_repeat('☆', 5 - floor($product['rating_avg'])) }}
                    @else
                        ★★★★★
                    @endif
                </div>

            </div>

        </div>

        @empty

        <div class="col-span-full py-12 text-center text-gray-400 bg-white rounded-3xl border border-gray-100 shadow-sm">
            Tidak ada produk untuk kategori ini.
        </div>

        @endforelse

    </div>

</div>

@endsection