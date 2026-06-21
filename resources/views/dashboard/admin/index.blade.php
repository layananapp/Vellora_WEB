@extends('layouts.app')

@section('title', 'Admin Dashboard')

@section('content')

<div class="min-h-screen bg-[#F5F5F5] flex flex-col lg:flex-row" x-data>

@include('dashboard.admin.partials.sidebar')

    {{-- CONTENT --}}
    <div class="flex-1 p-5 overflow-hidden">

        {{-- Header / Burger Menu --}}
        <div class="flex items-center gap-3 mb-4 lg:hidden">
            <button 
                type="button" 
                @click="$dispatch('toggle-sidebar')" 
                class="p-2 -ml-2 text-gray-700 hover:text-pink-500 transition text-2xl focus:outline-none"
            >
                <i class="ri-menu-line"></i>
            </button>
            <h2 class="text-2xl font-bold text-gray-800">Beranda Admin</h2>
        </div>

        {{-- TOP --}}
        <div class="flex flex-col md:flex-row gap-4">

            {{-- Welcome --}}
            <div class="flex-1 min-h-[96px] py-4 rounded-[24px] bg-gradient-to-b from-pink-200 to-[#DDE8C8] px-6 md:px-8 flex items-center justify-between shadow-sm">

                <div class="pr-2">

                    <h2 class="text-[24px] font-bold text-[#2B2B2B]">
                        Selamat datang, Admin Vellora!
                    </h2>

                    <p class="text-gray-700 mt-1 text-sm">
                        Berikut ringkasan marketplace hari ini
                    </p>

                </div>

                <img
                    src="https://cdn-icons-png.flaticon.com/512/2620/2620971.png"
                    alt=""
                    class="w-24 h-24 object-contain">

            </div>

            {{-- Date --}}
            <div class="w-full md:w-44 bg-white rounded-[24px] shadow-sm px-4 py-4 flex flex-col justify-center">

                <h3 class="text-[24px] font-bold text-center">
                    Hari Ini
                </h3>

                <div class="flex items-center justify-center gap-2 mt-2">

                    <i class="ri-calendar-line text-xl"></i>

                    <span class="font-semibold text-[13px]">
                        {{ now()->translatedFormat('d M Y') }}
                    </span>

                </div>

            </div>

        </div>

        {{-- Statistik --}}
        <div class="mt-6 overflow-x-scroll pb-2">

            <div class="flex gap-3 w-max">

                {{-- Card --}}
                <div class="w-[210px] flex-shrink-0 bg-white rounded-[20px] shadow-sm px-3 py-3 flex items-center gap-3">

                    <div class="w-12 h-12 rounded-full bg-[#DDE8C8] flex items-center justify-center">

                        <i class="ri-shopping-bag-line text-2xl text-pink-400"></i>

                    </div>

                    <div>

                        <p class="text-xs font-semibold">
                            Total Produk
                        </p>

                        <h3 class="text-2xl font-bold leading-none mt-1">
                            {{ $total_products }}
                        </h3>

                        <p class="text-gray-500 text-[11px] mt-1">
                            Dibanding bulan lalu
                        </p>

                    </div>

                </div>

                {{-- Card --}}
                <div class="w-[210px] flex-shrink-0 bg-white rounded-[20px] shadow-sm px-3 py-3 flex items-center gap-3">

                    <div class="w-12 h-12 rounded-full bg-[#DDE8C8] flex items-center justify-center">

                        <i class="ri-user-3-line text-2xl text-pink-400"></i>

                    </div>

                    <div>

                        <p class="text-xs font-semibold">
                            Total User
                        </p>

                        <h3 class="text-2xl font-bold leading-none mt-1">
                            {{ count($users) }}
                        </h3>

                        <p class="text-gray-500 text-[11px] mt-1">
                            Dibanding bulan lalu
                        </p>

                    </div>

                </div>

                {{-- Card --}}
                <div class="w-[210px] flex-shrink-0 bg-white rounded-[20px] shadow-sm px-3 py-3 flex items-center gap-3">

                    <div class="w-12 h-12 rounded-full bg-[#DDE8C8] flex items-center justify-center">

                        <i class="ri-store-2-line text-2xl text-pink-400"></i>

                    </div>

                    <div>

                        <p class="text-xs font-semibold">
                            Total Seller
                        </p>

                        <h3 class="text-2xl font-bold leading-none mt-1">
                            {{ count($sellers) }}
                        </h3>

                        <p class="text-gray-500 text-[11px] mt-1">
                            Dibanding bulan lalu
                        </p>

                    </div>

                </div>

                {{-- Card --}}
                <div class="w-[210px] flex-shrink-0 bg-white rounded-[20px] shadow-sm px-3 py-3 flex items-center gap-3">

                    <div class="w-12 h-12 rounded-full bg-[#DDE8C8] flex items-center justify-center">

                        <i class="ri-box-3-line text-2xl text-pink-400"></i>

                    </div>

                    <div>

                        <p class="text-xs font-semibold">
                            Total Pesanan
                        </p>

                        <h3 class="text-2xl font-bold leading-none mt-1">
                            {{ count($orders) }}
                        </h3>

                        <p class="text-gray-500 text-[11px] mt-1">
                            Dibanding bulan lalu
                        </p>

                    </div>

                </div>

                {{-- Card --}}
                <div class="w-[210px] flex-shrink-0 bg-white rounded-[20px] shadow-sm px-3 py-3 flex items-center gap-3">

                    <div class="w-12 h-12 rounded-full bg-[#DDE8C8] flex items-center justify-center">

                        <i class="ri-error-warning-line text-2xl text-pink-400"></i>

                    </div>

                    <div>

                        <p class="text-xs font-semibold">
                            Laporan
                        </p>

                        <h3 class="text-2xl font-bold leading-none mt-1">
                            {{ count($reports) }}
                        </h3>

                        <p class="text-gray-500 text-[11px] mt-1">
                            Dibanding bulan lalu
                        </p>

                    </div>

                </div>

                {{-- Card --}}
                <div class="w-[210px] flex-shrink-0 bg-white rounded-[20px] shadow-sm px-3 py-3 flex items-center gap-3">

                    <div class="w-12 h-12 rounded-full bg-[#DDE8C8] flex items-center justify-center">

                        <i class="ri-alarm-warning-line text-2xl text-pink-400"></i>

                    </div>

                    <div>

                        <p class="text-xs font-semibold">
                            Pesanan Hari Ini
                        </p>

                        <h3 class="text-2xl font-bold leading-none mt-1">
                            {{ collect($orders)->filter(fn($o) => \Carbon\Carbon::parse($o['created_at'])->isToday())->count() }}
                        </h3>

                        <p class="text-gray-500 text-[11px] mt-1">
                            Hari ini
                        </p>

                    </div>

                </div>

                {{-- Card --}}
                <div class="w-[210px] flex-shrink-0 bg-white rounded-[20px] shadow-sm px-3 py-3 flex items-center gap-3">

                    <div class="w-12 h-12 rounded-full bg-[#DDE8C8] flex items-center justify-center">

                        <i class="ri-notification-2-line text-2xl text-pink-400"></i>

                    </div>

                    <div>

                        <p class="text-xs font-semibold">
                            Produk Baru
                        </p>

                        <h3 class="text-2xl font-bold leading-none mt-1">
                            {{ collect($products)->filter(fn($p) => \Carbon\Carbon::parse($p['created_at'])->isCurrentWeek())->count() }}
                        </h3>

                        <p class="text-gray-500 text-[11px] mt-1">
                            Minggu ini
                        </p>

                    </div>

                </div>

            </div>

        </div>

         {{-- Bottom --}}
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-5 mt-6">

            {{-- Grafik --}}
            <div class="bg-white rounded-[24px] shadow-sm p-5">

                <h3 class="text-xl font-bold">
                    Grafik Transaksi (7 Hari Terakhir)
                </h3>

                <div class="mt-5 h-[280px] relative">
                    <canvas id="transactionBarChart"></canvas>
                </div>

            </div>

            {{-- Status --}}
            <div class="bg-white rounded-[24px] shadow-sm p-5">

                <h3 class="text-xl font-bold">
                    Status Pesanan (7 Hari Terakhir)
                </h3>

                <div class="mt-5 h-[280px] relative">
                    <canvas id="orderStatusPieChart"></canvas>
                </div>

            </div>

        </div>

    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const ctxBar = document.getElementById('transactionBarChart').getContext('2d');
        new Chart(ctxBar, {
            type: 'bar',
            data: {
                labels: {!! json_encode($chart_bar_labels) !!},
                datasets: [{
                    label: 'Total Transaksi',
                    data: {!! json_encode($chart_bar_data) !!},
                    backgroundColor: '#FF8FA3',
                    borderColor: '#F07A55',
                    borderWidth: 1,
                    borderRadius: 8
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            callback: function(value) {
                                return 'Rp' + Number(value).toLocaleString('id-ID');
                            }
                        }
                    }
                },
                plugins: {
                    legend: {
                        display: false
                    }
                }
            }
        });

        const ctxPie = document.getElementById('orderStatusPieChart').getContext('2d');
        new Chart(ctxPie, {
            type: 'pie',
            data: {
                labels: {!! json_encode($chart_pie_labels) !!},
                datasets: [{
                    data: {!! json_encode($chart_pie_data) !!},
                    backgroundColor: [
                        '#FFD6A5', 
                        '#FDFFB6', 
                        '#CAFFBF', 
                        '#9BF6FF', 
                        '#C6DB92', 
                        '#FFADAD'  
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'right',
                        labels: {
                            boxWidth: 12,
                            font: {
                                size: 11
                            }
                        }
                    }
                }
            }
        });
    });
</script>

@endsection