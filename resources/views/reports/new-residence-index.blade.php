@extends('layout.app')

@section('title', 'Data Penduduk Baru - SapaTrantib')

@section('content')
<div class="min-h-screen w-full relative overflow-hidden flex">

    <!-- Main Content -->
    <div class="flex-1 p-8 md:p-16 bg-[#1a3326] min-h-screen">
        <div class="max-w-5xl mx-auto">
            <!-- Header -->
            <div class="flex flex-col md:flex-row md:items-center justify-between mb-8">
                <div>
                    <h1 class="text-4xl font-bold text-white mb-1">Data Penduduk Baru</h1>
                    <p class="text-white/80 text-sm">Kelola laporan pendaftaran penduduk baru</p>
                </div>
                <span class="bg-[#3d5c4c] text-white px-3 py-1 rounded-full text-xs font-medium mt-4 md:mt-0">
                    {{ $reports->count() }} laporan
                </span>
            </div>

            <!-- Filter Form - Status only -->
            <form method="GET" class="flex flex-row sm:flex-row gap-4 mb-6">
                <div class="flex-1 sm:flex-1">
                    <select name="status" class="block w-full rounded-xl bg-[#3d5c4c] hover:bg-[#4a6a56] px-3 py-2 text-white focus:outline-none focus:ring-2 focus:ring-emerald-400 transition-all appearance-none">
                        <option value="" {{ $request->status == '' ? 'selected' : '' }}>Semua Status</option>
                        <option value="pending" {{ $request->status == 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="resolved" {{ $request->status == 'resolved' ? 'selected' : '' }}>Selesai</option>
                        <option value="rejected" {{ $request->status == 'rejected' ? 'selected' : '' }}>Ditolak</option>
                    </select>
                </div>
                <button type="submit" class="bg-[#3d5c4c] hover:bg-[#4a6a56] text-white px-3 py-2 rounded-xl font-medium transition-colors border border-[#4a6a56]">Filter</button>
            </form>

                @forelse($reports as $report)
                <div class="rounded-2xl shadow-sm border border-white/20 overflow-hidden mb-8">
                    <div class="flex flex-col md:flex-row">

                        <!-- Content -->
                        <div class="p-6 flex-1">
                            <h3 class="text-xl font-bold text-[#ffffff] mb-2">{{ $report->nama }}</h3>
                            <div class="grid grid-cols-2 md:grid-cols-4 gap-4 text-sm text-white/70 mb-4">
                                <div>
                                    <div class="text-white text-xs font-medium uppercase tracking-wider mb-1">NIK</div>
                                    <div class="text-white">{{ $report->nik }}</div>
                                </div>
                                <div>
                                    <div class="text-white text-xs font-medium uppercase tracking-wider mb-1">Nomor Telepon</div>
                                    <div class="text-white">{{ $report->nomor_telepon }}</div>
                                </div>
                                <div class="md:col-span-2">
                                    <div class="text-white text-xs font-medium uppercase tracking-wider mb-1">Alamat</div>
                                    <div class="text-white line-clamp-2">{{ $report->alamat }}</div>
                                </div>
                            </div>

                            <div class="flex items-center gap-2 mb-4 text-sm text-white/60 mt-2">
                                <span>{{ \Illuminate\Support\Carbon::parse($report->created_at)->format('d F Y H:i') }}</span>
                                <span class="text-white/40">|</span>
                                <span class="text-white">{{ optional($report->user)->username ?? '-' }}</span>
                            </div>

                            <div class="flex flex-col md:flex-row md:items-end justify-between gap-4">
                                <div class="flex gap-2">
                                    <span class="px-2 py-1 text-xs rounded-full 
                                        @if($report->status === 'pending') bg-emerald-500/20 text-emerald-400
                                        @elseif($report->status === 'resolved') bg-blue-500/20 text-blue-400
                                        @elseif($report->status === 'rejected') bg-rose-500/20 text-rose-400
                                        @endif
                                    ">
                                        {{ ucfirst($report->status) }}
                                    </span>
                                </div>
                                <div class="flex gap-2">
                                    @if ($isAdmin)
                                    <form action="{{ route('warga.reports.new-residence.destroy', $report->new_residence_id) }}" method="POST" class="inline">
                                        @csrf @method('DELETE')
                                        <button type="submit" onclick="return confirm('Yakin menghapus laporan penduduk baru ini?')" class="bg-[#a63d3d] hover:bg-[#8f3333] flex flex-row text-white px-4 py-2 rounded-lg text-sm font-medium transition-colors border border-[#c96b6b]">
                                            Hapus
                                        </button>
                                    </form>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @empty
                <div class="text-center py-12"><p class="text-white/50">Belum ada laporan penduduk baru.</p></div>
                @endforelse
            </div>

            {{ $reports->links() }}
        </div>
    </div>
</div>
@endsection