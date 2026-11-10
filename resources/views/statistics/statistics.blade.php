@extends('layout.app')

@section('content')
<div class="max-w-7xl mx-auto space-y-6">

    <!-- Page Header -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h2 class="text-2xl font-serif italic text-white tracking-tight mb-1">Statistika</h2>
            <p class="text-sm text-[#8fd89b]/80">
                Ringkasan laporan per hari dan per kategori.
            </p>
        </div>
        <div class="text-right hidden md:block">
            <p class="text-sm text-white">{{ $totalReports }} total laporan</p>
        </div>
    </div>

    <!-- Statistics Cards Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

        <!-- RT — Line Chart (laporan per hari) -->
        <div class="bg-[#2d4a3a] border border-[#4a6a56] rounded-2xl p-5 shadow-xl">
            <div class="flex items-center gap-2 mb-4">
                <div class="w-8 h-8 rounded-lg bg-[#3d5c4c] flex items-center justify-center flex-shrink-0">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                    </svg>
                </div>
                <h3 class="text-base font-semibold text-white">RT</h3>
                <p class="text-xs text-[#8fd89b]/70 ml-auto">Jumlah laporan yang dikirim per hari</p>
            </div>

            <div class="h-64 w-full">
                <canvas id="rtLineChart"></canvas>
            </div>

            <div class="mt-4 flex items-center justify-between text-xs text-[#8fd89b]/60">
                <span>Garis = total laporan pada tanggal tersebut</span>
                <span class="font-medium">
                    @if (count($dates) > 0)
                        Periode: {{ $dates[0] }} s.d. {{ $dates[array_key_last($dates)] }}
                    @else
                        Periode: —
                    @endif
                </span>
            </div>
        </div>

        <!-- Kasus — Stacked Column Chart (per kategori per hari) -->
        <div class="bg-[#2d4a3a] border border-[#4a6a56] rounded-2xl p-5 shadow-xl">
            <div class="flex items-center gap-2 mb-4">
                <div class="w-8 h-8 rounded-lg bg-[#3d5c4c] flex items-center justify-center flex-shrink-0">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M3 14h18m-9-4v8m-9 4V6m0 10V6m9 4v8m-9-4V6m-5 10V6m-5 4V6m5 10v-8m-5 4V6"></path>
                    </svg>
                </div>
                <h3 class="text-base font-semibold text-white">Kasus</h3>
                <p class="text-xs text-[#8fd89b]/70 ml-auto">Laporan tumpang tindih per kategori tiap hari</p>
            </div>

            <div class="h-72 w-full">
                <canvas id="kasusColumnChart"></canvas>
            </div>

            <!-- Legend (kategori) -->
            <div class="mt-5 grid grid-cols-2 md:grid-cols-4 gap-x-6 gap-y-3">
                @forelse ($categories as $category)
                    <div class="flex items-center gap-2">
                        <span class="inline-block w-3 h-3 rounded-full"
                              style="background-color: {{ $palette[$loop->index % count($palette)] ?? '#94a3b8' }};"></span>
                        <span class="text-sm text-[#c9e3cb]">{{ $category->name }}</span>
                    </div>
                @empty
                    <p class="text-sm text-[#8fd89b]/60">Tidak ada kategori tersedia.</p>
                @endforelse
            </div>

            <div class="mt-3 text-xs text-[#8fd89b]/60">
                Setiap kolom = satu hari, ditumpuk berdasarkan kategori laporan.
            </div>
        </div>

    </div>

</div>

@php
    $palette = [
        '#3b82f6',
        '#22d3ee',
        '#ef4444',
        '#f59e0b',
        '#a855f7',
        '#10b981',
        '#fb923c',
    ];
@endphp
@endsection

<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const dates = @json($dates);
        const lineData = @json($lineData);
        const columnDatasets = @json($columnDatasets);
        const palette = @json($palette);

        // Format tanggal untuk sum X: dd.mm.yyyy (seperti desain)
        const displayDates = dates.map(function (d) {
            const parts = d.split('-');
            return parts[2] + '.' + parts[1] + '.' + parts[0];
        });

        const commonOptions = {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false },
                title: { display: false },
                tooltip: {
                    mode: 'index',
                    intersect: false,
                    backgroundColor: 'rgba(21, 42, 32, 0.9)',
                    titleColor: '#fff',
                    bodyColor: '#c9e3cb',
                    borderColor: '#4a6a56',
                    borderWidth: 1,
                    padding: 10,
                },
            },
            animation: {
                duration: 1200,
                easing: 'easeOutQuart',
            },
        };

        // =====================================================================
        // LINE CHART — RT (laporan per hari)
        // =====================================================================
        const rtCtx = document.getElementById('rtLineChart');
        if (rtCtx) {
            new Chart(rtCtx.getContext('2d'), {
                type: 'line',
                data: {
                    labels: displayDates,
                    datasets: [{
                        label: 'Laporan per Hari',
                        data: lineData,
                        borderColor: '#8fd89b',
                        backgroundColor: 'rgba(143, 216, 155, 0.15)',
                        borderWidth: 2.5,
                        pointRadius: 4,
                        pointHoverRadius: 6,
                        pointBackgroundColor: '#8fd89b',
                        pointBorderColor: '#fff',
                        pointBorderWidth: 2,
                        fill: true,
                        tension: 0.35,
                    }]
                },
                options: Object.assign({}, commonOptions, {
                    scales: {
                        x: {
                            grid: { color: 'rgba(74, 106, 86, 0.3)' },
                            ticks: { color: '#a6d189', font: { size: 11 } },
                        },
                        y: {
                            beginAtZero: true,
                            grid: { color: 'rgba(74, 106, 86, 0.3)' },
                            ticks: { color: '#a6d189', stepSize: 1, font: { size: 11 } },
                        }
                    },
                })
            });
        }

        // =====================================================================
        // STACKED COLUMN CHART — Kasus (per kategori, tumpang tindih per hari)
        // =====================================================================
        const kasusCtx = document.getElementById('kasusColumnChart');
        if (kasusCtx) {
            const datasets = columnDatasets.map(function (ds, i) {
                return {
                    label: ds.label,
                    data: ds.data,
                    backgroundColor: ds.backgroundColor || palette[i % palette.length],
                    borderWidth: 0,
                    barPercentage: 0.7,
                    categoryPercentage: 0.8,
                };
            });

            new Chart(kasusCtx.getContext('2d'), {
                type: 'bar',
                data: {
                    labels: displayDates,
                    datasets: datasets,
                },
                options: Object.assign({}, commonOptions, {
                    scales: {
                        x: {
                            stacked: true,
                            grid: { color: 'rgba(74, 106, 86, 0.3)' },
                            ticks: { color: '#a6d189', font: { size: 11 } },
                        },
                        y: {
                            stacked: true,
                            beginAtZero: true,
                            grid: { color: 'rgba(74, 106, 86, 0.3)' },
                            ticks: { color: '#a6d189', stepSize: 1, font: { size: 11 } },
                            title: {
                                display: true,
                                text: 'Jumlah laporan',
                                color: '#a6d189',
                                font: { size: 12, weight: '600' },
                            }
                        }
                    },
                })
            });
        }
    });
</script>
