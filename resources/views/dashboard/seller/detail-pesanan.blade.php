@extends('layouts.app')

@section('title', 'Detail Pesanan')

@php
    $apiUrl = config('services.marketplace_api.url');
@endphp

@section('content')

<div class="min-h-screen bg-[#FFF9F9] flex flex-col lg:flex-row" x-data>

    @include('dashboard.seller.partials.sidebar')

    {{-- CONTENT --}}
    <div class="flex-1 overflow-y-auto">

        {{-- TOPBAR --}}
        @include('dashboard.seller.partials.topbar')

        {{-- MAIN --}}
        <div class="p-5">

            {{-- Header --}}
            <div class="flex items-center gap-3">
                <a href="/seller/pesanan">
                    <i class="ri-arrow-left-line text-4xl text-black"></i>
                </a>
                <h2 class="text-3xl font-bold">Pesanan</h2>
                <i class="ri-arrow-right-s-line text-3xl"></i>
                <h2 class="text-3xl font-bold">Detail Pesanan</h2>
            </div>

            <p class="text-gray-500 mt-2 ml-12">Informasi lengkap pesanan pelanggan</p>

            {{-- Flash Messages --}}
            @if(session('error'))
                <div class="mt-4 bg-red-100 text-red-700 px-4 py-3 rounded-xl">
                    {{ session('error') }}
                </div>
            @endif

            @php
                $statusColors = [
                    'pending_payment'      => ['bg' => 'bg-yellow-100', 'text' => 'text-yellow-700', 'icon' => 'ri-time-line'],
                    'waiting_verification' => ['bg' => 'bg-blue-100',   'text' => 'text-blue-700',   'icon' => 'ri-eye-line'],
                    'processing'           => ['bg' => 'bg-orange-100', 'text' => 'text-orange-700', 'icon' => 'ri-box-3-line'],
                    'shipped'              => ['bg' => 'bg-purple-100', 'text' => 'text-purple-700', 'icon' => 'ri-truck-line'],
                    'delivered'            => ['bg' => 'bg-green-100',  'text' => 'text-green-700',  'icon' => 'ri-checkbox-circle-fill'],
                    'cancelled'            => ['bg' => 'bg-red-100',    'text' => 'text-red-700',    'icon' => 'ri-close-circle-line'],
                ];
                $sc = $statusColors[$order['status'] ?? ''] ?? ['bg' => 'bg-gray-100', 'text' => 'text-gray-700', 'icon' => 'ri-question-line'];
            @endphp

            {{-- TOP CONTENT --}}
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mt-6">

                {{-- LEFT — Info Pembeli --}}
                <div class="bg-white p-6 rounded-2xl shadow-sm">

                    <h3 class="text-xl font-bold">Informasi Pembeli</h3>

                    <div class="mt-6 space-y-5">

                        {{-- Nama --}}
                        <div>
                            <label class="block text-sm font-medium text-gray-500 mb-2">Nama Penerima</label>
                            <input
                                type="text"
                                value="{{ $order['address']['recipient_name'] ?? '-' }}"
                                readonly
                                class="w-full border-2 border-gray-200 rounded-full px-5 py-3 outline-none bg-gray-50 text-sm">
                        </div>

                        {{-- No HP --}}
                        <div>
                            <label class="block text-sm font-medium text-gray-500 mb-2">No. Telepon</label>
                            <input
                                type="text"
                                value="{{ $order['address']['phone_number'] ?? '-' }}"
                                readonly
                                class="w-full border-2 border-gray-200 rounded-full px-5 py-3 outline-none bg-gray-50 text-sm">
                        </div>

                        {{-- Alamat --}}
                        <div>
                            <label class="block text-sm font-medium text-gray-500 mb-2">Alamat Pengiriman</label>
                            <textarea
                                rows="4"
                                readonly
                                class="w-full border-2 border-gray-200 rounded-2xl px-5 py-4 outline-none resize-none bg-gray-50 text-sm leading-relaxed">{{ $order['address']['full_address'] ?? '-' }}{{ isset($order['address']['detail_address']) ? "\n" . $order['address']['detail_address'] : '' }}{{ isset($order['address']['postal_code']) ? "\nKode Pos: " . $order['address']['postal_code'] : '' }}</textarea>
                        </div>

                    </div>

                    {{-- Info Pengiriman --}}
                    @if(!empty($order['courier']) && $order['courier'] !== '-')
                        <div class="mt-5 pt-5 border-t border-gray-100 grid grid-cols-2 gap-4">
                            <div>
                                <p class="text-xs text-gray-400 mb-1">Ekspedisi</p>
                                <p class="font-semibold text-sm">{{ $order['courier'] }}</p>
                            </div>
                            @if(!empty($order['receipt_number']) && $order['receipt_number'] !== '-')
                                <div>
                                    <p class="text-xs text-gray-400 mb-1">No. Resi</p>
                                    <p class="font-semibold text-sm font-mono">{{ $order['receipt_number'] }}</p>
                                </div>
                            @endif
                        </div>
                    @endif

                </div>

                {{-- RIGHT — Ringkasan Pesanan --}}
                <div class="bg-white p-6 rounded-2xl shadow-sm">

                    <div class="flex items-start justify-between">
                        <h3 class="text-xl font-bold">Ringkasan Pesanan</h3>
                        {{-- Status Badge --}}
                        <div class="{{ $sc['bg'] }} {{ $sc['text'] }} px-4 py-2 rounded-full flex items-center gap-2 text-sm font-medium">
                            <i class="{{ $sc['icon'] }}"></i>
                            <span>{{ $order['frontend_status'] ?? ucfirst($order['status'] ?? '-') }}</span>
                        </div>
                    </div>

                    {{-- Products --}}
                    <div class="mt-6 space-y-4 max-h-56 overflow-y-auto">
                        @foreach($order['items'] ?? [] as $item)
                            @php
                                $img = $item['product_image'] ?? null;
                                $imgUrl = $img
                                    ? (str_starts_with($img, 'http') ? $img : $apiUrl . '/' . $img)
                                    : 'https://via.placeholder.com/80';
                            @endphp
                            <div class="flex items-start justify-between">
                                <div class="flex gap-3">
                                    <img src="{{ $imgUrl }}" alt="" class="w-16 h-16 object-cover rounded-xl flex-shrink-0">
                                    <div>
                                        <h4 class="font-semibold text-sm leading-tight">
                                            {{ $item['product_name'] ?? '-' }}
                                        </h4>
                                        @if(!empty($item['variant']))
                                            <p class="text-gray-400 text-xs mt-1">{{ $item['variant'] }}</p>
                                        @endif
                                        <p class="text-gray-500 text-xs mt-1">{{ $item['qty'] ?? 1 }}x</p>
                                    </div>
                                </div>
                                <p class="font-semibold text-sm whitespace-nowrap ml-3">
                                    Rp{{ number_format($item['subtotal'] ?? 0, 0, ',', '.') }}
                                </p>
                            </div>
                        @endforeach
                    </div>

                    {{-- Totals --}}
                    <div class="border-t border-gray-200 mt-5 pt-4 space-y-3">

                        <div class="flex items-center justify-between text-sm">
                            <p class="text-gray-500">Subtotal Produk</p>
                            <p class="font-medium">Rp{{ number_format($order['product_subtotal'] ?? 0, 0, ',', '.') }}</p>
                        </div>

                        <div class="flex items-center justify-between text-sm">
                            <p class="text-gray-500">Ongkir</p>
                            <p class="font-medium">Rp{{ number_format($order['shipping_cost'] ?? 0, 0, ',', '.') }}</p>
                        </div>

                        @if(($order['voucher_discount'] ?? 0) > 0)
                            <div class="flex items-center justify-between text-sm">
                                <p class="text-gray-500">Diskon Voucher</p>
                                <p class="font-medium text-green-600">-Rp{{ number_format($order['voucher_discount'], 0, ',', '.') }}</p>
                            </div>
                        @endif

                        <div class="flex items-center justify-between pt-3 border-t border-gray-200">
                            <h4 class="font-bold text-lg">Total Pembayaran</h4>
                            <h4 class="font-bold text-lg text-[#F07A55]">
                                Rp{{ number_format($order['total_amount'] ?? 0, 0, ',', '.') }}
                            </h4>
                        </div>

                        {{-- Payment Status --}}
                        <div class="flex items-center justify-between text-sm">
                            <p class="text-gray-500">Status Pembayaran</p>
                            @php
                                $ps = $order['payment_status'] ?? 'pending';
                                $psColor = match($ps) {
                                    'paid', 'success' => 'text-green-600',
                                    'failed', 'expired' => 'text-red-500',
                                    default => 'text-yellow-600',
                                };
                                $psLabel = match($ps) {
                                    'paid', 'success' => 'Lunas',
                                    'failed' => 'Gagal',
                                    'expired' => 'Kadaluarsa',
                                    default => 'Menunggu',
                                };
                            @endphp
                            <span class="font-semibold {{ $psColor }}">{{ $psLabel }}</span>
                        </div>

                    </div>

                </div>

            </div>

            {{-- ORDER HISTORY --}}
            @if(!empty($order['histories']))
                <div class="bg-white mt-6 p-6 rounded-2xl shadow-sm">

                    <h3 class="text-xl font-bold mb-6">Riwayat Pesanan</h3>

                    <div class="relative pl-6">

                        {{-- Vertical line --}}
                        <div class="absolute left-2 top-0 bottom-0 w-0.5 bg-gray-200"></div>

                        <div class="space-y-6">
                            @foreach($order['histories'] as $history)
                                <div class="relative">
                                    <div class="absolute -left-4 top-1 w-3 h-3 rounded-full bg-[#F07A55]"></div>
                                    <div>
                                        <p class="font-semibold text-sm">{{ $history['description'] ?? ucfirst($history['status']) }}</p>
                                        <p class="text-gray-400 text-xs mt-1">
                                            {{ \Carbon\Carbon::parse($history['time'])->translatedFormat('d M Y, H:i') }} WIB
                                        </p>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                    </div>

                </div>
            @endif

            {{-- CATATAN (jika ada) --}}
            @if(!empty($order['notes']))
                <div class="bg-white mt-6 p-6 rounded-2xl shadow-sm">
                    <h3 class="text-xl font-bold mb-3">Catatan dari Pembeli</h3>
                    <p class="text-gray-600 text-sm leading-relaxed">{{ $order['notes'] }}</p>
                </div>
            @endif

            {{-- INFO Update Status --}}
            <div class="bg-blue-50 border border-blue-200 mt-6 p-5 rounded-2xl flex items-start gap-3">
                <i class="ri-information-line text-blue-500 text-xl mt-0.5 flex-shrink-0"></i>
                <p class="text-sm text-blue-700">
                    Untuk mengupdate status pengiriman (menambahkan ekspedisi & nomor resi),
                    fitur ini akan segera tersedia. Saat ini status pesanan diperbarui otomatis
                    berdasarkan konfirmasi pembeli.
                </p>
            </div>

        </div>

    </div>

</div>

@endsection