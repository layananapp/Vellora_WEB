@extends('layouts.app')

@section('title', 'Tambah Produk')

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
            <div class="flex flex-col md:flex-row items-start md:items-center justify-between gap-4">

                <div>

                    <div class="flex flex-wrap items-center gap-2 md:gap-3">

                        <a href="/seller/produk">

                            <i class="ri-arrow-left-line text-3xl md:text-4xl text-black"></i>

                        </a>

                        <h2 class="text-2xl md:text-3xl font-bold">
                            Produk
                        </h2>

                        <i class="ri-arrow-right-s-line text-2xl"></i>

                        <h2 class="text-2xl md:text-3xl font-bold">
                            Tambah Produk
                        </h2>

                    </div>

                    <p class="text-gray-500 mt-1 text-sm md:ml-12">
                        Tambah produk baru ke tokomu
                    </p>

                </div>

            </div>
            
            @if (session('error'))
                <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 rounded-xl mt-4 shadow-sm" role="alert">
                    <p class="font-bold">Error</p>
                    <p>{{ session('error') }}</p>
                </div>
            @endif

            @if (session('success'))
                <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded-xl mt-4 shadow-sm" role="alert">
                    <p class="font-bold">Sukses</p>
                    <p>{{ session('success') }}</p>
                </div>
            @endif

            {{-- CONTENT --}}
            <form
            action="{{ route('seller.store-produk') }}"
            method="POST"
            enctype="multipart/form-data"
            class="bg-white rounded-3xl mt-5 p-6 shadow-sm">

                @csrf

                <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

                    {{-- LEFT --}}
                    <div
                    x-data="{
                        preview: null
                    }">

                        <h3 class="font-bold text-xl mb-3">
                            Foto Produk
                        </h3>

                        {{-- Upload --}}
                        <label
                        class="w-48 h-48 border-[3px] border-gray-700 rounded-3xl flex flex-col items-center justify-center cursor-pointer overflow-hidden">

                            {{-- Default --}}
                            <template x-if="!preview">

                                <div class="flex flex-col items-center justify-center">

                                    <i class="ri-camera-line text-5xl"></i>

                                    <p class="mt-2 text-lg">
                                        Upload Foto
                                    </p>

                                </div>

                            </template>

                            {{-- Preview --}}
                            <template x-if="preview">

                                <img
                                :src="preview"
                                class="w-full h-full object-cover">

                            </template>

                            <input
                            type="file"
                            name="image"
                            required
                            accept="image/*"
                            class="hidden"
                            @change="
                                preview = URL.createObjectURL($event.target.files[0])
                            ">

                        </label>

                        {{-- Preview kecil --}}
                        <div class="flex items-center gap-5 mt-5">

                            <template x-if="preview">

                                <img
                                :src="preview"
                                class="w-14 h-14 rounded-lg object-cover border border-gray-500">

                            </template>

                        </div>

                    </div>

                    {{-- CENTER --}}
                    <div class="space-y-4">

                        {{-- Nama --}}
                        <div>

                            <label class="block font-bold mb-1">
                                Nama Produk
                            </label>

                            <input
                            type="text"
                            name="product_name"
                            placeholder="Masukkan Nama Produk"
                            required
                            value="{{ old('product_name') }}"
                            class="w-full border-2 border-gray-500 rounded-full px-5 py-2 outline-none">

                        </div>

                        {{-- Kategori --}}
                        <div>

                            <label class="block font-bold mb-1">
                                Kategori
                            </label>

                            <select
                            name="category_id"
                            required
                            class="w-full border-2 border-gray-500 rounded-full px-5 py-2 outline-none">

                                <option value="">
                                    Pilih Kategori
                                </option>

                                @foreach ($categories as $category)

                                    <option
                                    value="{{ $category['id'] }}">

                                        {{ $category['category_name'] }}

                                    </option>

                                @endforeach

                            </select>

                        </div>

                        {{-- Harga --}}
                        <div>

                            <label class="block font-bold mb-1">
                                Harga
                            </label>

                            <input
                            type="number"
                            name="price"
                            required
                            placeholder="Masukkan Harga (Rp. Contoh: 200000)"
                            value="{{ old('price') }}"
                            class="w-full border-2 border-gray-500 rounded-full px-5 py-2 outline-none">

                        </div>

                        {{-- Stok --}}
                        <div>

                            <label class="block font-bold mb-1">
                                Stok
                            </label>

                            <input
                            type="number"
                            name="stock"
                            required
                            placeholder="Jumlah Stok"
                            value="{{ old('stock') }}"
                            class="w-full border-2 border-gray-500 rounded-full px-5 py-2 outline-none">

                        </div>

                        {{-- Status --}}
                        <div>

                            <label class="block font-bold mb-1">
                                Status
                            </label>

                            <select
                            name="is_active"
                            class="w-full border-2 border-gray-500 rounded-full px-5 py-2 outline-none">

                                <option value="1">
                                    Aktif
                                </option>

                                <option value="0">
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
                        rows="5"
                        name="description"
                        required
                        placeholder="Deskripsikan Produk Anda"
                        class="w-full border-[3px] border-gray-500 rounded-3xl px-5 py-4 outline-none resize-none">{{ old('description') }}</textarea>

                    </div>

                </div>

                {{-- VARIASI --}}
                <div
                x-data="{
                    variations: [
                        {
                            name: '',
                            price: '',
                            stock: '',
                            status: 'Aktif'
                        }
                    ]
                }"
                class="mt-10 w-full max-w-2xl">

                    <h3 class="text-2xl font-bold">
                        Variasi dan Harga
                    </h3>

                    {{-- Table --}}
                    <div class="mt-4 overflow-x-auto">

                        <div class="min-w-[500px]">

                        {{-- Head --}}
                        <div class="grid grid-cols-4 bg-pink-100 rounded-full px-5 py-2">

                            <h3>Variasi</h3>
                            <h3>Harga</h3>
                            <h3>Stok</h3>
                            <h3>Status</h3>

                        </div>

                        {{-- ROW --}}
                        <template
                        x-for="(variation, index) in variations"
                        :key="index">

                            <div class="grid grid-cols-4 gap-3 mt-3">

                                {{-- Variasi --}}
                                <input
                                type="text"
                                x-model="variation.name"
                                :name="'variations[' + index + '][name]'"
                                placeholder="Variasi"
                                class="bg-gray-100 rounded px-3 py-2 outline-none">

                                {{-- Harga --}}
                                <input
                                type="number"
                                x-model="variation.price"
                                :name="'variations[' + index + '][price]'"
                                placeholder="Rp."
                                class="bg-gray-100 rounded px-3 py-2 outline-none">

                                {{-- Stok --}}
                                <input
                                type="number"
                                x-model="variation.stock"
                                :name="'variations[' + index + '][stock]'"
                                placeholder="Stok"
                                class="bg-gray-100 rounded px-3 py-2 outline-none">

                                {{-- Status --}}
                                <select
                                x-model="variation.status"
                                :name="'variations[' + index + '][status]'"
                                class="bg-gray-100 rounded px-3 py-2 outline-none">

                                    <option value="Aktif">
                                        Aktif
                                    </option>

                                    <option value="Nonaktif">
                                        Nonaktif
                                    </option>

                                </select>

                            </div>

                        </template>

                        </div>

                    </div>

                    {{-- Button --}}
                    <div class="flex justify-end mt-6">

                        <button
                        type="button"
                        @click="variations.push({
                            name: '',
                            price: '',
                            stock: '',
                            status: 'Aktif'
                        })"
                        class="bg-[#FF8FA3] hover:bg-pink-400 transition px-5 py-2 rounded-full font-bold">

                            + Tambah Variasi

                        </button>

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

                        <i class="ri-add-line text-xl"></i>

                        Simpan Produk

                    </button>

                </div>

            </form>

        </div>

    </div>

</div>

@endsection