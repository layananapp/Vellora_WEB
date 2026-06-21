@extends('layouts.app')

@section('title', 'Manajemen Laporan Keluhan')

@section('content')

<div
class="min-h-screen bg-[#F5F5F5] flex flex-col lg:flex-row"
x-data="{ openMenu: null, openDetail: false, selectedReport: null, apiUrl: '{{ config('services.marketplace_api.url') }}' }">

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
                <h2 class="text-3xl font-bold text-gray-800">
                    Laporan Keluhan Pengguna
                </h2>
                <p class="text-gray-600 mt-1">
                    Kelola dan periksa seluruh keluhan serta kendala yang dilaporkan oleh pengguna.
                </p>
            </div>

            {{-- STATS CARDS --}}
            <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mt-6">
                {{-- Total --}}
                <div class="bg-white rounded-2xl shadow-sm p-4 flex items-center gap-4">
                    <div class="w-12 h-12 bg-pink-100 rounded-full flex items-center justify-center flex-shrink-0">
                        <i class="ri-file-warning-line text-2xl text-pink-500"></i>
                    </div>
                    <div>
                        <p class="text-gray-500 text-xs font-semibold">Total Laporan</p>
                        <h3 class="text-2xl font-bold mt-0.5">{{ count($reports) }}</h3>
                    </div>
                </div>

                {{-- Pending --}}
                <div class="bg-white rounded-2xl shadow-sm p-4 flex items-center gap-4">
                    <div class="w-12 h-12 bg-yellow-100 rounded-full flex items-center justify-center flex-shrink-0">
                        <i class="ri-time-line text-2xl text-yellow-500"></i>
                    </div>
                    <div>
                        <p class="text-gray-500 text-xs font-semibold">Menunggu (Pending)</p>
                        <h3 class="text-2xl font-bold mt-0.5">{{ collect($reports)->where('status', 'pending')->count() }}</h3>
                    </div>
                </div>

                {{-- Resolved --}}
                <div class="bg-white rounded-2xl shadow-sm p-4 flex items-center gap-4">
                    <div class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center flex-shrink-0">
                        <i class="ri-checkbox-circle-line text-2xl text-green-500"></i>
                    </div>
                    <div>
                        <p class="text-gray-500 text-xs font-semibold">Selesai (Resolved)</p>
                        <h3 class="text-2xl font-bold mt-0.5">{{ collect($reports)->where('status', 'resolved')->count() }}</h3>
                    </div>
                </div>

                {{-- Rejected --}}
                <div class="bg-white rounded-2xl shadow-sm p-4 flex items-center gap-4">
                    <div class="w-12 h-12 bg-red-100 rounded-full flex items-center justify-center flex-shrink-0">
                        <i class="ri-close-circle-line text-2xl text-red-500"></i>
                    </div>
                    <div>
                        <p class="text-gray-500 text-xs font-semibold">Ditolak (Rejected)</p>
                        <h3 class="text-2xl font-bold mt-0.5">{{ collect($reports)->where('status', 'rejected')->count() }}</h3>
                    </div>
                </div>
            </div>

            {{-- FILTER --}}
            <div class="flex items-center gap-3 mt-6">
                {{-- Filter Status --}}
                <div class="relative">
                    <button
                    @click="openMenu === 'filter' ? openMenu = null : openMenu = 'filter'"
                    class="bg-pink-100 text-gray-800 rounded-full px-5 py-2.5 flex items-center justify-between gap-6 text-sm font-semibold hover:bg-pink-200 transition">
                        <span>
                            @if(request('status') == 'pending')
                                Status: Pending
                            @elseif(request('status') == 'resolved')
                                Status: Resolved
                            @elseif(request('status') == 'rejected')
                                Status: Rejected
                            @else
                                Semua Status
                            @endif
                        </span>
                        <i class="ri-arrow-down-s-line text-lg"></i>
                    </button>

                    {{-- Dropdown --}}
                    <div
                    x-show="openMenu === 'filter'"
                    @click.outside="openMenu = null"
                    x-transition
                    class="absolute top-12 left-0 bg-white rounded-2xl shadow-lg w-[180px] p-3 z-50">
                        <div class="flex flex-col gap-2">
                            <a href="/admin/laporan" class="text-left px-3 py-2 rounded-xl hover:bg-pink-50 text-sm">Semua</a>
                            <a href="/admin/laporan?status=pending" class="text-left px-3 py-2 rounded-xl hover:bg-pink-50 text-sm">Pending</a>
                            <a href="/admin/laporan?status=resolved" class="text-left px-3 py-2 rounded-xl hover:bg-pink-50 text-sm">Resolved</a>
                            <a href="/admin/laporan?status=rejected" class="text-left px-3 py-2 rounded-xl hover:bg-pink-50 text-sm">Rejected</a>
                        </div>
                    </div>
                </div>
            </div>

            {{-- TABLE --}}
            <div class="bg-white rounded-2xl mt-5 shadow-sm overflow-x-auto">

                <div class="min-w-[800px]">
                {{-- HEAD --}}
                <div class="grid grid-cols-[1.5fr_1.5fr_2fr_1fr_1.2fr_80px] bg-pink-100 px-5 py-4 text-sm font-bold text-gray-700">
                    <h3>Pengaju</h3>
                    <h3>Jenis Laporan</h3>
                    <h3>Judul Laporan</h3>
                    <h3>Status</h3>
                    <h3>Tanggal</h3>
                    <h3 class="text-center">Aksi</h3>
                </div>

                    {{-- ROWS CONTAINER --}}
                    <div style="max-height: 290px; overflow-y: auto;">
                        {{-- ROWS --}}
                        @forelse ($reports as $report)
                            @php
                                $isActiveFilter = !request('status') || request('status') === $report['status'];
                            @endphp
                            @if($isActiveFilter)
                            <div class="grid grid-cols-[1.5fr_1.5fr_2fr_1fr_1.2fr_80px] items-center px-5 py-4 border-b border-gray-100 hover:bg-gray-50 transition text-sm">
                                {{-- USER --}}
                                <div class="flex items-center gap-3">
                                    <img src="https://ui-avatars.com/api/?name={{ urlencode($report['user']['name'] ?? 'U') }}&background=E5E7EB&color=4B5563"
                                         class="w-8 h-8 rounded-full object-cover">
                                    <div class="min-w-0">
                                        <h4 class="font-semibold text-gray-800 truncate">{{ $report['user']['name'] ?? 'User' }}</h4>
                                        <p class="text-xs text-gray-400 truncate">{{ $report['user']['email'] ?? '-' }}</p>
                                    </div>
                                </div>

                                {{-- TYPE --}}
                                <span class="text-gray-700 font-medium">{{ $report['jenis_laporan'] }}</span>

                                {{-- TITLE --}}
                                <span class="text-gray-700 truncate pr-4">{{ $report['judul'] }}</span>

                                {{-- STATUS --}}
                                <div>
                                    <span class="px-3 py-1 rounded-full text-xs font-semibold
                                        @if($report['status'] === 'pending') bg-yellow-100 text-yellow-600
                                        @elseif($report['status'] === 'resolved') bg-green-100 text-green-600
                                        @else bg-red-100 text-red-600
                                        @endif">
                                        {{ ucfirst($report['status']) }}
                                    </span>
                                </div>

                                {{-- DATE --}}
                                <span class="text-gray-500">
                                    {{ \Carbon\Carbon::parse($report['created_at'])->translatedFormat('d M Y, H:i') }}
                                </span>

                                {{-- ACTION --}}
                                <div class="flex justify-center relative">
                                    <button
                                    @click="selectedReport = {{ json_encode($report) }}; openDetail = true"
                                    class="bg-[#FF8FA3] hover:bg-pink-400 text-white font-bold px-3 py-1.5 rounded-full text-xs transition">
                                        Periksa
                                    </button>
                                </div>
                            </div>
                            @endif
                        @empty
                            <div class="p-8 text-center text-gray-400">
                                Belum ada laporan keluhan yang diterima.
                            </div>
                        @endforelse
                    </div>
                </div>

            </div>

        </div>
    </div>

    {{-- MODAL DETAIL LAPORAN --}}
    <div
    x-show="openDetail"
    x-transition
    class="fixed inset-0 bg-black/40 flex items-center justify-center z-50 p-4"
    x-cloak>
        <div
        @click.outside="openDetail = false"
        class="bg-white rounded-3xl w-full max-w-[600px] mx-4 max-h-[85vh] overflow-y-auto shadow-2xl">
            {{-- Header --}}
            <div class="flex items-center justify-between px-6 py-4 border-b border-gray-200">
                <h2 class="text-2xl font-bold text-gray-800">Detail Laporan</h2>
                <button @click="openDetail = false">
                    <i class="ri-close-line text-3xl text-gray-500 hover:text-red-500 transition"></i>
                </button>
            </div>

            {{-- Content --}}
            <div class="p-6 space-y-6" x-if="selectedReport">
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <p class="text-xs text-gray-400 uppercase font-bold">Pelapor</p>
                        <h4 class="text-base font-semibold text-gray-800 mt-1" x-text="selectedReport.user?.name || 'User'"></h4>
                        <p class="text-sm text-gray-500" x-text="selectedReport.user?.email || ''"></p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-400 uppercase font-bold">Jenis Laporan</p>
                        <h4 class="text-base font-semibold text-gray-800 mt-1" x-text="selectedReport.jenis_laporan"></h4>
                    </div>
                </div>

                <div>
                    <p class="text-xs text-gray-400 uppercase font-bold">Judul Laporan</p>
                    <h4 class="text-lg font-bold text-gray-800 mt-1" x-text="selectedReport.judul"></h4>
                </div>

                <div>
                    <p class="text-xs text-gray-400 uppercase font-bold">Deskripsi Kejadian</p>
                    <p class="text-sm text-gray-600 bg-gray-50 p-4 rounded-2xl border border-gray-100 mt-1 whitespace-pre-line leading-relaxed" x-text="selectedReport.deskripsi"></p>
                </div>

                {{-- FOTO BUKTI --}}
                <div x-show="selectedReport.foto_bukti && selectedReport.foto_bukti.length > 0">
                    <p class="text-xs text-gray-400 uppercase font-bold mb-2">Foto / Bukti Lampiran</p>
                    <div class="flex gap-3 flex-wrap">
                        <template x-for="(foto, index) in selectedReport.foto_bukti" :key="index">
                            <a :href="apiUrl + '/storage/' + foto" target="_blank">
                                <img :src="apiUrl + '/storage/' + foto" class="w-24 h-24 rounded-xl object-cover border border-gray-200 hover:scale-105 transition duration-200">
                            </a>
                        </template>
                    </div>
                </div>

                {{-- ACTION FORM --}}
                <div class="bg-pink-50 p-4 rounded-2xl border border-pink-100 flex flex-col gap-3">
                    <p class="text-xs text-gray-500 font-bold">Ubah Status Laporan Keluhan:</p>
                    
                    <form :action="'/admin/reports/' + selectedReport.id + '/status'" method="POST" class="flex gap-3">
                        @csrf
                        @method('PUT')
                        
                        <input type="hidden" name="status" id="report_status_val" x-ref="statusInput">

                        <button
                        type="submit"
                        @click="$refs.statusInput.value = 'resolved'"
                        class="flex-1 bg-green-500 hover:bg-green-600 text-white font-bold py-2 rounded-full text-sm transition">
                            Tandai Resolved (Selesai)
                        </button>

                        <button
                        type="submit"
                        @click="$refs.statusInput.value = 'rejected'"
                        class="flex-1 bg-red-500 hover:bg-red-600 text-white font-bold py-2 rounded-full text-sm transition">
                            Tolak Laporan (Rejected)
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection