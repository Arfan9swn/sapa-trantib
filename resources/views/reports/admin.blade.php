@extends('layout.app')

@section('title', 'Daftar Laporan - SapaTrantib')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    
    <!-- Header -->
    <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4 mb-8">
        <div>
            <h1 class="text-3xl font-bold text-white mb-1">Admin – Laporan List</h1>
            <p class="text-white/60 text-sm">Kelola laporan dari pengguna</p>
        </div>
        
        <a href="{{ route('reports.create') }}" class="inline-flex items-center justify-center w-full lg:w-auto px-8 py-4 text-base font-medium text-white bg-emerald-600 rounded-full hover:bg-emerald-700 focus:outline-none focus:ring-2 focus:ring-emerald-500/40 transition-all duration-200 shadow-xl shadow-emerald-900/40 hover:shadow-emerald-900/60">
            <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
            </svg>
            Buat Laporan Baru
        </a>
    </div>
    
    <!-- Reports Table -->
    @if($reports->isEmpty())
    <div class="bg-white/5 rounded-lg p-8 text-center text-white">
        <p class="text-white/60 text-sm">Belum ada laporan</p>
    </div>
    @else
    <div overflow-x-auto bg-white/5 rounded-lg p-8">
        <table class="w-full caption-bottom text-white">
            <thead>
                <tr class="text-left text-sm text-white/60 border-b border-white/10">
                    <th class="py-4 width-48">#</th>
                    <th class="py-4">Judul</th>
                    <th class="py-4 width-32">Kategori</th>
                    <th class="py-4 width-32">Sub Kategori</th>
                    <th class="py-4 width-24">Status</th>
                    <th class="py-4 width-24">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($reports as $index => $report)
                <tr class="border-b border-white/10 last:border-0">
                    <td class="py-6 font-medium">{{ $index + 1 }}</td>
                    <td class="py-6">{{ substr($report->title, 0, 50) }}</td>
                    <td class="py-6">{{ $report->category ? $report->category->name : '-' }}</td>
                    <td class="py-6">{{ $report->subCategory ? $report->subCategory->name : '-' }}</td>
                    <td class="py-6">
                        <span class="px-2 py-1 text-xs rounded-full bg-emerald-500/20 text-emerald-400">
                            {{ $report->status }}
                        </span>
                    </td>
                    <td class="py-6">
                        <form action="{{ route('reports.destroy', $report->report_id) }}" method="POST" style="display:inline">
                            @csrf(@method('DELETE'))
                            <button onclick="return confirm('Yakin menghapus laporan ini?')" class="text-red-400 hover:text-red-300 text-sm font-medium">
                                Hapus
                            </button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @endif
    
</div>
@endsection