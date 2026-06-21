@extends('layouts.app')

@section('title', 'Pengaturan Admin')

@section('content')

<div
class="min-h-screen bg-[#F5F5F5] flex flex-col lg:flex-row"
x-data="{ tab: 'total' }">

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
                    Pengaturan
                </h2>
                <p class="text-gray-600 mt-1 text-sm">
                    Kelola konfigurasi sistem, kategori produk, voucher, dan preferensi admin
                </p>
            </div>

            {{-- TABS --}}
            <div class="bg-[#FFF1F1] rounded-2xl mt-5 px-6 py-4 flex items-center justify-start gap-12 shadow-sm overflow-x-auto whitespace-nowrap scrollbar-none">
                {{-- Total --}}
                <button
                @click="tab='total'"
                class="flex flex-col items-center font-bold text-lg transition"
                :class="tab === 'total' ? 'text-pink-500' : 'text-gray-400 hover:text-pink-400'">
                    Dashboard Totals
                    <span x-show="tab === 'total'" class="w-2 h-2 bg-pink-500 rounded-full mt-1.5"></span>
                </button>

                {{-- Kategori --}}
                <button
                @click="tab='categories'"
                class="flex flex-col items-center font-bold text-lg transition"
                :class="tab === 'categories' ? 'text-pink-500' : 'text-gray-400 hover:text-pink-400'">
                    Kategori Produk
                    <span x-show="tab === 'categories'" class="w-2 h-2 bg-pink-500 rounded-full mt-1.5"></span>
                </button>

                {{-- Voucher --}}
                <button
                @click="tab='vouchers'"
                class="flex flex-col items-center font-bold text-lg transition"
                :class="tab === 'vouchers' ? 'text-pink-500' : 'text-gray-400 hover:text-pink-400'">
                    Voucher Diskon
                    <span x-show="tab === 'vouchers'" class="w-2 h-2 bg-pink-500 rounded-full mt-1.5"></span>
                </button>

                {{-- Profile --}}
                <button
                @click="tab='profile'"
                class="flex flex-col items-center font-bold text-lg transition"
                :class="tab === 'profile' ? 'text-pink-500' : 'text-gray-400 hover:text-pink-400'">
                    Profile Admin
                    <span x-show="tab === 'profile'" class="w-2 h-2 bg-pink-500 rounded-full mt-1.5"></span>
                </button>
            </div>

            {{-- TOTAL TAB --}}
            <div x-show="tab === 'total'" class="bg-white rounded-2xl mt-5 p-6 shadow-sm">
                <h3 class="text-2xl font-bold text-gray-800">Ringkasan Total Data</h3>
                <p class="text-gray-500 text-sm mt-1">Status dan jumlah data saat ini di sistem.</p>

                <div class="mt-6 overflow-x-auto rounded-2xl border border-gray-200">

                    <div class="min-w-[600px]">
                    <div class="grid grid-cols-3 bg-pink-100 px-5 py-4 font-bold text-sm text-gray-700">
                        <h3>Tipe Data</h3>
                        <h3>Jumlah Total</h3>
                        <h3>Keterangan</h3>
                    </div>

                    <div class="grid grid-cols-3 px-5 py-4 border-t border-gray-100 items-center text-sm">
                        <span class="font-bold text-gray-800">User / Buyer</span>
                        <span class="text-lg font-bold text-gray-750">{{ number_format($buyers_count, 0, ',', '.') }}</span>
                        <span class="text-gray-500">Total seluruh pengguna terdaftar</span>
                    </div>

                    <div class="grid grid-cols-3 px-5 py-4 border-t border-gray-100 items-center text-sm">
                        <span class="font-bold text-gray-800">Seller / Toko</span>
                        <span class="text-lg font-bold text-gray-750">{{ number_format($sellers_count, 0, ',', '.') }}</span>
                        <span class="text-gray-500">Total seluruh toko yang aktif</span>
                    </div>
                    </div>

                </div>
            </div>

            {{-- CATEGORIES TAB --}}
            <div x-show="tab === 'categories'" class="grid grid-cols-1 lg:grid-cols-[1.5fr_1fr] gap-6 mt-5">
                {{-- List --}}
                <div class="bg-white rounded-2xl p-6 shadow-sm">
                    <h3 class="text-2xl font-bold text-gray-800">Daftar Kategori</h3>
                    
                    <div class="mt-4 overflow-hidden rounded-2xl border border-gray-200">
                        <div class="grid grid-cols-[1fr_2fr] bg-pink-100 px-5 py-3 font-bold text-sm text-gray-700">
                            <h3>ID Kategori</h3>
                            <h3>Nama Kategori</h3>
                        </div>
                        @forelse ($categories as $cat)
                            <div class="grid grid-cols-[1fr_2fr] px-5 py-3 border-t border-gray-100 text-sm text-gray-600">
                                <span>#{{ $cat['id'] }}</span>
                                <span class="font-semibold text-gray-800">{{ $cat['category_name'] }}</span>
                            </div>
                        @empty
                            <div class="p-5 text-center text-gray-400 text-sm">Belum ada kategori produk.</div>
                        @endforelse
                    </div>
                </div>

                {{-- Form Add --}}
                <div class="bg-white rounded-2xl p-6 shadow-sm h-fit">
                    <h3 class="text-xl font-bold text-gray-800 mb-4">Tambah Kategori Baru</h3>
                    
                    <form action="{{ route('admin.store-category') }}" method="POST" class="space-y-4">
                        @csrf
                        <div>
                            <label class="block text-sm font-semibold mb-2">Nama Kategori</label>
                            <input
                            type="text"
                            name="category_name"
                            required
                            placeholder="Contoh: Fashion, Gadget"
                            class="w-full border-2 border-gray-400 rounded-full px-5 py-2.5 outline-none text-sm">
                        </div>
                        <button type="submit" class="w-full bg-[#FF8FA3] hover:bg-pink-400 text-white font-bold py-2.5 rounded-full text-sm transition">
                            Simpan Kategori
                        </button>
                    </form>
                </div>
            </div>

            {{-- VOUCHERS TAB --}}
            <div x-show="tab === 'vouchers'" class="grid grid-cols-1 lg:grid-cols-[1.5fr_1fr] gap-6 mt-5">
                {{-- List --}}
                <div class="bg-white rounded-2xl p-6 shadow-sm">
                    <h3 class="text-2xl font-bold text-gray-800">Daftar Voucher Diskon</h3>
                    
                    <div class="mt-4 overflow-x-auto rounded-2xl border border-gray-200">
                        <table class="w-full text-left text-sm text-gray-600 border-collapse min-w-[650px]">
                            <thead>
                                <tr class="bg-pink-100 font-bold text-gray-700">
                                    <th class="px-5 py-3.5">Nama Voucher</th>
                                    <th class="px-5 py-3.5">Kode</th>
                                    <th class="px-5 py-3.5">Potongan</th>
                                    <th class="px-5 py-3.5">Kuota (Terpakai)</th>
                                    <th class="px-5 py-3.5">Min. Belanja</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($vouchers as $v)
                                    <tr class="border-t border-gray-100 hover:bg-gray-50 transition">
                                        <td class="px-5 py-3.5 font-semibold text-gray-800">{{ $v['voucher_name'] }}</td>
                                        <td class="px-5 py-3.5 font-bold text-pink-500">{{ $v['code'] }}</td>
                                        <td class="px-5 py-3.5">
                                            @if($v['discount_type'] === 'percentage')
                                                {{ (float)$v['discount_value'] }}%
                                            @else
                                                Rp{{ number_format($v['discount_value'], 0, ',', '.') }}
                                            @endif
                                        </td>
                                        <td class="px-5 py-3.5">{{ $v['used'] ?? 0 }} / {{ $v['quota'] }}</td>
                                        <td class="px-5 py-3.5">Rp{{ number_format($v['minimum_transaction'] ?? 0, 0, ',', '.') }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="p-5 text-center text-gray-400">Belum ada voucher dibuat.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                {{-- Form Add --}}
                <div class="bg-white rounded-2xl p-6 shadow-sm h-fit">
                    <h3 class="text-xl font-bold text-gray-800 mb-4">Buat Voucher Baru</h3>
                    
                    <form action="{{ route('admin.store-voucher') }}" method="POST" class="space-y-4">
                        @csrf
                        <div>
                            <label class="block text-sm font-semibold mb-2">Nama Voucher</label>
                            <input
                            type="text"
                            name="voucher_name"
                            required
                            placeholder="Contoh: Diskon Gajian"
                            class="w-full border-2 border-gray-400 rounded-full px-5 py-2.5 outline-none text-sm">
                        </div>

                        <div>
                            <label class="block text-sm font-semibold mb-2">Kode Voucher</label>
                            <input
                            type="text"
                            name="code"
                            required
                            placeholder="Contoh: MERDEKA50"
                            class="w-full border-2 border-gray-400 rounded-full px-5 py-2.5 outline-none text-sm uppercase">
                        </div>

                        <div>
                            <label class="block text-sm font-semibold mb-2">Tipe Diskon</label>
                            <select
                            name="discount_type"
                            required
                            class="w-full border-2 border-gray-400 rounded-full px-5 py-2.5 outline-none text-sm bg-white">
                                <option value="fixed">Nominal Tetap (Rupiah)</option>
                                <option value="percentage">Persentase (%)</option>
                            </select>
                        </div>

                        <div>
                            <label class="block text-sm font-semibold mb-2">Nominal / Persentase Diskon</label>
                            <input
                            type="number"
                            name="discount_value"
                            required
                            placeholder="Contoh: 50000 atau 10"
                            class="w-full border-2 border-gray-400 rounded-full px-5 py-2.5 outline-none text-sm">
                        </div>

                        <div>
                            <label class="block text-sm font-semibold mb-2">Minimal Transaksi (Rupiah, Opsional)</label>
                            <input
                            type="number"
                            name="minimum_transaction"
                            placeholder="Contoh: 100000"
                            class="w-full border-2 border-gray-400 rounded-full px-5 py-2.5 outline-none text-sm">
                        </div>

                        <div>
                            <label class="block text-sm font-semibold mb-2">Kuota Penggunaan</label>
                            <input
                            type="number"
                            name="quota"
                            required
                            placeholder="Contoh: 100"
                            class="w-full border-2 border-gray-400 rounded-full px-5 py-2.5 outline-none text-sm">
                        </div>

                        <div>
                            <label class="block text-sm font-semibold mb-2">Tanggal Kedaluwarsa (Opsional)</label>
                            <input
                            type="date"
                            name="expired_at"
                            class="w-full border-2 border-gray-400 rounded-full px-5 py-2.5 outline-none text-sm">
                        </div>

                        <button type="submit" class="w-full bg-[#FF8FA3] hover:bg-pink-400 text-white font-bold py-2.5 rounded-full text-sm transition">
                            Buat Voucher
                        </button>
                    </form>
                </div>
            </div>

            {{-- PROFILE TAB --}}
            <div x-show="tab === 'profile'" class="bg-white rounded-2xl mt-5 p-8 min-h-[300px] shadow-sm">
                <h3 class="text-2xl font-bold text-gray-800">Informasi Profil Admin</h3>
                <p class="text-gray-500 text-sm mt-1">Informasi akun administrator utama Anda.</p>

                <div class="flex flex-col sm:flex-row items-start gap-10 mt-8">
                    <div class="relative flex-shrink-0">
                        <img src="https://ui-avatars.com/api/?name={{ urlencode(session('user.name', 'Admin')) }}&background=FF8FA3&color=fff&size=120"
                             class="w-28 h-28 rounded-full object-cover">
                    </div>

                    <div class="space-y-4 w-full max-w-[360px] text-sm">
                        <div>
                            <label class="font-bold text-gray-400 block mb-1">Nama Lengkap</label>
                            <input
                                type="text"
                                readonly
                                value="{{ session('user.name', 'Admin') }}"
                                class="w-full border-2 border-gray-200 rounded-full px-5 py-2.5 outline-none bg-gray-50 text-gray-800 cursor-not-allowed">
                        </div>

                        <div>
                            <label class="font-bold text-gray-400 block mb-1">Email</label>
                            <input
                                type="email"
                                readonly
                                value="{{ session('user.email', 'admin@vellora.com') }}"
                                class="w-full border-2 border-gray-200 rounded-full px-5 py-2.5 outline-none bg-gray-50 text-gray-800 cursor-not-allowed">
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

@endsection