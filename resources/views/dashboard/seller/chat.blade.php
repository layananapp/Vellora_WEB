@extends('layouts.app')

@section('title', 'Chat')

@section('content')

<div class="h-screen bg-[#FFF9F9] flex flex-col lg:flex-row overflow-hidden" x-data>

    {{-- SIDEBAR --}}
    @include('dashboard.seller.partials.sidebar')

    {{-- CONTENT --}}
    <div class="flex-1 flex flex-col overflow-hidden">

        {{-- TOPBAR --}}
        @include('dashboard.seller.partials.topbar')

        {{-- MAIN --}}
        <div class="flex-1 p-4 md:p-5 overflow-hidden flex flex-col">

            {{-- HEADER --}}
            <div class="flex items-center gap-3 mb-4 md:mb-5 shrink-0">

                <a href="/seller/dashboard">

                    <i class="ri-arrow-left-line text-3xl"></i>

                </a>

                <h2 class="text-2xl font-bold">
                    Chat
                </h2>

            </div>

            {{-- CHAT CONTAINER --}}
            <div class="flex-1 bg-white rounded-[28px] shadow-sm overflow-hidden flex flex-col lg:grid lg:grid-cols-[320px_1fr] min-h-0">

                {{-- ================================= --}}
                {{-- LEFT --}}
                {{-- ================================= --}}
                <div class="border-r border-gray-100 flex flex-col min-h-0 {{ $selectedRoom ? 'hidden lg:flex' : 'flex' }}">

                    {{-- SEARCH --}}
                    <div class="p-4 border-b border-gray-100 shrink-0">

                        <div class="h-11 bg-[#FFF1F1] rounded-full px-4 flex items-center gap-3">

                            <i class="ri-search-line text-xl text-[#F07A55]"></i>

                            <input
                                type="text"
                                placeholder="Cari Chat"
                                class="bg-transparent outline-none w-full text-sm">

                        </div>

                    </div>

                    {{-- CHAT LIST --}}
                    <div class="flex-1 overflow-y-auto p-3 space-y-2">

                        @forelse ($rooms as $room)

                            @php

                                $buyer =
                                    $room['buyer'];

                                $lastMessage =
                                    $room['last_message']
                                    ?? null;

                                $isActive =
                                    request('room')
                                    == $room['id'];

                            @endphp

                            <a
                                href="/seller/chat?room={{ $room['id'] }}"
                                class="flex items-start gap-3 p-3 rounded-2xl transition hover:bg-pink-50

                                {{ $isActive ? 'bg-pink-50' : '' }}">

                                {{-- AVATAR --}}
                                <img
                                    src="https://ui-avatars.com/api/?name={{ urlencode($buyer['name']) }}"
                                    class="w-12 h-12 rounded-full object-cover shrink-0">

                                {{-- TEXT --}}
                                <div class="flex-1 min-w-0">

                                    <div class="flex items-center justify-between gap-2">

                                        <h3 class="font-semibold text-sm truncate">

                                            {{ $buyer['name'] }}

                                        </h3>

                                        <span class="text-[10px] text-gray-400 shrink-0">

                                            {{
                                                isset($room['last_message'])
                                                ? \Carbon\Carbon::parse(
                                                    $room['last_message']['created_at']
                                                )->timezone('Asia/Jakarta')->format('d M H:i')
                                                : '-'
                                            }}

                                        </span>

                                    </div>

                                    <p class="text-xs text-gray-500 truncate mt-1">

                                        {{
                                            $lastMessage['message']
                                            ?? 'Belum ada pesan'
                                        }}

                                    </p>

                                </div>

                            </a>

                        @empty

                            <div class="h-full flex items-center justify-center text-gray-400 text-sm">

                                Belum ada chat

                            </div>

                        @endforelse

                    </div>

                </div>

                {{-- ================================= --}}
                {{-- RIGHT --}}
                {{-- ================================= --}}
                <div class="flex flex-col min-h-0 {{ $selectedRoom ? 'flex' : 'hidden lg:flex' }}">

                    @if ($selectedRoom)

                        {{-- PROFILE --}}
                        <div class="px-5 py-4 border-b border-gray-100 flex items-center gap-3 bg-white shrink-0">

                            <a href="/seller/chat" class="lg:hidden text-gray-500 hover:text-black mr-2 flex items-center">
                                <i class="ri-arrow-left-line text-2xl"></i>
                            </a>

                            <img
                                src="https://ui-avatars.com/api/?name={{ urlencode($selectedRoom['buyer']['name']) }}"
                                class="w-11 h-11 rounded-full object-cover">

                            <div>

                                <h3 class="font-semibold text-sm">

                                    {{ $selectedRoom['buyer']['name'] }}

                                </h3>

                                <p class="text-xs text-green-500 mt-0.5">

                                    ● Online

                                </p>

                            </div>

                        </div>

                        {{-- CHAT AREA --}}
                        <div
                            id="chat-box"
                            class="flex-1 overflow-y-auto px-5 py-5 bg-[#FFFCFC]">

                            <div class="flex flex-col gap-4 justify-end min-h-full">

                                @foreach (array_reverse(array_values($messages)) as $message)

                                    @if (
                                        $message['sender_id']
                                        == session('user')['id']
                                    )

                                        {{-- CHAT KANAN --}}
                                        <div class="flex justify-end">

                                            <div class="max-w-[320px]">

                                                <div class="bg-[#DDE8C8] px-4 py-3 rounded-2xl rounded-br-md">

                                                    <p class="text-sm break-words leading-relaxed">

                                                        {{ $message['message'] }}

                                                    </p>

                                                </div>

                                                <p class="text-[10px] text-gray-400 text-right mt-1 pr-1">

                                                    {{
                                                        \Carbon\Carbon::parse(
                                                            $message['created_at']
                                                        )->timezone('Asia/Jakarta')->format('H:i')
                                                    }}

                                                </p>

                                            </div>

                                        </div>

                                    @else

                                        {{-- CHAT KIRI --}}
                                        <div class="flex justify-start">

                                            <div class="max-w-[320px]">

                                                <div class="bg-white border border-gray-100 px-4 py-3 rounded-2xl rounded-bl-md shadow-sm">

                                                    <p class="text-sm break-words leading-relaxed">

                                                        {{ $message['message'] }}

                                                    </p>

                                                </div>

                                                <p class="text-[10px] text-gray-400 mt-1 pl-1">

                                                    {{
                                                        \Carbon\Carbon::parse(
                                                            $message['created_at']
                                                        )->timezone('Asia/Jakarta')->format('H:i')
                                                    }}

                                                </p>

                                            </div>

                                        </div>

                                    @endif

                                @endforeach

                            </div>

                        </div>

                        {{-- INPUT --}}
                        <form
                            action="/seller/chat/{{ $selectedRoom['id'] }}/send"
                            method="POST"
                            class="p-4 border-t border-gray-100 bg-white flex items-center gap-3 shrink-0">

                            @csrf

                            {{-- INPUT --}}
                            <div class="flex-1 h-12 bg-[#FFF1F1] rounded-full px-5 flex items-center">

                                <input
                                    type="text"
                                    name="message"
                                    placeholder="Ketik pesan..."
                                    autocomplete="off"
                                    class="w-full bg-transparent outline-none text-sm">

                            </div>

                            {{-- BUTTON --}}
                            <button
                                type="submit"
                                class="w-12 h-12 rounded-full bg-[#F27F8D] hover:bg-pink-400 transition flex items-center justify-center shrink-0">

                                <i class="ri-send-plane-fill text-white text-lg"></i>

                            </button>

                        </form>

                    @else

                        {{-- EMPTY --}}
                        <div class="flex-1 flex flex-col items-center justify-center text-gray-400">

                            <i class="ri-chat-3-line text-7xl"></i>

                            <h3 class="mt-4 text-lg font-semibold">

                                Belum Ada Chat

                            </h3>

                            <p class="mt-1 text-sm">

                                Pilih chat untuk mulai membalas pesan

                            </p>

                        </div>

                    @endif

                </div>

            </div>

        </div>

    </div>

</div>

{{-- AUTO SCROLL --}}
<script>

    document.addEventListener('DOMContentLoaded', () => {

        const chatBox =
            document.getElementById('chat-box');

        if (chatBox) {

            chatBox.scrollTop =
                chatBox.scrollHeight;

        }

    });

</script>

@endsection