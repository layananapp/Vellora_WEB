@extends('layouts.app')

@section('title', 'Ulasan')

@php
    $apiUrl = config('services.marketplace_api.url');
@endphp

@section('content')

<div class="min-h-screen bg-[#FFF9F9] flex flex-col lg:flex-row" x-data>

    @include('dashboard.seller.partials.sidebar')

    {{-- CONTENT --}}
    <div class="flex-1 w-full p-4 md:p-6">

        {{-- Header --}}
        <div>
            <h3 class="text-xl md:text-2xl font-bold">Toko Saya</h3>
            <p class="text-gray-500 mt-1 text-sm">Kelola informasi dan produk toko anda</p>
        </div>

        {{-- Tabs --}}
        <div class="bg-white rounded-2xl mt-5 px-4 md:px-10 py-4 flex flex-wrap items-center justify-center gap-6 md:gap-24 shadow-sm">

            <a href="/seller/dashboard"
                class="text-[#C6CC8F] font-bold text-lg md:text-xl hover:text-pink-300 transition">
                Produk
            </a>

            {{-- Active --}}
            <a href="/seller/reviews"
                class="flex flex-col items-center text-[#F07A55] font-bold text-lg md:text-xl">
                Ulasan
                <span class="w-2 h-2 bg-[#F07A55] rounded-full mt-2"></span>
            </a>

            <a href="/seller/store"
                class="text-[#C6CC8F] font-bold text-lg md:text-xl hover:text-pink-300 transition">
                Tentang Toko
            </a>

        </div>

        {{-- Summary Card --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4 mt-6">

            <div class="bg-white rounded-2xl p-5 shadow-sm flex items-center gap-4">
                <div class="w-12 h-12 bg-yellow-100 rounded-full flex items-center justify-center">
                    <i class="ri-star-fill text-yellow-400 text-xl"></i>
                </div>
                <div>
                    <p class="text-gray-500 text-sm">Rating Rata-rata</p>
                    <h3 class="text-2xl font-bold">{{ $avg_rating > 0 ? $avg_rating : '-' }}</h3>
                </div>
            </div>

            <div class="bg-white rounded-2xl p-5 shadow-sm flex items-center gap-4">
                <div class="w-12 h-12 bg-pink-100 rounded-full flex items-center justify-center">
                    <i class="ri-chat-3-line text-pink-400 text-xl"></i>
                </div>
                <div>
                    <p class="text-gray-500 text-sm">Total Ulasan</p>
                    <h3 class="text-2xl font-bold">{{ count($reviews) }}</h3>
                </div>
            </div>

            <div class="bg-white rounded-2xl p-5 shadow-sm flex items-center gap-4">
                <div class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center">
                    <i class="ri-thumb-up-line text-green-500 text-xl"></i>
                </div>
                <div>
                    <p class="text-gray-500 text-sm">Ulasan Bintang 5</p>
                    <h3 class="text-2xl font-bold">
                        {{ collect($reviews)->where('rating', 5)->count() }}
                    </h3>
                </div>
            </div>

        </div>

        {{-- Review Content --}}
        <div class="mt-6 flex flex-col lg:flex-row items-start gap-6">

            {{-- LEFT — Review List --}}
            <div class="flex-1 w-full">

                <h3 class="text-xl font-bold mb-4">Ulasan Pembeli</h3>

                @forelse($reviews as $review)

                    @php
                        $rawPhoto = $review['user_photo'] ?? null;
                        $photo    = $rawPhoto
                            ? (str_starts_with($rawPhoto, 'http') ? $rawPhoto : $apiUrl . '/' . $rawPhoto)
                            : null;
                        $imgUrl  = $review['product_image'] ?? null;
                        $prodImg = $imgUrl
                            ? (str_starts_with($imgUrl, 'http') ? $imgUrl : $apiUrl . '/' . $imgUrl)
                            : null;
                    @endphp

                    <div class="bg-white border border-gray-100 rounded-2xl p-5 mb-4 shadow-sm">

                        <div class="flex items-start gap-4">

                            {{-- Avatar --}}
                            @if($photo)
                                <img src="{{ $photo }}" alt="" class="w-10 h-10 rounded-full object-cover flex-shrink-0">
                            @else
                                <div class="w-10 h-10 rounded-full bg-gray-200 flex items-center justify-center flex-shrink-0">
                                    <i class="ri-user-3-fill text-gray-400 text-xl"></i>
                                </div>
                            @endif

                            <div class="flex-1">

                                <div class="flex items-center justify-between">
                                    <span class="font-semibold text-sm">{{ $review['user_name'] ?? 'Pembeli' }}</span>
                                    <span class="text-gray-400 text-xs">{{ $review['created_at'] ?? '' }}</span>
                                </div>

                                {{-- Stars --}}
                                <div class="flex gap-0.5 mt-1">
                                    @for($s = 1; $s <= 5; $s++)
                                        <i class="text-sm {{ $s <= ($review['rating'] ?? 0) ? 'ri-star-fill text-yellow-400' : 'ri-star-line text-gray-300' }}"></i>
                                    @endfor
                                    <span class="text-xs text-gray-500 ml-1">({{ $review['rating'] ?? 0 }}/5)</span>
                                </div>

                                {{-- Produk --}}
                                @if(!empty($review['product_name']))
                                    <div class="flex items-center gap-2 mt-2">
                                        @if($prodImg)
                                            <img src="{{ $prodImg }}" alt="" class="w-8 h-8 object-cover rounded">
                                        @endif
                                        <span class="text-xs text-gray-500">
                                            <i class="ri-shopping-bag-line mr-1"></i>{{ $review['product_name'] }}
                                        </span>
                                    </div>
                                @endif

                                {{-- Teks --}}
                                @if(!empty($review['review']))
                                    <p class="mt-3 text-sm text-gray-700 leading-relaxed">
                                        {{ $review['review'] }}
                                    </p>
                                @else
                                    <p class="mt-3 text-sm text-gray-400 italic">Tidak ada komentar</p>
                                @endif

                            </div>

                        </div>

                    </div>

                @empty

                    <div class="bg-white rounded-2xl p-12 text-center border border-gray-100 shadow-sm">
                        <i class="ri-star-line text-5xl text-gray-200"></i>
                        <p class="text-gray-400 mt-3 font-medium">Belum ada ulasan</p>
                        <p class="text-gray-400 text-sm mt-1">Ulasan akan muncul setelah pembeli menyelesaikan pesanan</p>
                    </div>

                @endforelse

            </div>

            {{-- RIGHT — Rating Summary --}}
            @if(count($reviews) > 0)
                <div class="bg-white rounded-2xl p-6 shadow-sm w-full lg:w-auto lg:min-w-[220px]">

                    <p class="text-gray-500 font-medium">Rating Toko</p>

                    <div class="flex items-center gap-2 mt-2">
                        <h3 class="text-4xl font-bold">{{ $avg_rating }}</h3>
                        <div class="flex flex-col">
                            <div class="flex gap-0.5">
                                @for($s = 1; $s <= 5; $s++)
                                    <i class="text-sm {{ $s <= round($avg_rating) ? 'ri-star-fill text-yellow-400' : 'ri-star-line text-gray-300' }}"></i>
                                @endfor
                            </div>
                            <span class="text-gray-400 text-xs mt-1">({{ count($reviews) }} ulasan)</span>
                        </div>
                    </div>

                    {{-- Distribution --}}
                    <div class="mt-5 space-y-2">
                        @for($star = 5; $star >= 1; $star--)
                            @php $cnt = collect($reviews)->where('rating', $star)->count(); @endphp
                            <div class="flex items-center gap-2 text-xs">
                                <span class="w-3 text-gray-500">{{ $star }}</span>
                                <i class="ri-star-fill text-yellow-400"></i>
                                <div class="flex-1 bg-gray-100 rounded-full h-2">
                                    <div
                                        class="bg-yellow-400 h-2 rounded-full"
                                        style="{{ 'width: ' . (count($reviews) > 0 ? round($cnt / count($reviews) * 100) : 0) . '%' }}">
                                    </div>
                                </div>
                                <span class="w-4 text-gray-500">{{ $cnt }}</span>
                            </div>
                        @endfor
                    </div>

                </div>
            @endif

        </div>

    </div>

</div>

@endsection