@extends('layout.app')

@section('content')
<div class="container mx-auto px-6 py-8">
    <div class="max-w-4xl mx-auto">
        <div class="bg-[#3d5c4c] rounded-2xl p-6 shadow-2xl border border-[#4a6a56]">
            <div class="mb-6">
                <h2 class="text-xl font-bold text-white mb-1">Kelola RT</h2>
                <p class="text-emerald-200 text-sm">Kelola data RT (Rukun Tetangga) di sistem.</p>
            </div>
            
            <div class="overflow-x-auto">
                <table class="w-full text-white">
                    <thead>
                        <tr class="text-left text-sm text-white/60 border-b border-white/10">
                            <th class="py-4">#</th>
                            <th class="py-4">No. RT</th>
                            <th class="py-4">Kepala RT</th>
                            <th class="py-4">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($rts as $index => $rt)
                        <tr class="border-b border-white/10 last:border-0">
                            <td class="py-6 font-medium">{{ $index + 1 }}</td>
                            <td class="py-6">{{ $rt->rt_number }}</td>
                            <td class="py-6">{{ $rt->head_name }}</td>
                            <td class="py-6">
                                <form action="{{ route('rts.destroy', $rt->rt_id) }}" method="POST" style="display:inline">
                                    @csrf(@method('DELETE'))
                                    <button onclick="return confirm('Yakin menghapus RT ini?')" class="text-red-400 hover:text-red-300 text-sm font-medium">
                                        Hapus
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            
            <div class="mt-6 flex justify-end">
                <a href="{{ route('rts.create') }}" class="bg-emerald-600 text-white px-6 py-3 rounded-lg font-medium hover:bg-emerald-700 transition-all">Tambah RT Baru</a>
            </div>
        </div>
    </div>
</div>
@endsection