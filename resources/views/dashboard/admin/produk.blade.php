@extends('layouts.app')

@section('title', 'Manajemen Produk')

@php
    $apiUrl = config('services.marketplace_api.url');
@endphp

@section('content')

<div
class="min-h-screen bg-[#F5F5F5] flex flex-col lg:flex-row"
x-data="{ 
    openMenu: null, 
    openFilter: false,
    openDetail: false,
    selectedProduct: null,
    apiUrl: '{{ $apiUrl }}'
}">

    @include('dashboard.admin.partials.sidebar')

    {{-- CONTENT --}}
    <div class="flex-1">

        {{-- TOPBAR --}}
        @include('dashboard.admin.partials.topbar')

        {{-- MAIN --}}
        <div class="p-5">

            {{-- ALERT --}}
            @if (session('success'))
                <div class="mb-5 bg-green-100 border border-green-300 text-green-700 px-5 py-3 rounded-2xl">
                    {{ session('success') }}
                </div>
            @endif

            @if (session('error'))
                <div class="mb-5 bg-red-100 border border-red-300 text-red-700 px-5 py-3 rounded-2xl">
                    {{ session('error') }}
                </div>
            @endif

            {{-- HEADER --}}
            <div>
                <h2 class="text-3xl font-bold">
                    Manajemen Produk
                </h2>
                <p class="text-gray-600 mt-1">
                    Kelola semua produk yang ada di Vellora Marketplace
                </p>
            </div>

            {{-- STATS CARDS --}}
            <div class="flex gap-4 mt-5 overflow-x-auto pb-2">
                {{-- CARD --}}
                <div class="w-[180px] bg-white rounded-2xl shadow-sm px-4 py-3 flex items-center gap-3">
                    <div class="w-12 h-12 rounded-full bg-pink-100 flex items-center justify-center">
                        <i class="ri-shopping-bag-3-line text-2xl text-pink-500"></i>
                    </div>
                    <div>
                        <h3 class="font-semibold text-xs text-gray-500">Total Produk</h3>
                        <h2 class="text-2xl font-bold leading-none mt-1">{{ count($products) }}</h2>
                        <p class="text-gray-400 text-[10px] mt-1">Semua Produk</p>
                    </div>
                </div>

                {{-- CARD --}}
                <div class="w-[180px] bg-white rounded-2xl shadow-sm px-4 py-3 flex items-center gap-3">
                    <div class="w-12 h-12 rounded-full bg-green-100 flex items-center justify-center">
                        <i class="ri-checkbox-circle-line text-2xl text-green-600"></i>
                    </div>
                    <div>
                        <h3 class="font-semibold text-xs text-gray-500">Produk Aktif</h3>
                        <h2 class="text-2xl font-bold leading-none mt-1">{{ collect($products)->where('is_active', true)->count() }}</h2>
                        <p class="text-gray-400 text-[10px] mt-1">Status Aktif</p>
                    </div>
                </div>
            </div>

            {{-- FILTER --}}
            <div class="flex items-center gap-3 mt-5">
                {{-- FILTER --}}
                <div class="relative">
                    <button
                    @click="openFilter = !openFilter"
                    class="bg-pink-100 rounded-full px-5 py-2 flex items-center gap-6 text-sm font-semibold">
                        <span>
                            @if(request('status') === 'aktif')
                                Aktif
                            @elseif(request('status') === 'nonaktif')
                                Nonaktif
                            @else
                                Semua Status
                            @endif
                        </span>
                        <i class="ri-arrow-down-s-line text-lg"></i>
                    </button>

                    {{-- DROPDOWN --}}
                    <div
                    x-show="openFilter"
                    @click.outside="openFilter = false"
                    x-transition
                    class="absolute top-11 left-0 bg-white rounded-2xl shadow-lg w-[150px] p-3 z-50">
                        <div class="space-y-2 flex flex-col items-start">
                            <a href="/admin/produk" class="text-sm py-1 hover:text-pink-500 transition">Semua</a>
                            <a href="/admin/produk?status=aktif" class="text-sm py-1 hover:text-pink-500 transition">Aktif</a>
                            <a href="/admin/produk?status=nonaktif" class="text-sm py-1 hover:text-pink-500 transition">Nonaktif</a>
                        </div>
                    </div>
                </div>
            </div>

            {{-- TABLE --}}
            <div class="bg-white rounded-2xl mt-4 shadow-sm overflow-x-auto">

                <div class="min-w-[800px]">

                    {{-- HEAD --}}
                    <div class="grid grid-cols-[1.5fr_1fr_1fr_1fr_1fr_60px] bg-pink-100 px-4 py-3 text-sm font-bold text-gray-700">
                    <h3>Produk</h3>
                    <h3>Kategori</h3>
                    <h3>Seller/Toko</h3>
                    <h3>Status</h3>
                    <h3>Tanggal Dibuat</h3>
                    <h3 class="text-center">Aksi</h3>
                </div>

                    {{-- ROWS CONTAINER --}}
                    <div style="max-height: 290px; overflow-y: auto;">
                        {{-- ROWS --}}
                        @forelse ($products as $p)
                            @php
                                $isActiveFilter = !request('status') || 
                                    (request('status') === 'aktif' && $p['is_active']) || 
                                    (request('status') === 'nonaktif' && !$p['is_active']);
                            @endphp
                            @if($isActiveFilter)
                            <div class="grid grid-cols-[1.5fr_1fr_1fr_1fr_1fr_60px] items-center px-4 py-3 border-b border-gray-100 text-sm text-gray-700 hover:bg-gray-50 transition">
                                {{-- PRODUK --}}
                                <div class="flex items-center gap-3">
                                    <img src="{{ isset($p['images'][0]) ? $apiUrl . '/' . $p['images'][0]['image'] : 'https://picsum.photos/60' }}"
                                         class="w-12 h-12 rounded object-cover">
                                    <div>
                                        <h3 class="font-semibold text-gray-800">{{ $p['product_name'] }}</h3>
                                        <p class="text-xs text-gray-400 mt-1">Rp{{ number_format($p['price'], 0, ',', '.') }}</p>
                                    </div>
                                </div>

                                {{-- KATEGORI --}}
                                <div>
                                    <span class="bg-pink-100 text-pink-700 px-3 py-1 rounded-full text-xs font-semibold">
                                        {{ $p['category']['category_name'] ?? '-' }}
                                    </span>
                                </div>

                                {{-- TOKO --}}
                                <h3 class="font-semibold text-gray-800">
                                    {{ $p['store']['store_name'] ?? '-' }}
                                </h3>

                                {{-- STATUS --}}
                                <div>
                                    <span class="px-3 py-1 rounded-full text-xs font-semibold {{ $p['is_active'] ? 'bg-green-100 text-green-600' : 'bg-yellow-100 text-yellow-600' }}">
                                        {{ $p['is_active'] ? 'Aktif' : 'Nonaktif' }}
                                    </span>
                                </div>

                                {{-- TANGGAL --}}
                                <p>{{ \Carbon\Carbon::parse($p['created_at'])->translatedFormat('d M Y') }}</p>

                                {{-- AKSI --}}
                                <div class="relative flex justify-center">
                                    <button
                                    @click="openMenu === {{ $p['id'] }} ? openMenu = null : openMenu = {{ $p['id'] }}">
                                        <i class="ri-more-2-fill text-xl text-gray-500 hover:text-pink-500 transition"></i>
                                    </button>

                                    {{-- DROPDOWN --}}
                                    <div
                                    x-show="openMenu === {{ $p['id'] }}"
                                    @click.outside="openMenu = null"
                                    x-transition
                                    class="absolute right-0 top-8 bg-white rounded-2xl shadow-lg w-[165px] p-3 z-50 text-left">
                                        <button
                                        @click="selectedProduct = {{ json_encode($p) }}; openDetail = true; openMenu = null"
                                        class="flex items-center gap-3 text-sm hover:text-pink-500 transition w-full text-left">
                                            <i class="ri-eye-line"></i>
                                            <span>Lihat Detail</span>
                                        </button>
                                    </div>
                                </div>
                            </div>
                            @endif
                        @empty
                            <div class="p-8 text-center text-gray-400">
                                Belum ada produk.
                            </div>
                        @endforelse
                    </div>
                </div>

            </div>
        </div>
    </div>

    {{-- MODAL DETAIL PRODUK --}}
    <div
    x-show="openDetail"
    x-transition
    class="fixed inset-0 bg-black/40 flex items-center justify-center z-50 p-4"
    x-cloak>
        <div
        @click.outside="openDetail = false"
        class="bg-white rounded-[22px] w-full max-w-[560px] mx-4 overflow-hidden shadow-2xl">
            {{-- HEADER --}}
            <div class="flex items-center justify-between px-5 py-3 border-b border-gray-300">
                <h2 class="text-xl font-bold text-gray-800">Detail Produk</h2>
                <button @click="openDetail = false">
                    <i class="ri-close-line text-2xl text-gray-500 hover:text-red-500 transition"></i>
                </button>
            </div>

            {{-- CONTENT --}}
            <div class="px-5 py-5 space-y-6" x-if="selectedProduct">
                <div class="flex flex-col sm:flex-row gap-5">
                    {{-- LEFT --}}
                    <div class="w-[120px] flex-shrink-0">
                        <img :src="selectedProduct && selectedProduct.images?.[0] ? apiUrl + '/' + selectedProduct.images[0].image : 'https://picsum.photos/200'"
                             class="w-[120px] h-[120px] rounded-xl object-cover border">
                    </div>

                    {{-- RIGHT --}}
                    <div class="flex-1">
                        <div class="flex items-start justify-between gap-4">
                            <div>
                                <h2 class="text-xl font-bold text-gray-800" x-text="selectedProduct ? selectedProduct.product_name : ''"></h2>
                                <span class="bg-pink-100 text-pink-700 px-3 py-1 rounded-full text-xs font-semibold inline-block mt-1" x-text="selectedProduct ? (selectedProduct.category?.category_name || '-') : '-'"></span>
                            </div>
                            <span class="px-3 py-1 rounded-full text-xs font-semibold"
                                  :class="selectedProduct && selectedProduct.is_active ? 'bg-green-100 text-green-600' : 'bg-yellow-100 text-yellow-600'"
                                  x-text="selectedProduct && selectedProduct.is_active ? 'Aktif' : 'Nonaktif'"></span>
                        </div>

                        <div class="grid grid-cols-[120px_1fr] gap-y-2 mt-5 text-sm">
                            <h3 class="font-bold text-gray-400">Seller/Toko</h3>
                            <p class="font-semibold text-gray-800" x-text="selectedProduct ? (selectedProduct.store?.store_name || '-') : '-'"></p>
                            
                            <h3 class="font-bold text-gray-400">Harga</h3>
                            <p class="font-semibold text-gray-800" x-text="selectedProduct ? 'Rp' + new Intl.NumberFormat('id-ID').format(selectedProduct.price) : '-'"></p>
                            
                            <h3 class="font-bold text-gray-400">Stok</h3>
                            <p class="font-semibold text-gray-800" x-text="selectedProduct ? selectedProduct.stock : '-'"></p>
                        </div>
                    </div>
                </div>

                {{-- DESKRIPSI --}}
                <div class="border-t border-gray-100 pt-4">
                    <h2 class="text-base font-bold text-gray-800">Deskripsi Produk</h2>
                    <p class="text-sm text-gray-600 leading-relaxed mt-2" x-text="selectedProduct ? (selectedProduct.description || 'Tidak ada deskripsi.') : 'Tidak ada deskripsi.'"></p>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection