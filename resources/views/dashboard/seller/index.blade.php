@extends('layouts.app')

@section('title', 'Seller Dashboard')

@php
    $apiUrl = config('services.marketplace_api.url');
@endphp

@section('content')

<div
    class="min-h-screen bg-[#FFF9F9] flex flex-col lg:flex-row"
    x-data="{ tab: 'produk' }">

    @include('dashboard.seller.partials.sidebar')

    {{-- CONTENT --}}
    <div class="flex-1 p-4 md:p-6 relative overflow-y-auto w-full">

        {{-- Top --}}
        <div class="flex items-center gap-3 text-xl md:text-2xl font-bold">
            <button 
                type="button" 
                @click="$dispatch('toggle-sidebar')" 
                class="lg:hidden p-2 -ml-2 text-gray-700 hover:text-pink-500 transition text-2xl focus:outline-none"
            >
                <i class="ri-menu-line"></i>
            </button>
            <i class="ri-home-5-line"></i>
            <h2>Beranda</h2>
        </div>

        {{-- Stats Cards --}}
        <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mt-6">

            {{-- Total Produk --}}
            <div class="bg-white rounded-2xl p-4 shadow-sm flex items-center gap-4">
                <div class="w-12 h-12 bg-pink-100 rounded-full flex items-center justify-center flex-shrink-0">
                    <i class="ri-shopping-bag-3-line text-xl text-pink-400"></i>
                </div>
                <div>
                    <p class="text-gray-500 text-xs">Total Produk</p>
                    <h3 class="text-xl md:text-2xl font-bold">{{ count($products) }}</h3>
                </div>
            </div>

            {{-- Pesanan Aktif --}}
            <div class="bg-white rounded-2xl p-4 shadow-sm flex items-center gap-4">
                <div class="w-12 h-12 bg-orange-100 rounded-full flex items-center justify-center flex-shrink-0">
                    <i class="ri-time-line text-xl text-orange-400"></i>
                </div>
                <div>
                    <p class="text-gray-500 text-xs">Pesanan Aktif</p>
                    <h3 class="text-xl md:text-2xl font-bold">{{ $pending_count ?? 0 }}</h3>
                </div>
            </div>

            {{-- Total Ulasan --}}
            <div class="bg-white rounded-2xl p-4 shadow-sm flex items-center gap-4">
                <div class="w-12 h-12 bg-yellow-100 rounded-full flex items-center justify-center flex-shrink-0">
                    <i class="ri-star-fill text-xl text-yellow-400"></i>
                </div>
                <div>
                    <p class="text-gray-500 text-xs">Rating Toko</p>
                    <h3 class="text-xl md:text-2xl font-bold">{{ $avg_rating > 0 ? $avg_rating : '-' }}</h3>
                </div>
            </div>

            {{-- Pendapatan --}}
            <div class="bg-white rounded-2xl p-4 shadow-sm flex items-center gap-4">
                <div class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center flex-shrink-0">
                    <i class="ri-money-dollar-circle-line text-xl text-green-500"></i>
                </div>
                <div>
                    <p class="text-gray-500 text-xs">Pendapatan</p>
                    <h3 class="text-base md:text-lg font-bold truncate">
                        Rp{{ number_format($total_revenue ?? 0, 0, ',', '.') }}
                    </h3>
                </div>
            </div>

        </div>

        {{-- Header --}}
        <div class="mt-6">
            <h3 class="text-xl md:text-2xl font-bold">Toko Saya</h3>
            <p class="text-gray-500 mt-1 text-sm">Kelola informasi dan produk toko anda</p>
        </div>

        {{-- Statistik Toko --}}
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
                        <h3 class="text-lg font-bold">{{ $store['store_name'] ?? 'Nama toko belum ada' }}</h3>
                        <span class="bg-[#DDE8C8] text-xs px-3 py-1 rounded-full">Aktif</span>
                    </div>
                    <p class="text-gray-500 text-xs md:text-sm mt-1">
                        Bergabung Sejak
                        {{ isset($store['created_at'])
                            ? \Carbon\Carbon::parse($store['created_at'])->translatedFormat('d F Y')
                            : '-' }}
                    </p>
                    @if($avg_rating > 0)
                        <div class="flex items-center gap-1 mt-1 text-yellow-400 text-sm">
                            <i class="ri-star-fill"></i>
                            <span class="text-[#1E1E1E] font-semibold">{{ $avg_rating }}</span>
                            <span class="text-gray-400 text-xs">({{ count($reviews) }} ulasan)</span>
                        </div>
                    @endif
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
                        <h3 class="text-base md:text-lg font-bold">{{ count($products) }}</h3>
                    </div>
                </div>

                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 md:w-12 md:h-12 bg-[#DDE8C8] rounded-full flex items-center justify-center">
                        <i class="ri-line-chart-line text-lg md:text-xl"></i>
                    </div>
                    <div>
                        <p class="text-gray-500 text-xs md:text-sm">Pesanan Aktif</p>
                        <h3 class="text-base md:text-lg font-bold">{{ $pending_count ?? 0 }}</h3>
                    </div>
                </div>

            </div>

        </div>

        {{-- Tabs --}}
        <div class="bg-[#FFF1F1] rounded-2xl mt-5 px-4 md:px-10 py-4 flex items-center justify-center gap-8 md:gap-24 shadow-sm">

            <button
                @click="tab='produk'"
                class="flex flex-col items-center font-bold text-lg md:text-2xl transition"
                :class="tab === 'produk' ? 'text-pink-300' : 'text-[#C6CC8F]'">
                Produk
                <span x-show="tab === 'produk'" class="w-2 h-2 bg-pink-300 rounded-full mt-2"></span>
            </button>

            <button
                @click="tab='ulasan'"
                class="flex flex-col items-center font-bold text-lg md:text-2xl transition"
                :class="tab === 'ulasan' ? 'text-pink-300' : 'text-[#C6CC8F]'">
                Ulasan
                <span x-show="tab === 'ulasan'" class="w-2 h-2 bg-pink-300 rounded-full mt-2"></span>
            </button>

            <button
                @click="tab='toko'"
                class="flex flex-col items-center font-bold text-lg md:text-2xl transition"
                :class="tab === 'toko' ? 'text-pink-300' : 'text-[#C6CC8F]'">
                Tentang Toko
                <span x-show="tab === 'toko'" class="w-2 h-2 bg-pink-300 rounded-full mt-2"></span>
            </button>

        </div>

        {{-- ========================================= --}}
        {{-- PRODUK --}}
        {{-- ========================================= --}}
        <template x-if="tab === 'produk'">

            <div class="mt-6">

                @if(count($products) > 0)

                    <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-5 gap-4">

                        @foreach($products as $product)

                            @php
                                $img = $product['images'][0]['image'] ?? null;
                                $imgUrl = $img
                                    ? (str_starts_with($img, 'http') ? $img : $apiUrl . '/' . $img)
                                    : 'https://via.placeholder.com/200';
                            @endphp

                            <a href="/seller/detail-produk/{{ $product['id'] }}"
                                class="bg-white rounded-3xl p-3 shadow-sm relative hover:shadow-md transition">

                                <div class="absolute top-3 right-3 w-8 h-8 rounded-full bg-pink-100 flex items-center justify-center">
                                    <i class="ri-shopping-bag-line text-pink-400 text-sm"></i>
                                </div>

                                <img
                                    src="{{ $imgUrl }}"
                                    alt="{{ $product['product_name'] }}"
                                    class="w-full h-36 object-cover rounded-2xl">

                                <div class="mt-3">
                                    <h3 class="font-semibold leading-tight text-sm truncate">
                                        {{ $product['product_name'] ?? '-' }}
                                    </h3>
                                    <p class="text-xs text-gray-400 mt-1">
                                        Stok: {{ $product['stock'] ?? 0 }}
                                    </p>
                                    <div class="flex items-center justify-between mt-2 flex-wrap gap-1">
                                        <p class="text-[#F07A55] font-bold text-sm">
                                            Rp{{ number_format($product['price'] ?? 0, 0, ',', '.') }}
                                        </p>
                                        <span class="text-[10px] px-2 py-0.5 rounded-full {{ ($product['is_active'] ?? false) ? 'bg-green-100 text-green-600' : 'bg-gray-100 text-gray-500' }}">
                                            {{ ($product['is_active'] ?? false) ? 'Aktif' : 'Nonaktif' }}
                                        </span>
                                    </div>
                                </div>

                            </a>

                        @endforeach

                    </div>

                    <div class="mt-4 text-center">
                        <a href="/seller/produk"
                            class="text-[#F07A55] font-medium text-sm hover:underline">
                            Lihat semua produk →
                        </a>
                    </div>

                @else

                    <div class="bg-white rounded-2xl p-12 text-center shadow-sm">
                        <i class="ri-store-3-line text-5xl text-gray-200"></i>
                        <p class="text-gray-400 mt-3 font-medium">Belum ada produk</p>
                        <a href="/seller/tambah-produk"
                            class="mt-4 inline-block bg-[#F07A55] text-white px-6 py-2 rounded-full text-sm font-medium hover:bg-pink-500 transition">
                            + Tambah Produk Pertama
                        </a>
                    </div>

                @endif

            </div>

        </template>

        {{-- ========================================= --}}
        {{-- ULASAN --}}
        {{-- ========================================= --}}
        <template x-if="tab === 'ulasan'">

            <div class="mt-6">

                <div class="flex flex-col lg:flex-row items-start justify-between gap-8">

                    {{-- LEFT --}}
                    <div class="flex-1 w-full">

                        <h3 class="text-2xl font-bold">Ulasan Pembeli</h3>
                        <p class="text-gray-500 mt-1">Berikut adalah ulasan pembeli yang sudah berbelanja di toko anda</p>

                        <div class="space-y-4 mt-6">

                            @forelse($reviews as $review)

                                <div class="bg-white border border-gray-200 rounded-3xl p-5 max-w-2xl">

                                    <div class="flex items-center gap-2">
                                        @if(!empty($review['user_photo']))
                                            <img src="{{ $review['user_photo'] }}" alt="" class="w-8 h-8 rounded-full object-cover">
                                        @else
                                            <i class="ri-user-3-fill text-gray-300 text-2xl"></i>
                                        @endif
                                        <span class="font-medium text-sm">{{ $review['user_name'] ?? 'Pembeli' }}</span>
                                    </div>

                                    <div class="flex gap-0.5 mt-2">
                                        @for($s = 1; $s <= 5; $s++)
                                            <i class="ri-star-{{ $s <= ($review['rating'] ?? 0) ? 'fill text-yellow-400' : 'line text-gray-300' }} text-sm"></i>
                                        @endfor
                                    </div>

                                    @if(!empty($review['product_name']))
                                        <p class="text-xs text-gray-400 mt-1">
                                            <i class="ri-shopping-bag-line"></i> {{ $review['product_name'] }}
                                        </p>
                                    @endif

                                    <p class="mt-2 text-[#3B302A] leading-relaxed text-sm">
                                        {{ $review['review'] ?? 'Tidak ada komentar' }}
                                    </p>

                                    <p class="text-gray-400 text-xs mt-3">{{ $review['created_at'] ?? '' }}</p>

                                </div>

                            @empty

                                <div class="bg-white rounded-3xl p-10 text-center border border-gray-100">
                                    <i class="ri-star-line text-4xl text-gray-200"></i>
                                    <p class="text-gray-400 mt-2">Belum ada ulasan</p>
                                </div>

                            @endforelse

                        </div>

                        @if(count($reviews) > 3)
                            <div class="mt-4">
                                <a href="/seller/reviews" class="text-[#F07A55] font-medium text-sm hover:underline">
                                    Lihat semua ulasan →
                                </a>
                            </div>
                        @endif

                    </div>

                    {{-- RIGHT --}}
                    <div class="bg-white rounded-2xl p-5 shadow-sm w-full lg:w-auto lg:min-w-[200px]">
                        <p class="text-gray-500 text-lg">Rating Toko</p>
                        <div class="flex items-center gap-2 mt-1">
                            <h3 class="text-4xl font-bold">{{ $avg_rating > 0 ? $avg_rating : '-' }}</h3>
                            <div class="flex flex-col">
                                <div class="flex gap-0.5 text-yellow-400 text-xl">
                                    @for($s = 1; $s <= 5; $s++)
                                        <i class="ri-star-{{ $s <= round($avg_rating) ? 'fill' : 'line' }}"></i>
                                    @endfor
                                </div>
                            </div>
                        </div>
                        <p class="text-gray-400 mt-1 text-sm">({{ count($reviews) }} Ulasan)</p>
                    </div>

                </div>

            </div>

        </template>

        {{-- ========================================= --}}
        {{-- TENTANG TOKO --}}
        {{-- ========================================= --}}
        <template x-if="tab === 'toko'">

            <div class="mt-6">

                <h3 class="text-2xl font-bold">Tentang Toko</h3>
                <p class="text-gray-500 mt-1">Kelola informasi dasar tentang toko anda</p>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-10 mt-8">

                    {{-- LEFT --}}
                    <div class="space-y-8">

                        <div class="flex items-start gap-4">
                            <div class="w-14 h-14 rounded-2xl border border-pink-200 flex items-center justify-center flex-shrink-0">
                                <i class="ri-calendar-line text-3xl text-pink-300"></i>
                            </div>
                            <div>
                                <h4 class="font-bold text-xl md:text-2xl">Bergabung Sejak</h4>
                                <p class="text-gray-500 mt-1 text-sm md:text-base">
                                    {{ isset($store['created_at'])
                                        ? \Carbon\Carbon::parse($store['created_at'])->translatedFormat('d F Y')
                                        : '-' }}
                                </p>
                            </div>
                        </div>

                        <div class="flex items-start gap-4">
                            <div class="w-14 h-14 rounded-2xl border border-pink-200 flex items-center justify-center flex-shrink-0">
                                <i class="ri-shopping-bag-3-line text-3xl text-pink-300"></i>
                            </div>
                            <div>
                                <h4 class="font-bold text-xl md:text-2xl">Total Produk</h4>
                                <p class="text-gray-500 mt-1 text-sm md:text-base">{{ count($products) }} produk</p>
                            </div>
                        </div>

                    </div>

                    {{-- RIGHT --}}
                    <div class="border-t md:border-t-0 md:border-l border-gray-300 pt-8 md:pt-0 md:pl-10 space-y-8">

                        <div class="flex items-start gap-4">
                            <div class="w-14 h-14 rounded-full border-2 border-pink-300 flex items-center justify-center flex-shrink-0">
                                <i class="ri-phone-line text-3xl text-pink-300"></i>
                            </div>
                            <div>
                                <h4 class="font-bold text-xl md:text-2xl">No. Telepon</h4>
                                <p class="text-gray-500 mt-1 text-sm md:text-base">{{ $store['phone_number'] ?? '-' }}</p>
                            </div>
                        </div>

                    </div>

                </div>

            </div>

        </template>

    </div>

</div>

@endsection