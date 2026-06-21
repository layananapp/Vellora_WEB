@extends('layouts.app')

@section('title', 'Manajemen Seller')

@php
    $apiUrl = config('services.marketplace_api.url');
@endphp

@section('content')

<div
class="min-h-screen bg-[#F5F5F5] flex flex-col lg:flex-row"
x-data="{ openMenu: null, openDetail: false, selectedSeller: null, apiUrl: '{{ $apiUrl }}' }">

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
                    Manajemen Seller
                </h2>
                <p class="text-gray-600 mt-1">
                    Kelola semua toko dan seller yang terdaftar di Vellora Marketplace
                </p>
            </div>

            {{-- STATS --}}
            <div class="flex gap-4 mt-5 overflow-x-auto pb-2">
                {{-- CARD --}}
                <div class="min-w-[170px] bg-white rounded-2xl shadow-sm px-4 py-3 flex items-center gap-3">
                    <div class="w-12 h-12 rounded-full bg-pink-100 flex items-center justify-center">
                        <i class="ri-store-2-line text-2xl text-pink-500"></i>
                    </div>
                    <div>
                        <h3 class="font-semibold text-sm">Total Seller</h3>
                        <h2 class="text-2xl font-bold leading-none mt-1">{{ count($sellers) }}</h2>
                        <p class="text-gray-500 text-xs mt-1">Semua Seller</p>
                    </div>
                </div>

                {{-- CARD --}}
                <div class="min-w-[170px] bg-white rounded-2xl shadow-sm px-4 py-3 flex items-center gap-3">
                    <div class="w-12 h-12 rounded-full bg-green-100 flex items-center justify-center">
                        <i class="ri-store-3-line text-2xl text-green-600"></i>
                    </div>
                    <div>
                        <h3 class="font-semibold text-sm">Seller Aktif</h3>
                        <h2 class="text-2xl font-bold leading-none mt-1">{{ collect($sellers)->where('is_suspended', false)->count() }}</h2>
                        <p class="text-gray-500 text-xs mt-1">Status Aktif</p>
                    </div>
                </div>

                {{-- CARD --}}
                <div class="min-w-[170px] bg-white rounded-2xl shadow-sm px-4 py-3 flex items-center gap-3">
                    <div class="w-12 h-12 rounded-full bg-red-100 flex items-center justify-center">
                        <i class="ri-user-unfollow-line text-2xl text-red-500"></i>
                    </div>
                    <div>
                        <h3 class="font-semibold text-sm">Diblokir</h3>
                        <h2 class="text-2xl font-bold leading-none mt-1">{{ collect($sellers)->where('is_suspended', true)->count() }}</h2>
                        <p class="text-gray-500 text-xs mt-1">Seller Suspended</p>
                    </div>
                </div>
            </div>

            {{-- FILTER --}}
            <div class="flex items-center gap-3 mt-5">
                {{-- FILTER --}}
                <div class="relative">
                    <button
                    @click="openMenu === 'filter' ? openMenu = null : openMenu = 'filter'"
                    class="bg-pink-100 rounded-full px-4 py-2 flex items-center gap-8 text-sm font-semibold">
                        <span>
                            @if(request('status') === 'aktif')
                                Aktif
                            @elseif(request('status') === 'nonaktif')
                                Suspended
                            @else
                                Semua Status
                            @endif
                        </span>
                        <i class="ri-arrow-down-s-line text-lg"></i>
                    </button>

                    {{-- DROPDOWN --}}
                    <div
                    x-show="openMenu === 'filter'"
                    @click.outside="openMenu = null"
                    x-transition
                    class="absolute top-11 left-0 bg-white rounded-2xl shadow-lg w-[160px] p-3 z-50">
                        <div class="space-y-2 flex flex-col items-start">
                            <a href="/admin/seller" class="text-sm py-1.5 hover:text-pink-500 transition">Semua</a>
                            <a href="/admin/seller?status=aktif" class="text-sm py-1.5 hover:text-pink-500 transition">Aktif</a>
                            <a href="/admin/seller?status=nonaktif" class="text-sm py-1.5 hover:text-pink-500 transition">Suspended</a>
                        </div>
                    </div>
                </div>
            </div>

            {{-- TABLE --}}
            <div class="bg-white rounded-2xl mt-5 shadow-sm overflow-x-auto">

                <div class="min-w-[800px]">

                    {{-- HEAD --}}
                    <div class="grid grid-cols-[2fr_1.5fr_1fr_1fr_60px] bg-pink-100 px-5 py-4 text-sm font-bold text-gray-700">
                    <h3>Toko / Seller</h3>
                    <h3>Email</h3>
                    <h3>Status</h3>
                    <h3>Tanggal Daftar</h3>
                    <h3 class="text-center">Aksi</h3>
                </div>

                    {{-- ROWS CONTAINER --}}
                    <div style="max-height: 290px; overflow-y: auto;">
                        {{-- ROWS --}}
                        @forelse ($sellers as $s)
                            @php
                                $isActiveFilter = !request('status') || 
                                    (request('status') === 'aktif' && !$s['is_suspended']) || 
                                    (request('status') === 'nonaktif' && $s['is_suspended']);
                            @endphp
                            @if($isActiveFilter)
                            <div class="grid grid-cols-[2fr_1.5fr_1fr_1fr_60px] items-center px-5 py-4 border-b border-gray-100 hover:bg-gray-50 transition text-sm text-gray-700">
                                {{-- TOKO --}}
                                <div class="flex items-center gap-3 min-w-0">
                                    <img src="{{ ($s['store'] && $s['store']['store_logo']) ? $apiUrl . '/' . $s['store']['store_logo'] : 'https://ui-avatars.com/api/?name=' . urlencode($s['store']['store_name'] ?? $s['name']) . '&background=FF8FA3&color=fff' }}"
                                         class="w-11 h-11 rounded-full object-cover flex-shrink-0">
                                    <div class="min-w-0">
                                        <h3 class="font-semibold text-sm text-gray-800 truncate">
                                            {{ $s['store']['store_name'] ?? 'Belum Buka Toko' }}
                                        </h3>
                                        <p class="text-xs text-gray-400 mt-1 truncate">
                                            Pemilik: {{ $s['name'] }}
                                        </p>
                                    </div>
                                </div>

                                {{-- EMAIL --}}
                                <p class="truncate pr-4">{{ $s['email'] }}</p>

                                {{-- STATUS --}}
                                <div>
                                    <span class="px-3 py-1 rounded-full text-xs font-semibold {{ $s['is_suspended'] ? 'bg-red-100 text-red-600' : 'bg-green-100 text-green-600' }}">
                                        {{ $s['is_suspended'] ? 'Suspended' : 'Aktif' }}
                                    </span>
                                </div>

                                {{-- TANGGAL --}}
                                <p>{{ \Carbon\Carbon::parse($s['created_at'])->translatedFormat('d M Y') }}</p>

                                {{-- AKSI --}}
                                <div class="relative flex justify-center">
                                    <button
                                    @click="openMenu === {{ $s['id'] }} ? openMenu = null : openMenu = {{ $s['id'] }}"
                                    class="p-1">
                                        <i class="ri-more-2-fill text-xl text-gray-500 hover:text-pink-500 transition"></i>
                                    </button>

                                    {{-- DROPDOWN --}}
                                    <div
                                    x-show="openMenu === {{ $s['id'] }}"
                                    @click.outside="openMenu = null"
                                    x-transition
                                    class="absolute right-0 top-9 bg-white rounded-2xl shadow-lg w-[180px] p-3 z-50 text-left">
                                        <button
                                        @click="selectedSeller = {{ json_encode($s) }}; openDetail = true; openMenu = null"
                                        class="flex items-center gap-3 text-sm hover:text-pink-500 transition w-full text-left">
                                            <i class="ri-eye-line"></i>
                                            <span>Lihat Detail</span>
                                        </button>

                                        <form action="/admin/user/{{ $s['id'] }}/{{ $s['is_suspended'] ? 'unsuspend' : 'suspend' }}" method="POST" class="mt-3">
                                            @csrf
                                            @method('PUT')
                                            <button type="submit" class="flex items-center gap-3 text-sm {{ $s['is_suspended'] ? 'text-green-600' : 'text-orange-500' }} w-full text-left">
                                                <i class="ri-forbid-line"></i>
                                                <span>{{ $s['is_suspended'] ? 'Unsuspend Seller' : 'Block Seller' }}</span>
                                            </button>
                                        </form>

                                        <form action="/admin/user/{{ $s['id'] }}" method="POST" class="mt-3">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="flex items-center gap-3 text-sm text-red-500 w-full text-left">
                                                <i class="ri-delete-bin-line"></i>
                                                <span>Hapus Seller</span>
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            @endif
                        @empty
                            <div class="p-8 text-center text-gray-400">
                                Belum ada seller terdaftar.
                            </div>
                        @endforelse
                    </div>
                </div>

            </div>
        </div>
    </div>

    {{-- MODAL DETAIL SELLER --}}
    <div
    x-show="openDetail"
    x-transition
    class="fixed inset-0 bg-black/40 flex items-center justify-center z-50 p-4"
    x-cloak>
        <div
        @click.outside="openDetail = false"
        class="bg-white rounded-[26px] w-full max-w-[600px] mx-4 overflow-hidden shadow-2xl">
            {{-- HEADER --}}
            <div class="flex items-center justify-between px-5 py-4 border-b border-gray-200">
                <h2 class="text-2xl font-bold text-gray-800">Detail Toko / Seller</h2>
                <button @click="openDetail = false">
                    <i class="ri-close-line text-3xl text-gray-500 hover:text-red-500 transition"></i>
                </button>
            </div>

            {{-- CONTENT --}}
            <div class="px-5 py-6 space-y-6" x-if="selectedSeller">
                <div class="flex gap-4 items-center">
                    <img :src="selectedSeller && selectedSeller.store?.store_logo ? apiUrl + '/' + selectedSeller.store.store_logo : 'https://ui-avatars.com/api/?name=' + encodeURIComponent(selectedSeller ? (selectedSeller.store?.store_name || selectedSeller.name) : 'S') + '&background=FF8FA3&color=fff&size=120'"
                         class="w-20 h-20 rounded-full object-cover border">
                    <div>
                        <h2 class="text-2xl font-bold text-gray-800" x-text="selectedSeller && selectedSeller.store?.store_name ? selectedSeller.store.store_name : 'Belum Buka Toko'"></h2>
                        <span class="px-3 py-1 rounded-full text-xs font-semibold mt-2 inline-block"
                              :class="selectedSeller && selectedSeller.is_suspended ? 'bg-red-100 text-red-600' : 'bg-green-100 text-green-600'"
                              x-text="selectedSeller && selectedSeller.is_suspended ? 'Suspended' : 'Aktif'"></span>
                    </div>
                </div>

                <div class="space-y-3 bg-gray-50 p-4 rounded-2xl border border-gray-100 text-sm">
                    <div class="flex justify-between">
                        <span class="text-gray-400 font-medium">Pemilik Toko</span>
                        <span class="font-semibold text-gray-800" x-text="selectedSeller ? selectedSeller.name : ''"></span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-400 font-medium">Email</span>
                        <span class="font-semibold text-gray-800" x-text="selectedSeller ? selectedSeller.email : ''"></span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-400 font-medium">Nomor HP Toko</span>
                        <span class="font-semibold text-gray-800" x-text="selectedSeller && selectedSeller.store ? (selectedSeller.store.phone_number || '-') : '-'"></span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-400 font-medium">Tanggal Daftar</span>
                        <span class="font-semibold text-gray-800" x-text="selectedSeller ? new Date(selectedSeller.created_at).toLocaleDateString('id-ID', {day: 'numeric', month: 'long', year: 'numeric'}) : ''"></span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection