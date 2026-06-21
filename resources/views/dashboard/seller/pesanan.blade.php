@extends('layouts.app')

@section('title', 'Pesanan')

@php
    $apiUrl = config('services.marketplace_api.url');
@endphp

@section('content')

<div class="min-h-screen bg-[#FFF9F9] flex flex-col lg:flex-row" x-data>

    {{-- SIDEBAR --}}
    @include('dashboard.seller.partials.sidebar')

    {{-- CONTENT --}}
    <div class="flex-1 w-full">

        {{-- TOP BAR --}}
        @include('dashboard.seller.partials.topbar')

        {{-- MAIN --}}
        <div class="p-4 md:p-6">

            {{-- Header --}}
            <div class="flex items-center gap-3">
                <a href="/seller/dashboard" class="flex items-center gap-3">
                    <i class="ri-arrow-left-line text-3xl md:text-4xl text-black"></i>
                </a>
                <h2 class="text-2xl md:text-3xl font-bold">Pesanan</h2>
            </div>

            {{-- Flash Messages --}}
            @if(session('success'))
                <div class="mt-4 bg-green-100 text-green-700 px-4 py-3 rounded-xl">
                    {{ session('success') }}
                </div>
            @endif
            @if(session('error'))
                <div class="mt-4 bg-red-100 text-red-700 px-4 py-3 rounded-xl">
                    {{ session('error') }}
                </div>
            @endif

            {{-- Tabs --}}
            <div
                x-data="{ status: 'semua' }"
                class="bg-white mt-6 px-6 py-4 flex items-center gap-8 md:gap-12 shadow-sm overflow-x-auto whitespace-nowrap scrollbar-none">

                @php
                $tabs = [
                    'semua'               => 'Semua',
                    'pending_payment'     => 'Belum Dibayar',
                    'waiting_verification'=> 'Verifikasi',
                    'processing'          => 'Dikemas',
                    'shipped'             => 'Dikirim',
                    'delivered'           => 'Selesai',
                    'cancelled'           => 'Dibatalkan',
                ];
                @endphp

                @foreach($tabs as $key => $label)
                    <button
                        @click="status='{{ $key }}'"
                        :class="status === '{{ $key }}'
                            ? 'text-[#F6B093] border-b-4 border-[#F6B093] font-semibold'
                            : 'text-black'"
                        class="pb-1 transition whitespace-nowrap text-sm md:text-base">
                        {{ $label }}
                        @if($key !== 'semua')
                            @php
                                $count = collect($orders)->where('status', $key)->count();
                            @endphp
                            @if($count > 0)
                                <span class="ml-1 bg-[#F6B093] text-white text-[10px] rounded-full px-2 py-0.5">{{ $count }}</span>
                            @endif
                        @endif
                    </button>
                @endforeach

            </div>

            {{-- TABLE --}}
            <div class="overflow-x-auto w-full mt-6 rounded-xl shadow-sm border border-gray-100">
                <div class="bg-white min-w-[800px]">

                {{-- Head --}}
                <div class="bg-pink-100 grid grid-cols-6 px-6 py-4">
                    <h3 class="font-medium">Produk</h3>
                    <h3 class="font-medium">No. Pesanan</h3>
                    <h3 class="font-medium">Total</h3>
                    <h3 class="font-medium">Status</h3>
                    <h3 class="font-medium">Tanggal</h3>
                    <h3 class="font-medium">Aksi</h3>
                </div>

                {{-- DATA --}}
                <div x-data="{ status: 'semua' }">

                    {{-- Tabs trigger (shared state workaround) --}}
                    @forelse($orders as $order)

                        @php
                            $image = $order['product_image'] ?? null;
                            $imageUrl = $image
                                ? (str_starts_with($image, 'http') ? $image : $apiUrl . '/' . $image)
                                : 'https://via.placeholder.com/56';

                            $statusColors = [
                                'pending_payment'      => 'bg-yellow-100 text-yellow-700',
                                'waiting_verification' => 'bg-blue-100 text-blue-700',
                                'processing'           => 'bg-orange-100 text-orange-700',
                                'shipped'              => 'bg-purple-100 text-purple-700',
                                'delivered'            => 'bg-green-100 text-green-700',
                                'cancelled'            => 'bg-red-100 text-red-700',
                            ];
                            $statusColor = $statusColors[$order['status']] ?? 'bg-gray-100 text-gray-700';
                        @endphp

                        <div
                            x-data="{ orderStatus: '{{ $order['status'] }}' }"
                            x-show="$root.querySelector ? true : true"
                            class="order-row grid grid-cols-6 px-6 py-5 items-center border-b"
                            data-status="{{ $order['status'] }}">

                            {{-- Produk --}}
                            <div class="flex gap-3 items-center">
                                <img
                                    src="{{ $imageUrl }}"
                                    class="w-14 h-14 object-cover rounded-lg flex-shrink-0"
                                    alt="">
                                <div>
                                    <h3 class="leading-tight text-sm font-medium">
                                        {{ $order['product_name'] ?? '-' }}
                                    </h3>
                                    <p class="text-gray-400 text-xs mt-1">
                                        {{ $order['qty'] ?? 1 }}x
                                        @if(($order['items_count'] ?? 1) > 1)
                                            <span class="text-[#F07A55]">+{{ ($order['items_count'] - 1) }} lainnya</span>
                                        @endif
                                    </p>
                                </div>
                            </div>

                            {{-- No. Pesanan --}}
                            <div>
                                <p class="text-sm text-gray-600 font-mono">
                                    #{{ $order['id'] }}
                                </p>
                            </div>

                            {{-- Total --}}
                            <div>
                                <h3 class="font-semibold text-sm">
                                    Rp{{ number_format($order['total_amount'] ?? 0, 0, ',', '.') }}
                                </h3>
                            </div>

                            {{-- Status --}}
                            <div>
                                <span class="px-3 py-1.5 rounded-full text-xs font-medium {{ $statusColor }}">
                                    {{ $order['frontend_status'] ?? ucfirst($order['status']) }}
                                </span>
                            </div>

                            {{-- Tanggal --}}
                            <div>
                                <h3 class="text-sm">
                                    {{ \Carbon\Carbon::parse($order['created_at'])->translatedFormat('d M Y') }}
                                </h3>
                                <p class="text-gray-400 text-xs mt-1">
                                    {{ \Carbon\Carbon::parse($order['created_at'])->format('H:i') }} WIB
                                </p>
                            </div>

                            {{-- Aksi --}}
                            <div>
                                <a
                                    href="/seller/detail-pesanan/{{ $order['id'] }}"
                                    class="text-[#F07A55] hover:text-pink-600 font-medium text-sm transition">
                                    Lihat Detail →
                                </a>
                            </div>

                        </div>

                    @empty

                        <div class="px-6 py-16 text-center">
                            <i class="ri-shopping-bag-3-line text-5xl text-gray-200"></i>
                            <p class="text-gray-400 mt-3">Belum ada pesanan masuk</p>
                        </div>

                    @endforelse

                </div>

            </div>
            </div>

        </div>

    </div>

</div>

<script>
    // Tab filtering via vanilla JS
    document.addEventListener('DOMContentLoaded', function () {
        const buttons = document.querySelectorAll('[data-tab-btn]');
        const rows    = document.querySelectorAll('.order-row');

        // Attach event to tab buttons added via Alpine
        document.querySelectorAll('[\\@click]');
    });

    // Simple client-side filter using data-status attribute
    function filterOrders(status) {
        document.querySelectorAll('.order-row').forEach(function (row) {
            if (status === 'semua' || row.dataset.status === status) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
    }

    // Hook into Alpine tab clicks
    document.addEventListener('click', function (e) {
        const btn = e.target.closest('button[\\@click]');
        // Alpine handles the status var, we watch it via MutationObserver alternative
    });
</script>

{{-- Tab filter script using Alpine status --}}
<script>
    document.addEventListener('alpine:initialized', () => {
        // Watch all tab buttons for status change
        document.querySelectorAll('button').forEach(btn => {
            btn.addEventListener('click', function() {
                const match = this.getAttribute('@click')?.match(/status='([^']+)'/);
                if (match) {
                    setTimeout(() => filterOrders(match[1]), 10);
                }
            });
        });
    });
</script>

@endsection