@extends('layouts.app')

@section('title', 'Manajemen User')

@section('content')

<div
class="min-h-screen bg-[#F5F5F5] flex flex-col lg:flex-row"
x-data="{ openMenu: null, openDetail: false, selectedUser: null }">

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
                    Manajemen User
                </h2>
                <p class="text-gray-600 mt-1">
                    Kelola semua akun pengguna yang terdaftar di Vellora.
                </p>
            </div>

            {{-- CARD STATS --}}
            <div class="flex gap-4 mt-5 overflow-x-auto pb-2">
                {{-- CARD --}}
                <div class="min-w-[170px] bg-white rounded-2xl shadow-sm px-4 py-3 flex items-center gap-3">
                    <div class="w-12 h-12 rounded-full bg-pink-100 flex items-center justify-center">
                        <i class="ri-user-3-line text-2xl text-pink-500"></i>
                    </div>
                    <div>
                        <h3 class="font-semibold text-sm">Total User</h3>
                        <h2 class="text-2xl font-bold leading-none mt-1">{{ count($users) }}</h2>
                        <p class="text-gray-500 text-xs mt-1">Pembeli Terdaftar</p>
                    </div>
                </div>

                {{-- CARD --}}
                <div class="min-w-[170px] bg-white rounded-2xl shadow-sm px-4 py-3 flex items-center gap-3">
                    <div class="w-12 h-12 rounded-full bg-green-100 flex items-center justify-center">
                        <i class="ri-user-follow-line text-2xl text-green-600"></i>
                    </div>
                    <div>
                        <h3 class="font-semibold text-sm">User Aktif</h3>
                        <h2 class="text-2xl font-bold leading-none mt-1">{{ collect($users)->where('is_suspended', false)->count() }}</h2>
                        <p class="text-gray-500 text-xs mt-1">Status Aktif</p>
                    </div>
                </div>

                {{-- CARD --}}
                <div class="min-w-[170px] bg-white rounded-2xl shadow-sm px-4 py-3 flex items-center gap-3">
                    <div class="w-12 h-12 rounded-full bg-red-100 flex items-center justify-center">
                        <i class="ri-user-unfollow-line text-2xl text-red-500"></i>
                    </div>
                    <div>
                        <h3 class="font-semibold text-sm">Ditangguhkan</h3>
                        <h2 class="text-2xl font-bold leading-none mt-1">{{ collect($users)->where('is_suspended', true)->count() }}</h2>
                        <p class="text-gray-500 text-xs mt-1">User Suspended</p>
                    </div>
                </div>
            </div>

            {{-- FILTER --}}
            <div class="flex items-center gap-3 mt-5">
                {{-- Filter --}}
                <div class="relative">
                    <button
                    @click="openMenu === 'filter' ? openMenu = null : openMenu = 'filter'"
                    class="bg-pink-100 rounded-full px-4 py-2 flex items-center gap-8 text-sm font-semibold">
                        <span>
                            @if(request('status') === 'aktif')
                                Aktif
                            @elseif(request('status') === 'nonaktif')
                                Suspended
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
                    class="absolute top-11 left-0 bg-white rounded-2xl shadow-lg w-[160px] p-3 z-50">
                        <div class="space-y-2 flex flex-col items-start">
                            <a href="/admin/user" class="text-sm py-1.5 hover:text-pink-500 transition">Semua</a>
                            <a href="/admin/user?status=aktif" class="text-sm py-1.5 hover:text-pink-500 transition">Aktif</a>
                            <a href="/admin/user?status=nonaktif" class="text-sm py-1.5 hover:text-pink-500 transition">Suspended</a>
                        </div>
                    </div>
                </div>
            </div>

            {{-- TABLE --}}
            <div class="bg-white rounded-2xl mt-5 shadow-sm overflow-x-auto">

                <div class="min-w-[900px]">

                    {{-- HEAD --}}
                    <div class="grid grid-cols-7 bg-pink-100 px-5 py-3 text-sm font-bold text-gray-700">
                    <h3>User</h3>
                    <h3>Email</h3>
                    <h3>No. Tlp</h3>
                    <h3>Role</h3>
                    <h3>Status</h3>
                    <h3>Tanggal</h3>
                    <h3>Aksi</h3>
                </div>

                    {{-- ROWS CONTAINER --}}
                    <div style="max-height: 290px; overflow-y: auto;">
                        {{-- ROWS --}}
                        @forelse ($users as $u)
                            @php
                                $isActiveFilter = !request('status') || 
                                    (request('status') === 'aktif' && !$u['is_suspended']) || 
                                    (request('status') === 'nonaktif' && $u['is_suspended']);
                            @endphp
                            @if($isActiveFilter)
                            <div class="grid grid-cols-7 items-center px-5 py-4 border-b border-gray-100 relative text-sm text-gray-700 hover:bg-gray-50 transition">
                                {{-- USER --}}
                                <div class="flex items-center gap-3">
                                    <img src="https://ui-avatars.com/api/?name={{ urlencode($u['name']) }}&background=F3F4F6&color=4B5563"
                                         class="w-10 h-10 rounded-full object-cover">
                                    <span class="font-semibold text-gray-800">{{ $u['name'] }}</span>
                                </div>

                                <p class="truncate pr-2">{{ $u['email'] }}</p>
                                <p>{{ $u['phone_number'] ?? '-' }}</p>
                                <p>{{ ucfirst($u['role']) }}</p>

                                <div>
                                    <span class="px-3 py-1 rounded-full text-xs font-semibold {{ $u['is_suspended'] ? 'bg-red-100 text-red-600' : 'bg-green-100 text-green-600' }}">
                                        {{ $u['is_suspended'] ? 'Suspended' : 'Aktif' }}
                                    </span>
                                </div>

                                <p>{{ \Carbon\Carbon::parse($u['created_at'])->translatedFormat('d M Y') }}</p>

                                {{-- ACTION --}}
                                <div class="relative">
                                    <button
                                    @click="openMenu === {{ $u['id'] }} ? openMenu = null : openMenu = {{ $u['id'] }}"
                                    class="p-1">
                                        <i class="ri-more-2-fill text-xl text-gray-500 hover:text-pink-500 transition"></i>
                                    </button>

                                    {{-- POPUP --}}
                                    <div
                                    x-show="openMenu === {{ $u['id'] }}"
                                    @click.outside="openMenu = null"
                                    x-transition
                                    class="absolute right-0 top-9 bg-white rounded-2xl shadow-lg w-[180px] p-3 z-50">
                                        <button
                                        @click="selectedUser = {{ json_encode($u) }}; openDetail = true; openMenu = null"
                                        class="flex items-center gap-3 text-sm hover:text-pink-500 transition w-full text-left">
                                            <i class="ri-eye-line"></i>
                                            <span>Lihat Detail</span>
                                        </button>

                                        <form action="/admin/user/{{ $u['id'] }}/{{ $u['is_suspended'] ? 'unsuspend' : 'suspend' }}" method="POST" class="mt-3">
                                            @csrf
                                            @method('PUT')
                                            <button type="submit" class="flex items-center gap-3 text-sm {{ $u['is_suspended'] ? 'text-green-600' : 'text-orange-500' }} w-full text-left">
                                                <i class="ri-forbid-line"></i>
                                                <span>{{ $u['is_suspended'] ? 'Unsuspend' : 'Suspend User' }}</span>
                                            </button>
                                        </form>

                                        <form action="/admin/user/{{ $u['id'] }}" method="POST" class="mt-3">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="flex items-center gap-3 text-sm text-red-500 w-full text-left">
                                                <i class="ri-delete-bin-line"></i>
                                                <span>Hapus User</span>
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            @endif
                        @empty
                            <div class="p-8 text-center text-gray-400">
                                Belum ada user terdaftar.
                            </div>
                        @endforelse
                    </div>
                </div>

            </div>
        </div>
    </div>

    {{-- MODAL DETAIL --}}
    <div
    x-show="openDetail"
    x-transition
    class="fixed inset-0 bg-black/40 flex items-center justify-center z-50 p-4"
    x-cloak>
        <div
        @click.outside="openDetail = false"
        class="bg-white rounded-[28px] w-full max-w-[500px] mx-4 overflow-hidden shadow-2xl">
            {{-- Header --}}
            <div class="flex items-center justify-between px-6 py-4 border-b border-gray-200">
                <h2 class="text-2xl font-bold text-gray-800">Detail User</h2>
                <button @click="openDetail = false">
                    <i class="ri-close-line text-3xl text-gray-500 hover:text-red-500 transition"></i>
                </button>
            </div>

            {{-- Content --}}
            <div class="px-6 py-5 space-y-6" x-if="selectedUser">
                <div class="flex gap-5 items-center">
                    <img :src="'https://ui-avatars.com/api/?name=' + urlencode(selectedUser ? selectedUser.name : 'U') + '&background=FF8FA3&color=fff&size=120'"
                         class="w-20 h-20 rounded-full object-cover">
                    <div>
                        <h2 class="text-2xl font-bold text-gray-800" x-text="selectedUser ? selectedUser.name : ''"></h2>
                        <span class="px-3 py-1 rounded-full text-xs font-semibold mt-2 inline-block"
                              :class="selectedUser && selectedUser.is_suspended ? 'bg-red-100 text-red-600' : 'bg-green-100 text-green-600'"
                              x-text="selectedUser && selectedUser.is_suspended ? 'Suspended' : 'Aktif'"></span>
                    </div>
                </div>

                <div class="space-y-3 bg-gray-50 p-4 rounded-2xl border border-gray-100">
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-400 font-medium">Email</span>
                        <span class="font-semibold text-gray-800" x-text="selectedUser ? selectedUser.email : ''"></span>
                    </div>
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-400 font-medium">No. Telepon</span>
                        <span class="font-semibold text-gray-800" x-text="selectedUser ? (selectedUser.phone_number || '-') : '-'"></span>
                    </div>
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-400 font-medium">Role</span>
                        <span class="font-semibold text-gray-800" x-text="selectedUser ? selectedUser.role : ''"></span>
                    </div>
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-400 font-medium">Tanggal Bergabung</span>
                        <span class="font-semibold text-gray-800" x-text="selectedUser ? new Date(selectedUser.created_at).toLocaleDateString('id-ID', {day: 'numeric', month: 'long', year: 'numeric'}) : ''"></span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection