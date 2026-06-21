@extends('layouts.app')

@section('title', 'Manajemen Review')

@php
    $apiUrl = config('services.marketplace_api.url');
@endphp

@section('content')

<div
class="min-h-screen bg-[#F5F5F5] flex flex-col lg:flex-row"
x-data="{ openDetail: false, selectedReview: null, apiUrl: '{{ $apiUrl }}' }">

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
                    Manajemen Review
                </h2>

                <p class="text-gray-600 mt-1">
                    Kelola semua review produk pengguna di Vellora Marketplace
                </p>

            </div>

            {{-- CARD --}}
            <div class="flex gap-4 mt-5 overflow-x-auto scrollbar-hide pb-2">

                {{-- CARD --}}
                <div class="min-w-[140px] bg-white rounded-2xl shadow px-4 py-3 flex items-center gap-3">

                    <div class="w-12 h-12 rounded-full bg-[#D9E8B4] flex items-center justify-center">

                        <i class="ri-user-3-line text-2xl text-pink-500"></i>

                    </div>

                    <div>

                        <h3 class="font-semibold text-xs">
                            Total Review
                        </h3>

                        <h2 class="text-2xl font-bold leading-none mt-1">
                            {{ $reviews_count }}
                        </h2>

                        <p class="text-gray-500 text-[10px] mt-1">
                            Semua Seller
                        </p>

                    </div>

                </div>

                {{-- CARD --}}
                <div class="min-w-[140px] bg-white rounded-2xl shadow px-4 py-3 flex items-center gap-3">

                    <div class="w-12 h-12 rounded-full bg-[#DDE8C8] flex items-center justify-center">

                        <i class="ri-star-fill text-2xl text-yellow-500"></i>

                    </div>

                    <div>

                        <h3 class="font-semibold text-xs">
                            Review Positif
                        </h3>

                        <h2 class="text-2xl font-bold leading-none mt-1">
                            {{ $positive_reviews }}
                        </h2>

                        <p class="text-gray-500 text-[10px] mt-1">
                            Rating >= 4
                        </p>

                    </div>

                </div>

                {{-- CARD --}}
                <div class="min-w-[140px] bg-white rounded-2xl shadow px-4 py-3 flex items-center gap-3">

                    <div class="w-12 h-12 rounded-full bg-yellow-100 flex items-center justify-center">

                        <i class="ri-star-half-line text-2xl text-yellow-600"></i>

                    </div>

                    <div>

                        <h3 class="font-semibold text-xs">
                            Review Netral
                        </h3>

                        <h2 class="text-2xl font-bold leading-none mt-1">
                            {{ $neutral_reviews }}
                        </h2>

                        <p class="text-gray-500 text-[10px] mt-1">
                            Rating = 3
                        </p>

                    </div>

                </div>

                {{-- CARD --}}
                <div class="min-w-[140px] bg-white rounded-2xl shadow px-4 py-3 flex items-center gap-3">

                    <div class="w-12 h-12 rounded-full bg-red-100 flex items-center justify-center">

                        <i class="ri-star-line text-2xl text-red-500"></i>

                    </div>

                    <div>

                        <h3 class="font-semibold text-xs">
                            Review Negatif
                        </h3>

                        <h2 class="text-2xl font-bold leading-none mt-1">
                            {{ $negative_reviews }}
                        </h2>

                        <p class="text-gray-500 text-[10px] mt-1">
                            Rating <= 2
                        </p>

                    </div>

                </div>

            </div>

            {{-- SEARCH --}}
            <div class="mt-5">

                <div class="bg-pink-100 rounded-full px-4 py-2 flex items-center gap-3 w-[240px]">

                    <i class="ri-search-line text-lg text-[#F07A55]"></i>

                    <input
                        type="text"
                        placeholder="Cari review"
                        class="bg-transparent outline-none w-full text-sm">

                </div>

            </div>

            {{-- TABLE --}}
            <div class="bg-white rounded-2xl mt-4 shadow-sm overflow-x-auto">

                <div class="min-w-[800px]">

                {{-- HEAD --}}
                <div class="grid grid-cols-[1.5fr_1.2fr_1fr_1fr_70px] bg-pink-100 px-5 py-3 text-sm font-medium">

                    <h3>Review</h3>
                    <h3>Produk</h3>
                    <h3>Rating</h3>
                    <h3>Tanggal</h3>
                    <h3 class="text-center">Aksi</h3>

                </div>

                {{-- ROWS CONTAINER --}}
                <div style="max-height: 290px; overflow-y: auto;">
                    {{-- ROWS --}}
                    @forelse ($reviews as $r)
                    <div class="grid grid-cols-[1.5fr_1.2fr_1fr_1fr_70px] items-center px-5 py-3 border-b border-gray-100 hover:bg-gray-50 transition">

                        {{-- REVIEW --}}
                        <div class="flex gap-3">

                            <img
                                src="{{ $r['user']['profile_photo_path'] ? $apiUrl . '/' . $r['user']['profile_photo_path'] : 'https://cdn-icons-png.flaticon.com/512/149/149071.png' }}"
                                class="w-8 h-8 rounded-full object-cover mt-1">

                            <div>

                                <h3 class="font-semibold text-sm">
                                    {{ $r['user']['name'] ?? 'Pengguna' }}
                                </h3>

                                <p class="text-sm text-gray-700 leading-snug mt-1 truncate max-w-[200px]">
                                    {{ $r['review'] ?? '-' }}
                                </p>

                            </div>

                        </div>

                        {{-- PRODUK --}}
                        <div class="flex items-center gap-3">

                            <img
                                src="{{ isset($r['product']['images'][0]) ? $apiUrl . '/' . $r['product']['images'][0]['image'] : 'https://picsum.photos/50' }}"
                                class="w-12 h-12 rounded object-cover">

                            <div>

                                <h3 class="text-sm font-medium">
                                    {{ $r['product']['product_name'] ?? '-' }}
                                </h3>

                            </div>

                        </div>

                        {{-- RATING --}}
                        <div class="flex items-center gap-1 text-yellow-400">
                            @for ($i = 1; $i <= 5; $i++)
                                <i class="{{ $i <= $r['rating'] ? 'ri-star-fill' : 'ri-star-line' }}"></i>
                            @endfor
                        </div>

                        {{-- TANGGAL --}}
                        <p class="text-sm">
                            {{ \Carbon\Carbon::parse($r['created_at'])->translatedFormat('d M Y') }}
                        </p>

                        {{-- AKSI --}}
                        <div class="flex justify-center">

                            <button
                            @click="selectedReview = {{ json_encode($r) }}; openDetail = true">

                                <i class="ri-eye-line text-lg text-gray-500 hover:text-pink-500 transition"></i>

                            </button>

                        </div>

                    </div>
                    @empty
                    <div class="px-5 py-10 text-center text-gray-400">
                        Belum ada review produk
                    </div>
                    @endforelse
                </div>

                </div>

            </div>

        </div>

    </div>

    {{-- MODAL DETAIL REVIEW --}}
    <div
    x-show="openDetail"
    x-transition
    class="fixed inset-0 bg-black/20 flex items-center justify-center z-50">

        <div
        @click.outside="openDetail = false"
        class="bg-white w-full max-w-[640px] mx-4 rounded-[20px] overflow-hidden shadow-xl"
        x-show="openDetail">

            {{-- HEADER --}}
            <div class="flex items-center justify-between px-5 py-3 border-b border-gray-300">

                <h2 class="text-lg font-bold">
                    Detail Review
                </h2>

                <button
                @click="openDetail = false">

                    <i class="ri-close-line text-xl"></i>

                </button>

            </div>

            {{-- CONTENT --}}
            <div class="grid grid-cols-1 md:grid-cols-2" x-if="selectedReview">

                {{-- LEFT --}}
                <div class="border-b md:border-b-0 md:border-r border-gray-300">

                    {{-- USER --}}
                    <div class="p-4 border-b border-gray-300">

                        <div class="flex gap-3">

                            <img
                                :src="selectedReview && selectedReview.user.profile_photo_path ? apiUrl + '/' + selectedReview.user.profile_photo_path : 'https://cdn-icons-png.flaticon.com/512/149/149071.png'"
                                class="w-14 h-14 rounded-full object-cover">

                            <div>

                                <h3 class="text-lg font-bold" x-text="selectedReview ? selectedReview.user.name : ''"></h3>

                                <p class="text-sm mt-1 text-gray-500" x-text="selectedReview ? selectedReview.user.email : ''"></p>

                                <p class="text-sm mt-1 text-gray-500" x-text="selectedReview ? (selectedReview.user.phone_number || '-') : '-'"></p>

                            </div>

                        </div>

                    </div>

                    {{-- TANGGAL --}}
                    <div class="p-4">

                        <h3 class="text-base font-bold">
                            Tanggal Review
                        </h3>

                        <p class="text-sm mt-2 text-gray-600" x-text="selectedReview ? new Date(selectedReview.created_at).toLocaleDateString('id-ID', {day: 'numeric', month: 'long', year: 'numeric', hour: '2-digit', minute: '2-digit'}) + ' WIB' : ''"></p>

                    </div>

                </div>

                {{-- RIGHT --}}
                <div>

                    {{-- PRODUK --}}
                    <div class="p-4 border-b border-gray-300">

                        <h3 class="text-lg font-bold">
                            Informasi Produk
                        </h3>

                        <div class="flex items-start gap-3 mt-3">

                            <img
                                :src="selectedReview && selectedReview.product.images && selectedReview.product.images[0] ? apiUrl + '/' + selectedReview.product.images[0].image : 'https://picsum.photos/100'"
                                class="w-20 h-20 rounded-xl object-cover">

                            <div>

                                <h3 class="text-base font-semibold" x-text="selectedReview ? selectedReview.product.product_name : ''"></h3>

                                <p class="text-sm text-pink-500 mt-1 font-bold" x-text="selectedReview ? 'Rp' + Number(selectedReview.product.price).toLocaleString('id-ID') : ''"></p>

                            </div>

                        </div>

                    </div>

                    {{-- RATING --}}
                    <div class="px-4 py-3 border-b border-gray-300">

                        <h3 class="text-lg font-bold">
                            Rating
                        </h3>

                        <div class="flex items-center gap-2 mt-2">

                            <div class="flex items-center gap-1 text-yellow-400 text-lg">
                                <template x-for="i in 5">
                                    <i :class="i <= (selectedReview ? selectedReview.rating : 0) ? 'ri-star-fill' : 'ri-star-line'"></i>
                                </template>
                            </div>

                            <p class="text-sm font-semibold" x-text="selectedReview ? selectedReview.rating + '/5' : ''"></p>

                        </div>

                    </div>

                    {{-- REVIEW --}}
                    <div class="px-4 py-3">

                        <h3 class="text-lg font-bold">
                            Review
                        </h3>

                        <p class="text-sm leading-relaxed mt-2 text-gray-700" x-text="selectedReview ? (selectedReview.review || '-') : '-'"></p>

                    </div>

                </div>

            </div>

        </div>

    </div>

</div>

@endsection