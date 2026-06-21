@extends('layouts.app')

@section('title', 'Notifikasi')

@section('content')

<div class="min-h-screen bg-[#FFF9F9] flex flex-col lg:flex-row" x-data>

    @include('dashboard.seller.partials.sidebar')

    {{-- CONTENT --}}
    <div class="flex-1 w-full">

        {{-- TOPBAR --}}
        @include('dashboard.seller.partials.topbar')

        {{-- MAIN --}}
        <div class="p-4 md:p-6">

            {{-- Header --}}
            <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">

                {{-- Left --}}
                <div>
                    <div class="flex items-center gap-3">
                        <a href="/seller/dashboard">
                            <i class="ri-arrow-left-line text-3xl md:text-4xl text-black"></i>
                        </a>
                        <h2 class="text-2xl md:text-3xl font-bold">Notifikasi</h2>
                    </div>
                    <p class="text-gray-500 mt-2 text-sm md:ml-12">Semua aktivitas dan informasi terbaru toko Anda</p>
                </div>

                {{-- Count --}}
                @php
                    $unreadCount = collect($notifications)->where('is_read', false)->count();
                @endphp
                @if($unreadCount > 0)
                    <div class="bg-[#F07A55] text-white text-xs md:text-sm font-semibold px-4 py-2 rounded-full sm:self-center">
                        {{ $unreadCount }} belum dibaca
                    </div>
                @endif

            </div>

            {{-- LIST --}}
            <div class="mt-5 bg-white rounded-xl border border-gray-100 shadow-sm">

                @forelse($notifications as $notif)

                    @php
                        $iconMap = [
                            'order'    => ['icon' => 'ri-shopping-bag-3-line', 'bg' => 'bg-[#C6DB8B]'],
                            'payment'  => ['icon' => 'ri-secure-payment-line',  'bg' => 'bg-blue-100'],
                            'chat'     => ['icon' => 'ri-chat-3-line',           'bg' => 'bg-purple-100'],
                            'review'   => ['icon' => 'ri-star-line',             'bg' => 'bg-yellow-100'],
                            'system'   => ['icon' => 'ri-settings-3-line',       'bg' => 'bg-gray-100'],
                        ];
                        $type    = $notif['type'] ?? 'system';
                        $ic      = $iconMap[$type] ?? $iconMap['system'];
                        $isUnread = !($notif['is_read'] ?? true);
                    @endphp

                    <div class="flex items-start justify-between px-5 py-4 border-b border-gray-100 {{ $isUnread ? 'bg-pink-50' : '' }} hover:bg-gray-50 transition">

                        <div class="flex-1 min-w-0 flex items-start gap-3">

                            {{-- Icon --}}
                            <div class="w-10 h-10 rounded-full {{ $ic['bg'] }} flex items-center justify-center flex-shrink-0">
                                <i class="{{ $ic['icon'] }} text-gray-600 text-lg"></i>
                            </div>

                            {{-- Text --}}
                            <div class="flex-1 min-w-0">
                                <h3 class="font-semibold text-sm {{ $isUnread ? 'text-black' : 'text-gray-700' }}">
                                    {{ $notif['title'] ?? 'Notifikasi' }}
                                </h3>
                                <p class="text-sm text-gray-600 mt-1 leading-relaxed">
                                    {{ $notif['message'] ?? '' }}
                                </p>
                            </div>

                        </div>

                        {{-- Right --}}
                        <div class="flex items-center gap-3 ml-5 flex-shrink-0">
                            <div class="text-right text-gray-400 text-xs leading-tight whitespace-nowrap">
                                {{ $notif['time'] ?? \Carbon\Carbon::parse($notif['created_at'])->diffForHumans() }}
                            </div>
                            @if($isUnread)
                                <div class="w-2.5 h-2.5 rounded-full bg-[#F07A55] flex-shrink-0"></div>
                            @else
                                <div class="w-2.5 h-2.5 rounded-full bg-gray-200 flex-shrink-0"></div>
                            @endif
                        </div>

                    </div>

                @empty

                    <div class="flex flex-col items-center justify-center h-full py-20 text-gray-400">
                        <i class="ri-notification-off-line text-5xl mb-3"></i>
                        <p class="font-medium">Belum ada notifikasi</p>
                        <p class="text-sm mt-1">Notifikasi pesanan & aktivitas toko akan muncul di sini</p>
                    </div>

                @endforelse

            </div>

        </div>

    </div>

</div>

@endsection