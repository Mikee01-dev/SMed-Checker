{{-- resources/views/admin/history.blade.php --}}
@extends('layouts.admin')

@section('title', 'Riwayat Diagnosis')

@section('content')
<div class="mb-4 md:mb-6">
    <h1 class="text-xl md:text-2xl font-bold text-gray-800">Riwayat Diagnosis</h1>
    <p class="text-sm md:text-base text-gray-500">Semua data diagnosis yang pernah dilakukan</p>
</div>

<div class="bg-white rounded-xl shadow-sm overflow-hidden">
    <!-- Header Filter - Responsive -->
    <div class="px-4 md:px-6 py-3 md:py-4 border-b bg-gray-50">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-3">
            <h2 class="font-bold text-gray-800 text-sm md:text-base">Data Diagnosis</h2>
            
            <div class="flex flex-wrap items-center gap-2 w-full sm:w-auto">
                <!-- Filter Form -->
                <form method="GET" action="{{ route('admin.history') }}" class="flex flex-wrap items-center gap-2 w-full sm:w-auto">
                    <select name="filter" class="border border-gray-300 rounded-lg px-2 md:px-3 py-1.5 text-xs md:text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500" onchange="this.form.submit()">
                        <option value="all" {{ $filter == 'all' ? 'selected' : '' }}>Semua</option>
                        @foreach($tingkatList as $tingkat)
                        <option value="{{ $tingkat->kode }}" {{ $filter == $tingkat->kode ? 'selected' : '' }}>
                            {{ $tingkat->nama }}
                        </option>
                        @endforeach
                    </select>
                    
                    <select name="per_page" class="border border-gray-300 rounded-lg px-2 md:px-3 py-1.5 text-xs md:text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500" onchange="this.form.submit()">
                        <option value="10" {{ $perPage == 10 ? 'selected' : '' }}>10</option>
                        <option value="20" {{ $perPage == 20 ? 'selected' : '' }}>20</option>
                        <option value="50" {{ $perPage == 50 ? 'selected' : '' }}>50</option>
                        <option value="100" {{ $perPage == 100 ? 'selected' : '' }}>100</option>
                    </select>
                    
                    <div class="relative flex-1 sm:flex-none">
                        <input type="text" name="search" value="{{ $search }}" 
                               placeholder="Cari..." 
                               class="w-full sm:w-40 md:w-48 border border-gray-300 rounded-lg pl-7 pr-2 py-1.5 text-xs md:text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500"
                               id="searchInput">
                        <i class="fa-solid fa-search absolute left-2.5 top-2 text-gray-400 text-[10px] md:text-xs"></i>
                    </div>
                    
                    @if($search || $filter != 'all')
                    <a href="{{ route('admin.history') }}" class="text-red-500 hover:text-red-700 text-xs md:text-sm">
                        <i class="fa-solid fa-times"></i>
                    </a>
                    @endif
                </form>
            </div>
        </div>
    </div>

    <!-- Tabel - Responsive dengan Scroll -->
    <div class="overflow-x-auto">
        <table class="w-full min-w-[600px]">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-3 md:px-6 py-2 md:py-3 text-left text-[10px] md:text-xs font-medium text-gray-500 uppercase">ID</th>
                    <th class="px-3 md:px-6 py-2 md:py-3 text-left text-[10px] md:text-xs font-medium text-gray-500 uppercase">Tanggal</th>
                    <th class="px-3 md:px-6 py-2 md:py-3 text-left text-[10px] md:text-xs font-medium text-gray-500 uppercase">Nama</th>
                    <th class="px-3 md:px-6 py-2 md:py-3 text-left text-[10px] md:text-xs font-medium text-gray-500 uppercase">Hasil</th>
                    <th class="px-3 md:px-6 py-2 md:py-3 text-left text-[10px] md:text-xs font-medium text-gray-500 uppercase">Kecocokan</th>
                    <th class="px-3 md:px-6 py-2 md:py-3 text-left text-[10px] md:text-xs font-medium text-gray-500 uppercase">Gejala</th>
                    <th class="px-3 md:px-6 py-2 md:py-3 text-left text-[10px] md:text-xs font-medium text-gray-500 uppercase">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @forelse($riwayat as $item)
                <tr class="hover:bg-gray-50 transition">
                    <td class="px-3 md:px-6 py-2 md:py-4 text-[11px] md:text-sm text-gray-500">{{ $item->id }}</td>
                    <td class="px-3 md:px-6 py-2 md:py-4 text-[11px] md:text-sm text-gray-500 whitespace-nowrap">
                        {{ $item->created_at->format('d/m/Y H:i') }}
                    </td>
                    <td class="px-3 md:px-6 py-2 md:py-4 text-[11px] md:text-sm font-medium text-gray-800">
                        {{ $item->nama_pengguna ?? 'Anonim' }}
                    </td>
                    <td class="px-3 md:px-6 py-2 md:py-4">
                        <span class="px-1.5 md:px-2 py-0.5 md:py-1 rounded-full text-[9px] md:text-xs font-semibold whitespace-nowrap
                            @if($item->tingkatKecanduan && $item->tingkatKecanduan->kode == 'T01') bg-green-100 text-green-700
                            @elseif($item->tingkatKecanduan && $item->tingkatKecanduan->kode == 'T02') bg-yellow-100 text-yellow-700
                            @elseif($item->tingkatKecanduan && $item->tingkatKecanduan->kode == 'T03') bg-red-100 text-red-700
                            @else bg-gray-100 text-gray-700
                            @endif">
                            {{ $item->tingkatKecanduan->nama ?? 'Tidak Terdeteksi' }}
                        </span>
                    </td>
                    <td class="px-3 md:px-6 py-2 md:py-4 text-[11px] md:text-sm text-gray-500">
                        {{ round($item->persentase) }}%
                    </td>
                    <td class="px-3 md:px-6 py-2 md:py-4 text-[11px] md:text-sm text-gray-500">
                        {{ count($item->gejala_terpilih) }}
                    </td>
                    <td class="px-3 md:px-6 py-2 md:py-4">
                        <a href="{{ route('admin.history.detail', $item->id) }}" class="text-indigo-600 hover:text-indigo-800 mr-2" title="Detail">
                            <i class="fa-solid fa-eye text-sm md:text-base"></i>
                        </a>
                        <form method="POST" action="{{ route('admin.history.destroy', $item->id) }}" class="inline" onsubmit="return confirm('Yakin hapus data ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-600 hover:text-red-800" title="Hapus">
                                <i class="fa-solid fa-trash text-sm md:text-base"></i>
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="px-4 md:px-6 py-8 text-center text-gray-500">
                        <i class="fa-solid fa-inbox text-3xl md:text-4xl mb-2 block"></i>
                        Belum ada data diagnosis
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination - Responsive -->
    <div class="px-4 md:px-6 py-3 md:py-4 border-t bg-gray-50">
        <div class="flex flex-col sm:flex-row justify-between items-center gap-3">
            <div class="text-[11px] md:text-sm text-gray-500">
                Menampilkan {{ $riwayat->firstItem() }} - {{ $riwayat->lastItem() }} 
                dari {{ $riwayat->total() }} data
            </div>
            <div class="text-xs md:text-sm">
                {{ $riwayat->appends(['per_page' => $perPage, 'search' => $search, 'filter' => $filter])->links() }}
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    // Search dengan debounce
    let timeout = null;
    const searchInput = document.getElementById('searchInput');
    
    if (searchInput) {
        searchInput.addEventListener('keyup', function() {
            clearTimeout(timeout);
            timeout = setTimeout(() => {
                const form = this.closest('form');
                if (form) form.submit();
            }, 500);
        });
    }
</script>
@endpush
@endsection