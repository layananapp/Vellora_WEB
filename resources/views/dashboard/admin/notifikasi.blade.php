@extends('layouts.app')

@section('title', 'Manajemen Notifikasi')

@section('content')

<div class="min-h-screen bg-[#F5F5F5] flex flex-col lg:flex-row" x-data>

@include('dashboard.admin.partials.sidebar')

    {{-- CONTENT --}}
    <div class="flex-1">

        {{-- TOPBAR --}}
        @include('dashboard.admin.partials.topbar')

        {{-- MAIN --}}
        <div class="p-5">

            {{-- HEADER --}}
            <div>

                <h2 class="text-3xl font-bold">
                    Manajemen Notifikasi
                </h2>

                <p class="text-gray-600 mt-1 text-sm">
                    Kelola semua notifikasi dan aktivitas penting di Vellora Marketplace
                </p>

            </div>

            {{-- SEARCH + BUTTON --}}
            <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 mt-5">

                {{-- SEARCH --}}
                <div class="bg-pink-100 rounded-full px-4 py-2 flex items-center gap-3 w-[270px]">

                    <i class="ri-search-line text-lg text-[#F07A55]"></i>

                    <input
                        type="text"
                        placeholder="Cari nama, email atau no telepon"
                        class="bg-transparent outline-none w-full text-xs">

                </div>

                {{-- BUTTON --}}
                <button
                class="bg-white border border-gray-300 shadow rounded-xl px-4 py-3 flex items-center gap-3">

                    <div class="w-8 h-8 rounded-full border-2 border-gray-700 flex items-center justify-center">

                        <i class="ri-check-line text-lg"></i>

                    </div>

                    <span class="text-sm font-medium">
                        Tandai semua sebagai dibaca
                    </span>

                </button>

            </div>

            {{-- LIST --}}
            <div class="bg-white rounded-2xl mt-5 overflow-hidden">

                {{-- LIST CONTAINER --}}
                <div style="max-height: 380px; overflow-y: auto;">
                    {{-- ITEM --}}
                    @forelse ($notifications as $notification)

                    <div class="flex items-start justify-between px-6 py-5 border-b border-gray-200">

                        {{-- LEFT --}}
                        <div class="flex-1 min-w-0 flex items-start gap-4">

                            {{-- ICON --}}
                            <div class="w-10 h-10 rounded-full bg-pink-100 flex-shrink-0 flex items-center justify-center">
                                <i class="ri-notification-3-line text-[#F07A55] text-xl"></i>
                            </div>

                            {{-- TEXT --}}
                            <div class="flex-1 min-w-0">

                                <h3 class="font-bold text-lg">
                                    {{ $notification['title'] }}
                                </h3>

                                <p class="text-gray-700 text-sm mt-1 leading-relaxed max-w-[620px]">
                                    {{ $notification['message'] }}
                                </p>

                            </div>

                        </div>

                        {{-- RIGHT --}}
                        <div class="flex items-center gap-3 ml-5">

                            <div class="text-right text-gray-400 text-[11px] leading-tight flex flex-col items-end">

                                <p class="whitespace-nowrap">
                                    {{ $notification['time'] }}
                                </p>

                            </div>

                            @if(!$notification['is_read'])
                                <div class="w-2 h-2 rounded-full bg-[#F07A55] flex-shrink-0"></div>
                            @endif

                        </div>

                    </div>

                    @empty

                    <div class="px-6 py-12 text-center text-gray-400">
                        Belum ada notifikasi
                    </div>

                    @endforelse
                </div>

            </div>

        </div>

    </div>

</div>

@endsection