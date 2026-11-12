@extends('layout.app')

@section('content')
<div class="container mx-auto px-6 py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        
        <!-- Header -->
        <div class="flex flex-col lg:flex-row lg:justify-between gap-4 mb-8">
            <div>
                <h1 class="text-3xl font-bold text-white mb-1">Kelola RT</h1>
                <p class="text-white/60 text-sm">Kelola data RT.</p>
            </div>
            
            <a href="{{ route('rts.create') }}" class="inline-flex items-center justify-center w-full lg:w-auto px-8 py-4 text-base font-medium text-white bg-emerald-600 rounded-[10px] hover:bg-emerald-700 focus:outline-none focus:ring-2 focus:ring-emerald-500/40 transition-all duration-200 shadow-emerald-900/40 hover:shadow-emerald-900/60">
                <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                Tambah RT Baru
            </a>
        </div>

        @if(session('success'))
        <div class="mb-6 p-4 bg-emerald-500/10 border border-emerald-500/30 rounded-xl text-emerald-200 text-sm">
            {{ session('success') }}
        </div>
        @endif

    @if($rts->isEmpty())
    <div class="bg-[#3d5c4c] rounded-2xl p-12 text-center border border-[#4a6a56]">
        <p class="text-white/50 text-lg">Belum ada RT. Buat RT pertama Anda.</p>
        <a href="{{ route('rts.create') }}" class="mt-4 inline-block px-6 py-2 bg-emerald-600 hover:bg-emerald-700 rounded-lg text-white text-sm font-medium transition-colors">Buat RT Baru</a>
    </div>
    @else
    
    <!-- RT Cards Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach($rts as $rt)
        <div class="bg-[#3d5c4c] rounded-2xl p-6 border border-[#4a6a56] shadow-lg hover:border-[#8fd89b]/50 transition-all duration-200">
            <div class="flex items-start justify-between mb-4">
                <div>
                    <h3 class="text-xl font-bold text-white">{{ $rt->rt_number }}</h3>
                    <p class="text-white/60 text-sm">RT {{ $rt->rt_number }}</p>
                </div>
                <div class="flex items-center gap-2">
                    <span class="text-white/40 hover:text-white text-xs font-medium uppercase tracking-widest">RT {{ $rt->rt_number }}</span>
                </div>
            </div>
            
            <p class="text-white/60 text-sm mb-6">Kepala RT: {{ $rt->head_name }}</p>
            
            <div class="flex gap-2">
                <a href="{{ route('rts.edit', $rt->rt_id) }}"
                   class="flex-1 flex items-center justify-center gap-2 px-4 py-2.5 text-sm font-medium text-white/80 hover:text-white hover:bg-white/20 rounded-xl transition-colors border border-white/20">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 23l3-7m0 0l-3-7m3 7l-3 7"></path>
                    </svg>
                    Edit
                </a>
                
                <form action="{{ route('rts.destroy', $rt->rt_id) }}" method="POST" class="inline">
                    @csrf(@method('DELETE'))
                    <button onclick="return confirm('Yakin menghapus RT ini?')" class="text-white/40 hover:text-red-400 transition-colors text-sm font-medium">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                        </svg>
                    </button>
                </form>
            </div>
        </div>
        @endforeach
    </div>
    
    @endif
</div>
</div>
@endsection