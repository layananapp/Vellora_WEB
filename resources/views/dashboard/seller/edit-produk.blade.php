@extends('layouts.app')

@section('title', 'Edit Produk')

@php
    $apiUrl = config('services.marketplace_api.url');
@endphp

@section('content')

<div
class="min-h-screen bg-[#FFF9F9] flex flex-col lg:flex-row"
x-data="{
    openVariantModal: false
}">

    {{-- SIDEBAR --}}
    @include('dashboard.seller.partials.sidebar')

    {{-- CONTENT --}}
    <div class="flex-1">

        {{-- TOPBAR --}}
        @include('dashboard.seller.partials.topbar')

        {{-- MAIN --}}
        <div class="p-5">

            {{-- HEADER --}}
            <div class="flex items-start justify-between">

                <div>

                    <div class="flex items-center gap-3">

                        <a href="/seller/produk">

                            <i class="ri-arrow-left-line text-4xl text-black"></i>

                        </a>

                        <h2 class="text-3xl font-bold">
                            Produk
                        </h2>

                        <i class="ri-arrow-right-s-line text-3xl"></i>

                        <h2 class="text-3xl font-bold">
                            Edit Produk
                        </h2>

                    </div>

                    <p class="text-gray-500 mt-1 ml-12">
                        Ubah informasi produk sesuai kebutuhan
                    </p>

                </div>

            </div>

            {{-- FORM UPDATE --}}
            <form
            action="{{ route('seller.update-produk', $product['id']) }}"
            method="POST"
            enctype="multipart/form-data"
            class="bg-white rounded-3xl mt-6 p-6 shadow-sm">

                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

                    {{-- LEFT --}}
                    <div>

                        <h3 class="font-bold text-xl mb-3">
                            Foto Produk
                        </h3>

                        {{-- UPLOAD --}}
                        <div
                            x-data="{
                                preview: '{{ isset($product['images'][0]) ? $apiUrl . '/' . $product['images'][0]['image'] : '' }}'
                            }">

                            <label
                            class="w-48 h-48 border-[3px] border-gray-700 rounded-3xl flex flex-col items-center justify-center cursor-pointer overflow-hidden">

                                <template x-if="preview">

                                    <img
                                        :src="preview"
                                        class="w-full h-full object-cover">

                                </template>

                                <template x-if="!preview">

                                    <div class="text-center">

                                        <i class="ri-camera-line text-5xl"></i>

                                        <p class="mt-2 text-lg">
                                            Upload Foto
                                        </p>

                                    </div>

                                </template>

                                <input
                                    type="file"
                                    name="image"
                                    accept="image/*"
                                    class="hidden"
                                    @change="
                                        const file = $event.target.files[0];
                                        if(file){
                                            preview = URL.createObjectURL(file);
                                        }
                                    ">

                            </label>

                        </div>

                        {{-- PREVIEW --}}
                        <div class="flex items-center gap-4 mt-5 flex-wrap">

                            @foreach ($product['images'] as $image)

                            <div class="relative">

                                <img
                                src="{{ $apiUrl . '/' . $image['image'] }}"
                                class="w-16 h-16 rounded-xl object-cover">

                            </div>

                            @endforeach

                        </div>

                    </div>

                    {{-- CENTER --}}
                    <div class="space-y-4">

                        {{-- NAMA --}}
                        <div>

                            <label class="block font-bold mb-1">
                                Nama Produk
                            </label>

                            <input
                            type="text"
                            name="product_name"
                            value="{{ old('product_name', $product['product_name']) }}"
                            class="w-full border-2 border-gray-500 rounded-full px-5 py-2 outline-none">

                        </div>

                        {{-- KATEGORI --}}
                        <div>

                            <label class="block font-bold mb-1">
                                Kategori
                            </label>

                            <select
                            name="category_id"
                            class="w-full border-2 border-gray-500 rounded-full px-5 py-2 outline-none">

                                @foreach ($categories as $category)

                                    <option
                                    value="{{ $category['id'] }}"
                                    {{ $product['category_id'] == $category['id'] ? 'selected' : '' }}>

                                        {{ $category['category_name'] }}

                                    </option>

                                @endforeach

                            </select>

                        </div>

                        {{-- HARGA --}}
                        <div>

                            <label class="block font-bold mb-1">
                                Harga
                            </label>

                            <input
                            type="number"
                            name="price"
                            value="{{ old('price', $product['price']) }}"
                            class="w-full border-2 border-gray-500 rounded-full px-5 py-2 outline-none">

                        </div>

                        {{-- STOK --}}
                        <div>

                            <label class="block font-bold mb-1">
                                Stok
                            </label>

                            <input
                            type="number"
                            name="stock"
                            value="{{ old('stock', $product['stock']) }}"
                            class="w-full border-2 border-gray-500 rounded-full px-5 py-2 outline-none">

                        </div>

                        {{-- STATUS --}}
                        <div>

                            <label class="block font-bold mb-1">
                                Status
                            </label>

                            <select
                            name="is_active"
                            class="w-full border-2 border-gray-500 rounded-full px-5 py-2 outline-none">

                                <option
                                value="1"
                                {{ $product['is_active'] ? 'selected' : '' }}>

                                    Aktif

                                </option>

                                <option
                                value="0"
                                {{ !$product['is_active'] ? 'selected' : '' }}>

                                    Nonaktif

                                </option>

                            </select>

                        </div>

                    </div>

                    {{-- RIGHT --}}
                    <div>

                        <h3 class="font-bold text-xl mb-3">
                            Deskripsi
                        </h3>

                        <textarea
                        rows="7"
                        name="description"
                        class="w-full border-[3px] border-gray-500 rounded-3xl px-5 py-4 outline-none resize-none">{{ old('description', $product['description']) }}</textarea>

                    </div>

                </div>

                {{-- BUTTON --}}
                <div class="flex justify-end gap-3 mt-10">

                    <a
                    href="/seller/produk"
                    class="bg-gray-200 hover:bg-gray-300 transition px-7 py-2 rounded-full font-bold">

                        Batal

                    </a>

                    <button
                    type="submit"
                    class="bg-[#FF8FA3] hover:bg-pink-400 transition px-7 py-2 rounded-full flex items-center gap-2 font-bold">

                        <i class="ri-edit-box-line text-xl"></i>

                        Simpan Perubahan

                    </button>

                </div>

            </form>

            {{-- VARIASI --}}
            <div class="bg-white rounded-3xl mt-6 p-6 shadow-sm">

                <div class="flex items-center justify-between">

                    <h3 class="text-2xl font-bold">
                        Variasi dan Harga
                    </h3>

                    <button
                    type="button"
                    @click="openVariantModal = true"
                    class="bg-[#FF8FA3] hover:bg-pink-400 transition px-5 py-2 rounded-full font-bold text-sm">

                        + Tambah Variasi

                    </button>

                </div>

                {{-- TABLE --}}
                <div class="mt-5 overflow-x-auto rounded-2xl border border-gray-200">

                    <div class="min-w-[600px]">

                    {{-- HEADER --}}
                    <div class="grid grid-cols-4 bg-pink-100 px-5 py-4 font-medium text-sm">

                        <h3>Variasi</h3>
                        <h3>Harga</h3>
                        <h3>Stok</h3>
                        <h3>Status</h3>

                    </div>

                    {{-- ROW --}}
                    @forelse ($product['variants'] as $variant)

                    <div class="grid grid-cols-4 px-5 py-4 items-center border-t border-gray-100 text-sm">

                        {{-- NAMA --}}
                        <span class="font-medium">

                            {{ $variant['variant_name'] }}

                        </span>

                        {{-- HARGA --}}
                        <span>

                            Rp{{ number_format($variant['price'], 0, ',', '.') }}

                        </span>

                        {{-- STOK --}}
                        <span>

                            {{ $variant['stock'] }}

                        </span>

                        {{-- STATUS --}}
                        <div>

                            <span class="
                            {{ $variant['stock'] > 0
                                ? 'bg-[#C6DB8B]'
                                : 'bg-red-100 text-red-500'
                            }}
                            px-3 py-1 rounded-full text-xs inline-block">

                                {{ $variant['stock'] > 0 ? 'Aktif' : 'Habis' }}

                            </span>

                        </div>

                    </div>

                    @empty

                    <div class="px-5 py-6 text-sm text-gray-400 text-center">

                        Belum ada variasi produk

                    </div>

                    @endforelse

                    </div>

                </div>

            </div>

        </div>

    </div>

    {{-- MODAL VARIANT --}}
    <div
    x-show="openVariantModal"
    x-transition
    class="fixed inset-0 bg-black/20 flex items-center justify-center z-50">

        <div
        @click.away="openVariantModal = false"
        class="bg-white rounded-3xl p-6 w-full max-w-[450px] mx-4">

            <div class="flex items-center justify-between">

                <h3 class="text-2xl font-bold">
                    Tambah Variasi
                </h3>

                <button
                type="button"
                @click="openVariantModal = false">

                    <i class="ri-close-line text-3xl"></i>

                </button>

            </div>

            {{-- FORM --}}
            <form
            action="{{ route('seller.store-variant', $product['id']) }}"
            method="POST"
            class="mt-6 space-y-4">

                @csrf

                {{-- NAMA --}}
                <div>

                    <label class="block font-bold mb-1">
                        Nama Variasi
                    </label>

                    <input
                    type="text"
                    name="variant_name"
                    required
                    class="w-full border-2 border-gray-400 rounded-full px-5 py-2 outline-none">

                </div>

                {{-- HARGA --}}
                <div>

                    <label class="block font-bold mb-1">
                        Harga
                    </label>

                    <input
                    type="number"
                    name="price"
                    required
                    class="w-full border-2 border-gray-400 rounded-full px-5 py-2 outline-none">

                </div>

                {{-- STOK --}}
                <div>

                    <label class="block font-bold mb-1">
                        Stok
                    </label>

                    <input
                    type="number"
                    name="stock"
                    required
                    class="w-full border-2 border-gray-400 rounded-full px-5 py-2 outline-none">

                </div>

                {{-- BUTTON --}}
                <div class="flex justify-end gap-3 pt-3">

                    <button
                    type="button"
                    @click="openVariantModal = false"
                    class="bg-gray-200 hover:bg-gray-300 transition px-5 py-2 rounded-full font-medium">

                        Batal

                    </button>

                    <button
                    type="submit"
                    class="bg-[#FF8FA3] hover:bg-pink-400 transition px-5 py-2 rounded-full font-medium">

                        Simpan

                    </button>

                </div>

            </form>

        </div>

    </div>

</div>

@endsection
