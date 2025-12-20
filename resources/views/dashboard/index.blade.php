@extends('layouts.dashboard')

@section('title', 'Beranda - Dinas Kesehatan Kota Kediri')

@section('heading', 'Analitik Dashboard')

@section('content')
<div class="space-y-6">
    <!-- Section 1: Top Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        {{-- Total Artikel --}}
        <div class="p-6 bg-white rounded-2xl shadow-sm border border-gray-100 dark:bg-gray-800 dark:border-gray-700 flex items-center space-x-4 transition-all hover:shadow-md">
            <div class="p-3 bg-blue-100 rounded-xl dark:bg-blue-900">
                <svg class="w-8 h-8 text-blue-600 dark:text-blue-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z" />
                </svg>
            </div>
            <div>
                <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Total Artikel</p>
                <h3 class="text-3xl font-bold text-gray-900 dark:text-white">{{ number_format($totalArticles) }}</h3>
            </div>
        </div>

        {{-- Total Berita --}}
        <div class="p-6 bg-white rounded-2xl shadow-sm border border-gray-100 dark:bg-gray-800 dark:border-gray-700 flex items-center space-x-4 transition-all hover:shadow-md">
            <div class="p-3 bg-emerald-100 rounded-xl dark:bg-emerald-900">
                <svg class="w-8 h-8 text-emerald-600 dark:text-emerald-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5h8M11 12h8M11 19h8M5 5h1v1H5V5zm0 7h1v1H5v-1zm0 7h1v1H5v-1z" />
                </svg>
            </div>
            <div>
                <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Total Berita</p>
                <h3 class="text-3xl font-bold text-gray-900 dark:text-white">{{ number_format($totalNews) }}</h3>
            </div>
        </div>
    </div>

    <!-- Section 2: Monthly Reader Trends Chart -->
    <div class="p-6 bg-white rounded-2xl shadow-sm border border-gray-100 dark:bg-gray-800 dark:border-gray-700">
        <div class="flex items-center justify-between mb-4">
            <h4 class="text-lg font-bold text-gray-900 dark:text-white">Tren Kunjungan Bulanan</h4>
            <span class="text-sm font-medium text-gray-400">Periode 12 Bulan Terakhir</span>
        </div>
        <div id="viewsChart"></div>
    </div>

    <!-- Section 3: Detailed Content Tables -->
    <div class="grid grid-cols-1 xl:grid-cols-2 gap-6">
        <!-- Artikel Terpopuler -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 dark:bg-gray-800 dark:border-gray-700 overflow-hidden">
            <div class="p-5 border-b border-gray-50 dark:border-gray-700 flex items-center justify-between bg-blue-50/50 dark:bg-blue-900/10">
                <h4 class="text-md font-bold text-blue-800 dark:text-blue-300 flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" /></svg>
                    Artikel Terpopuler
                </h4>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-sm text-left text-gray-500">
                    <thead class="text-xs text-gray-400 uppercase bg-gray-50/50 dark:bg-gray-700">
                        <tr>
                            <th scope="col" class="px-6 py-3">Judul Artikel</th>
                            <th scope="col" class="px-6 py-3 text-center">Views</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50 dark:divide-gray-700">
                        @forelse($popularArticles as $article)
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                            <td class="px-6 py-4 font-medium text-gray-900 dark:text-white truncate max-w-xs">{{ $article->title }}</td>
                            <td class="px-6 py-4 text-center font-bold text-blue-600 bg-blue-50/30">{{ number_format($article->views) }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="2" class="px-6 py-10 text-center text-gray-400 italic">Belum ada data artikel.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Berita Terpopuler -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 dark:bg-gray-800 dark:border-gray-700 overflow-hidden">
            <div class="p-5 border-b border-gray-50 dark:border-gray-700 flex items-center justify-between bg-emerald-50/50 dark:bg-emerald-900/10">
                <h4 class="text-md font-bold text-emerald-800 dark:text-emerald-300 flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2" /></svg>
                    Berita Terpopuler
                </h4>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-sm text-left text-gray-500">
                    <thead class="text-xs text-gray-400 uppercase bg-gray-50/50 dark:bg-gray-700">
                        <tr>
                            <th scope="col" class="px-6 py-3">Judul Berita</th>
                            <th scope="col" class="px-6 py-3 text-center">Views</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50 dark:divide-gray-700">
                        @forelse($popularNews as $news_item)
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                            <td class="px-6 py-4 font-medium text-gray-900 dark:text-white truncate max-w-xs">{{ $news_item->title }}</td>
                            <td class="px-6 py-4 text-center font-bold text-emerald-600 bg-emerald-50/30">{{ number_format($news_item->views) }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="2" class="px-6 py-10 text-center text-gray-400 italic">Belum ada data berita.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Section 4: Active Announcements -->
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 dark:bg-gray-800 dark:border-gray-700 overflow-hidden">
        <div class="p-5 border-b border-gray-50 dark:border-gray-700 bg-amber-50/50 dark:bg-amber-900/10">
            <h4 class="text-md font-bold text-amber-800 dark:text-amber-300 flex items-center">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                Pengumuman Aktif
            </h4>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left text-gray-500">
                <thead class="text-xs text-gray-400 uppercase bg-gray-50/50 dark:bg-gray-700">
                    <tr>
                        <th scope="col" class="px-6 py-3">Judul Pengumuman</th>
                        <th scope="col" class="px-6 py-3 text-center">Deadline</th>
                        <th scope="col" class="px-6 py-3 text-center">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50 dark:divide-gray-700">
                    @forelse($announcements as $announcement)
                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                        <td class="px-6 py-4 font-medium text-gray-900 dark:text-white">{{ $announcement->title }}</td>
                        <td class="px-6 py-4 text-center text-gray-600 dark:text-gray-400 font-mono text-xs">
                            {{ \Carbon\Carbon::parse($announcement->expires_at)->format('d M Y') }}
                        </td>
                        <td class="px-6 py-4 text-center">
                            @php $daysLeft = now()->diffInDays($announcement->expires_at, false); @endphp
                            @if($daysLeft <= 3)
                                <span class="px-2 py-1 text-[10px] font-bold text-red-700 bg-red-100 rounded-lg">Segera Berakhir</span>
                            @else
                                <span class="px-2 py-1 text-[10px] font-bold text-emerald-700 bg-emerald-100 rounded-lg">Aktif</span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="3" class="px-6 py-10 text-center text-gray-400 italic">Tidak ada pengumuman aktif saat ini.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
<script>
    var options = {
        series: [{
            name: 'Total Kunjungan',
            data: @json($chartData)
        }],
        chart: {
            height: 350,
            type: 'area',
            toolbar: { show: false },
            zoom: { enabled: false }
        },
        colors: ['#3B82F6'],
        dataLabels: { enabled: false },
        stroke: { curve: 'smooth', width: 3 },
        fill: {
            type: 'gradient',
            gradient: {
                shadeIntensity: 1,
                opacityFrom: 0.45,
                opacityTo: 0.05,
                stops: [20, 100, 100, 100]
            }
        },
        xaxis: {
            categories: @json($chartLabels),
        },
        tooltip: {
            x: { format: 'MMMM' },
        },
        noData: {
            text: 'Belum ada data kunjungan...',
            align: 'center',
            verticalAlign: 'middle',
            offsetX: 0,
            offsetY: 0,
        }
    };

    var chart = new ApexCharts(document.querySelector("#viewsChart"), options);
    chart.render();
</script>
@endpush
