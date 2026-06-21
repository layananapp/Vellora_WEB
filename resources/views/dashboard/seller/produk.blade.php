@extends('layouts.app')

@section('title', 'Produk')

@php
    $apiUrl = config('services.marketplace_api.url');
@endphp

@section('content')

<div class="min-h-screen bg-[#FFF9F9] flex flex-col lg:flex-row" x-data>

    @include('dashboard.seller.partials.sidebar')

    {{-- CONTENT --}}
    <div
    class="flex-1 w-full"
    x-data="{
        openFilter: false,
        openMenu: null,
        openDelete: false,
        openNonaktif: false
    }">

        {{-- TOP BAR --}}
        @include('dashboard.seller.partials.topbar')

        {{-- MAIN --}}
        <div class="p-4 md:p-6">

            @if (session('error'))
                <div class="mb-4 bg-red-100 border-l-4 border-red-500 text-red-700 p-4 rounded-xl shadow-sm" role="alert">
                    <p class="font-bold">Error</p>
                    <p>{{ session('error') }}</p>
                </div>
            @endif

            @if (session('success'))
                <div class="mb-4 bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded-xl shadow-sm" role="alert">
                    <p class="font-bold">Sukses</p>
                    <p>{{ session('success') }}</p>
                </div>
            @endif

            {{-- Header --}}
            <div class="flex flex-col md:flex-row items-start md:items-center justify-between gap-4">

                <div>

                    <div class="flex items-center gap-3">

                        <a href="/seller/dashboard">

                            <i class="ri-arrow-left-line text-3xl md:text-4xl"></i>

                        </a>

                        <h2 class="text-2xl md:text-3xl font-bold">
                            Produk
                        </h2>

                    </div>

                    <p class="text-gray-500 mt-1 text-sm md:ml-12">
                        Kelola semua produk yang dijual di toko Anda
                    </p>

                </div>

                {{-- Button --}}
                <a
                href="/seller/tambah-produk"
                class="bg-[#FF8FA3] hover:bg-pink-400 transition px-6 py-3 rounded-full flex items-center gap-2 font-bold text-base md:text-lg">

                    <i class="ri-add-line text-2xl md:text-3xl"></i>

                    Tambah Produk

                </a>

            </div>

            {{-- Filter --}}
            <div class="flex flex-col sm:flex-row items-stretch sm:items-center gap-4 mt-6">

                {{-- Search --}}
                <form
                    action="/seller/produk"
                    method="GET"
                    class="bg-pink-100 rounded-full px-5 py-3 flex items-center gap-3 w-full sm:w-[330px]">

                    <i class="ri-search-line text-xl text-[#F07A55]"></i>

                    <input
                    type="text"
                    name="search"
                    value="{{ request('search') }}"
                    placeholder="Search"
                    class="bg-transparent outline-none w-full text-sm">

                    <input
                    type="hidden"
                    name="status"
                    value="{{ request('status') }}">

                </form>

                {{-- Filter --}}
                <div class="relative w-full sm:w-auto">

                    <button
                    @click.stop="openFilter = !openFilter"
                    class="bg-pink-100 rounded-full px-5 py-3 flex items-center justify-between w-full sm:w-[250px]">

                        <div class="flex items-center gap-3">

                            <i class="ri-calendar-line text-xl"></i>

                           <span class="text-sm">

                                @if(request('status') == 'aktif')

                                    Aktif

                                @elseif(request('status') == 'nonaktif')

                                    Nonaktif

                                @elseif(request('status') == 'terhapus')

                                    Terhapus

                                @else

                                    Semua Status

                                @endif

                            </span>

                        </div>

                        <i class="ri-arrow-down-s-line text-xl"></i>

                    </button>

                    {{-- Dropdown --}}
                    <div
                    x-show="openFilter"
                    @click.outside="openFilter = false"
                    class="absolute mt-3 bg-white rounded-3xl shadow-lg p-5 w-52 z-50">

                        <div class="space-y-4">

                            <a
                            href="/seller/produk{{ request('search') ? '?search=' . urlencode(request('search')) : '' }}"
                            class="flex items-center justify-between">

                                <span>Semua</span>

                            </a>

                            <a
                            href="/seller/produk?status=aktif{{ request('search') ? '&search=' . urlencode(request('search')) : '' }}"
                            class="flex items-center justify-between">

                                <span>Aktif</span>

                            </a>

                            <a
                            href="/seller/produk?status=nonaktif{{ request('search') ? '&search=' . urlencode(request('search')) : '' }}"
                            class="flex items-center justify-between">

                                <span>Nonaktif</span>

                            </a>

                            <a
                            href="/seller/produk?status=terhapus{{ request('search') ? '&search=' . urlencode(request('search')) : '' }}"
                            class="flex items-center justify-between">

                                <span>Terhapus</span>

                            </a>

                        </div>

                    </div>

                </div>

            </div>

            {{-- TABLE --}}
            <div class="overflow-x-auto w-full mt-6 rounded-3xl shadow-sm border border-gray-100">
                <div class="bg-white min-w-[800px]">

                {{-- Header --}}
                <div class="bg-pink-100 grid grid-cols-6 px-6 py-4">

                    <h3 class="font-medium">
                        Produk
                    </h3>

                    <h3 class="font-medium">
                        Kategori
                    </h3>

                    <h3 class="font-medium">
                        Harga
                    </h3>

                    <h3 class="font-medium">
                        Stok
                    </h3>

                    <h3 class="font-medium">
                        Status
                    </h3>

                    <h3 class="font-medium">
                        Aksi
                    </h3>

                </div>

                @forelse ($products as $product)

                {{-- Row --}}
                <div class="grid grid-cols-6 px-6 py-5 items-center border-b border-gray-100">

                    {{-- Produk --}}
                    <div class="flex gap-3">

                        <img
                        src="{{ isset($product['images'][0])
                            ? $apiUrl . '/' . $product['images'][0]['image']
                            : 'https://picsum.photos/80'
                        }}"
                        class="w-14 h-14 object-cover rounded">

                        <div>

                            <h3 class="leading-tight font-medium">
                                {{ $product['product_name'] }}
                            </h3>

                            <p class="text-gray-400 text-sm mt-1 truncate w-[100px]">
                                {{ $product['description'] ?? '-' }}
                            </p>

                        </div>

                    </div>

                    {{-- Kategori --}}
                    <div>

                        <h3>
                            {{ $product['category']['category_name'] ?? '-' }}
                        </h3>

                    </div>

                    {{-- Harga --}}
                    <div>

                        <h3>
                            Rp{{ number_format($product['price'], 0, ',', '.') }}
                        </h3>

                    </div>

                    {{-- Stok --}}
                    <div>

                        <h3>
                            {{ $product['stock'] }}
                        </h3>

                    </div>

                    {{-- Status --}}
                    <div>

                        <span class="{{ $product['deleted_at']
                            ? 'bg-red-100 text-red-500'
                            : ($product['is_active']
                                ? 'bg-[#C6DB92]'
                                : 'bg-[#FFD6A5] text-[#C96B00]')
                        }} px-5 py-2 rounded-full text-sm">

                            {{ $product['deleted_at']
                                ? 'Terhapus'
                                : ($product['is_active']
                                    ? 'Aktif'
                                    : 'Nonaktif')
                            }}

                        </span>

                    </div>

                    {{-- Aksi --}}
                    <div class="flex items-center gap-4 relative">

                        {{-- Edit --}}
                        <a href="/seller/edit-produk/{{ $product['id'] }}">

                            <i class="ri-edit-box-line text-4xl text-gray-500"></i>

                        </a>

                        {{-- Menu --}}
                        <button
                        @click.stop="openMenu === {{ $product['id'] }}
                            ? openMenu = null
                            : openMenu = {{ $product['id'] }}">

                            <i class="ri-more-2-fill text-4xl text-gray-500"></i>

                        </button>

                        {{-- Dropdown --}}
                        <div
                        x-show="openMenu === {{ $product['id'] }}"
                        @click.outside="openMenu = null"
                        class="absolute top-12 right-0 bg-white rounded-3xl shadow-lg p-5 w-60 z-50">

                            <div class="space-y-4">

                                {{-- Detail --}}
                                <a
                                href="/seller/detail-produk/{{ $product['id'] }}"
                                class="flex items-center gap-3 text-sm">

                                    <i class="ri-eye-line text-2xl"></i>

                                    <span>
                                        Lihat Detail
                                    </span>

                                </a>

                                {{-- Hapus --}}
                                <form
                                    action="{{ route('seller.hapus-produk', $product['id']) }}"
                                    method="POST">

                                    @csrf
                                    @method('DELETE')

                                    <button
                                    class="flex items-center gap-3 text-sm text-red-500">

                                        <i class="ri-delete-bin-line text-2xl"></i>

                                        <span>
                                            Hapus Produk
                                        </span>

                                    </button>

                                </form>

                                {{-- Nonaktif --}}
                                <form
                                    action="{{ route('seller.toggle-status-produk', $product['id']) }}"
                                    method="POST">

                                        @csrf
                                        @method('PUT')

                                        <button
                                        class="flex items-center gap-3 text-sm text-[#F07A55]">

                                            <i class="ri-shut-down-line text-2xl"></i>

                                            <span>

                                                {{ $product['is_active']
                                                    ? 'Nonaktifkan Produk'
                                                    : 'Aktifkan Produk'
                                                }}

                                            </span>

                                        </button>

                                    </form>

                            </div>

                        </div>

                    </div>

                </div>

                @empty

                <div class="px-6 py-10 text-center text-gray-400">

                    Belum ada produk

                </div>

                @endforelse

            </div>
            </div>

        </div>

        {{-- MODAL HAPUS --}}
        <div
        x-show="openDelete"
        class="fixed inset-0 bg-black/20 flex items-center justify-center z-50">

            <div class="bg-[#F5F5F5] rounded-[35px] px-8 py-7 w-[330px] text-center">

                <i class="ri-delete-bin-line text-5xl"></i>

                <h2 class="text-2xl font-bold mt-3">
                    Hapus Produk
                </h2>

                <p class="text-gray-700 mt-3 leading-relaxed text-base">

                    Produk akan dihapus dari toko
                    secara permanen dan tidak
                    dapat dijual.

                </p>

                <div class="flex justify-center gap-3 mt-6">

                    <button
                    @click="openDelete = false"
                    class="bg-[#FF8FA3] px-5 py-2 rounded-full text-sm font-medium">

                        Batal

                    </button>

                    <button
                    class="bg-[#FF8FA3] px-5 py-2 rounded-full text-sm font-medium">

                        Hapus Produk

                    </button>

                </div>

            </div>

        </div>

        {{-- MODAL NONAKTIF --}}
        <div
        x-show="openNonaktif"
        class="fixed inset-0 bg-black/20 flex items-center justify-center z-50">

            <div class="bg-[#F5F5F5] rounded-[35px] px-8 py-7 w-[330px] text-center">

                <i class="ri-shut-down-line text-5xl"></i>

                <h2 class="text-2xl font-bold mt-3">
                    Nonaktifkan Produk
                </h2>

                <p class="text-gray-700 mt-3 leading-relaxed text-base">

                    Produk akan disembunyikan dari
                    toko dan tidak dapat dijual.

                </p>

                <div class="flex justify-center gap-3 mt-6">

                    <button
                    @click="openNonaktif = false"
                    class="bg-[#FF8FA3] px-5 py-2 rounded-full text-sm font-medium">

                        Batal

                    </button>

                    <button
                    class="bg-[#FF8FA3] px-5 py-2 rounded-full text-sm font-medium">

                        Ya, Nonaktifkan

                    </button>

                </div>

            </div>

        </div>

    </div>

</div>

@endsection