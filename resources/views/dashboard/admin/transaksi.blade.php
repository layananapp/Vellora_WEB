@extends('layouts.app')

@section('title', 'Manajemen Transaksi')

@section('content')

<div
class="min-h-screen bg-[#F5F5F5] flex flex-col lg:flex-row"
x-data="{ openMenu: null, openFilter: false, openDetail: false, selectedOrder: null }">

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
                    Manajemen Transaksi
                </h2>
                <p class="text-gray-600 mt-1">
                    Pantau dan kelola seluruh transaksi pembayaran di Vellora Marketplace
                </p>
            </div>

            {{-- STATS CARDS --}}
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mt-6">
                {{-- Total --}}
                <div class="bg-white rounded-2xl shadow-sm p-4 flex items-center gap-4">
                    <div class="w-12 h-12 bg-pink-100 rounded-full flex items-center justify-center flex-shrink-0">
                        <i class="ri-file-list-3-line text-2xl text-pink-500"></i>
                    </div>
                    <div>
                        <p class="text-gray-500 text-xs font-semibold">Total Transaksi</p>
                        <h3 class="text-2xl font-bold mt-0.5">{{ count($orders) }}</h3>
                    </div>
                </div>

                {{-- Total Volume --}}
                <div class="bg-white rounded-2xl shadow-sm p-4 flex items-center gap-4">
                    <div class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center flex-shrink-0">
                        <i class="ri-money-dollar-circle-line text-2xl text-green-600"></i>
                    </div>
                    <div>
                        <p class="text-gray-500 text-xs font-semibold">Total Volume Pembayaran</p>
                        <h3 class="text-2xl font-bold mt-0.5">Rp{{ number_format(collect($orders)->sum('total_price'), 0, ',', '.') }}</h3>
                    </div>
                </div>

                {{-- Paid --}}
                <div class="bg-white rounded-2xl shadow-sm p-4 flex items-center gap-4">
                    <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center flex-shrink-0">
                        <i class="ri-checkbox-circle-line text-2xl text-blue-500"></i>
                    </div>
                    <div>
                        <p class="text-gray-500 text-xs font-semibold">Transaksi Berhasil (Lunas)</p>
                        <h3 class="text-2xl font-bold mt-0.5">{{ collect($orders)->where('payment.payment_status', 'paid')->count() }}</h3>
                    </div>
                </div>
            </div>

            {{-- FILTER --}}
            <div class="flex items-center gap-3 mt-6">
                {{-- FILTER --}}
                <div class="relative">
                    <button
                    @click="openFilter = !openFilter"
                    class="bg-pink-100 rounded-full px-5 py-2 flex items-center gap-6 text-sm font-semibold">
                        <span>
                            @if(request('status') === 'paid')
                                Lunas (Paid)
                            @elseif(request('status') === 'pending')
                                Pending
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
                    class="absolute top-11 left-0 bg-white rounded-2xl shadow-lg w-[160px] p-3 z-50">
                        <div class="space-y-2 flex flex-col items-start">
                            <a href="/admin/transaksi" class="text-sm py-1 hover:text-pink-500 transition">Semua</a>
                            <a href="/admin/transaksi?status=paid" class="text-sm py-1 hover:text-pink-500 transition">Lunas</a>
                            <a href="/admin/transaksi?status=pending" class="text-sm py-1 hover:text-pink-500 transition">Pending</a>
                        </div>
                    </div>
                </div>
            </div>

            {{-- TABLE --}}
            <div class="bg-white rounded-2xl mt-5 shadow-sm overflow-x-auto">

                <div class="min-w-[800px]">
                {{-- HEAD --}}
                <div class="grid grid-cols-[1.5fr_1.5fr_1fr_1.2fr_1.2fr_60px] bg-pink-100 px-5 py-4 text-sm font-bold text-gray-700">
                    <h3>Invoice / ID</h3>
                    <h3>Pembeli</h3>
                    <h3>Total</h3>
                    <h3>Metode Bayar</h3>
                    <h3>Status Order</h3>
                    <h3 class="text-center">Aksi</h3>
                </div>

                    {{-- ROWS CONTAINER --}}
                    <div style="max-height: 290px; overflow-y: auto;">
                        {{-- ROWS --}}
                        @forelse ($orders as $o)
                            @php
                                $paymentStatus = $o['payment']['payment_status'] ?? 'pending';
                                $isActiveFilter = !request('status') || request('status') === $paymentStatus;
                            @endphp
                            @if($isActiveFilter)
                            <div class="grid grid-cols-[1.5fr_1.5fr_1fr_1.2fr_1.2fr_60px] items-center px-5 py-4 border-b border-gray-100 hover:bg-gray-50 transition text-sm text-gray-700">
                                {{-- INVOICE --}}
                                <div>
                                    <span class="font-semibold text-gray-850">#{{ $o['invoice_number'] }}</span>
                                    <p class="text-xs text-gray-400 mt-1">{{ \Carbon\Carbon::parse($o['created_at'])->translatedFormat('d M Y, H:i') }}</p>
                                </div>

                                {{-- USER --}}
                                <div>
                                    <span class="font-semibold text-gray-800">{{ $o['user']['name'] ?? 'User' }}</span>
                                </div>

                                {{-- TOTAL --}}
                                <span class="font-bold text-gray-800">Rp{{ number_format($o['total_price'], 0, ',', '.') }}</span>

                                {{-- METHOD --}}
                                <span>{{ $o['payment']['payment_method'] ?? 'QRIS' }}</span>

                                {{-- STATUS --}}
                                <div>
                                    <span class="px-3 py-1 rounded-full text-xs font-semibold
                                        @if($o['status'] === 'pending_payment') bg-yellow-100 text-yellow-600
                                        @elseif($o['status'] === 'processing' || $o['status'] === 'processed') bg-blue-100 text-blue-600
                                        @elseif($o['status'] === 'shipped') bg-indigo-100 text-indigo-600
                                        @elseif($o['status'] === 'delivered') bg-green-100 text-green-600
                                        @else bg-red-100 text-red-600
                                        @endif">
                                        {{ ucfirst(str_replace('_', ' ', $o['status'])) }}
                                    </span>
                                </div>

                                {{-- ACTION --}}
                                <div class="relative flex justify-center">
                                    <button
                                    @click="selectedOrder = {{ json_encode($o) }}; openDetail = true"
                                    class="p-1 text-gray-500 hover:text-pink-500 transition">
                                        <i class="ri-eye-line text-lg"></i>
                                    </button>
                                </div>
                            </div>
                            @endif
                        @empty
                            <div class="p-8 text-center text-gray-400">
                                Belum ada transaksi terjadi.
                            </div>
                        @endforelse
                    </div>
                </div>

            </div>
        </div>
    </div>

    {{-- MODAL DETAIL TRANSAKSI --}}
    <div
    x-show="openDetail"
    x-transition
    class="fixed inset-0 bg-black/40 flex items-center justify-center z-50 p-4"
    x-cloak>
        <div
        @click.outside="openDetail = false"
        class="bg-white rounded-[22px] w-full max-w-[550px] mx-4 overflow-hidden shadow-2xl">
            {{-- HEADER --}}
            <div class="flex items-center justify-between px-5 py-3 border-b border-gray-200">
                <h2 class="text-xl font-bold text-gray-800">Detail Transaksi</h2>
                <button @click="openDetail = false">
                    <i class="ri-close-line text-2xl text-gray-500 hover:text-red-500 transition"></i>
                </button>
            </div>

            {{-- CONTENT --}}
            <div class="px-5 py-5 space-y-6" x-if="selectedOrder">
                <div>
                    <h3 class="text-lg font-bold text-gray-800" x-text="'Invoice: #' + selectedOrder.invoice_number"></h3>
                    <p class="text-xs text-gray-400" x-text="new Date(selectedOrder.created_at).toLocaleString('id-ID', {day: 'numeric', month: 'long', year: 'numeric', hour: '2-digit', minute: '2-digit'})"></p>
                </div>

                <div class="grid grid-cols-2 gap-4 text-sm bg-gray-50 p-4 rounded-2xl border border-gray-100">
                    <div>
                        <h4 class="font-bold text-gray-400">Pelanggan</h4>
                        <p class="font-semibold text-gray-800 mt-1" x-text="selectedOrder.user?.name || '-'"></p>
                        <p class="text-xs text-gray-500" x-text="selectedOrder.user?.email || ''"></p>
                    </div>
                    <div>
                        <h4 class="font-bold text-gray-400">Metode Pembayaran</h4>
                        <p class="font-semibold text-gray-800 mt-1" x-text="selectedOrder.payment?.payment_method || 'QRIS'"></p>
                    </div>
                </div>

                <div class="space-y-3">
                    <h4 class="font-bold text-gray-800">Rincian Pembayaran</h4>
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-500">Harga Barang</span>
                        <span class="font-semibold text-gray-800" x-text="'Rp' + new Intl.NumberFormat('id-ID').format(selectedOrder.total_price)"></span>
                    </div>
                    <div class="flex justify-between text-sm border-t border-gray-100 pt-2 font-bold">
                        <span class="text-gray-800">Total Transaksi</span>
                        <span class="text-pink-500" x-text="'Rp' + new Intl.NumberFormat('id-ID').format(selectedOrder.total_price)"></span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection