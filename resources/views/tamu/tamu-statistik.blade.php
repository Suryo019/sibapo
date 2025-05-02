{{-- @dd($data) --}}

<x-tamu-layout>
    <div class="w-full flex flex-col justify-center items-center text-pink-650 mb-16">
        <h1 class="text-5xl font-extrabold mb-8">Statistik Harga</h1>
        <h5 class="text-xl text-shadow mb-16">Data perubahan harga setiap bahan pokok dalam 1 bulan</h5>
        <form action="{{ route('tamu.komoditas') }}" method="GET" class="flex flex-wrap gap-16 items-center">
            @csrf
        
            {{-- Sorting Root --}}
            <div>
                <select name="kategori" class="border border-pink-650 px-4 py-2 rounded-full bg-white text-sm text-gray-500 focus:outline-none">
                    <option value="pasar">Per Pasar</option>
                    <option value="bahan_pokok">Per Bahan Pokok</option>
                </select>
            </div>
        
            {{-- Sorting Child --}}
            <div>
                <select name="filter_pasar" class="border border-pink-650 px-4 py-2 rounded-full bg-white text-sm text-gray-500 focus:outline-none">
                    <option value="">Pasar Tanjung</option>
                    {{-- Tambahkan opsi pasar lain jika diperlukan --}}
                </select>
            </div>
        
            {{-- Tanggal (Bulan) --}}
            <div>
                <input type="month" name="periode"
                    value="{{ date('Y-m') }}"
                    class="border border-pink-650 px-4 py-2 rounded-full bg-white text-sm text-gray-500 focus:outline-none">
            </div>
        
            {{-- Cari Bahan Pokok --}}
            <div class="relative">
                <i class="bi bi-search absolute left-3 top-1/2 transform -translate-y-1/2 text-pink-650"></i>
                <input type="text" name="search" placeholder="Cari Bahan Pokok"
                    class="pl-10 pr-4 py-2 border border-pink-650 rounded-full bg-white text-sm text-gray-500 focus:outline-none placeholder-gray-500">
            </div>
        </form>
    </div>

    {{-- Daftar Komoditas --}}
    <div class="w-[90%] max-w-7xl overflow-auto max-h-screen mx-auto rounded-lg" id="comoditiesList">
      <table class="min-w-full text-sm text-gray-700">
        <thead class="sticky top-0 z-10 bg-white">
          <tr class="shadow-pink-hard rounded-3xl bg-white">
            <th class="px-4 py-5 text-center font-semibold rounded-l-3xl">No</th>
            <th class="px-4 py-5 text-center font-semibold whitespace-nowrap">Bahan Pokok</th>
            @for ($i = 1; $i <= 30; $i++)
              <th class="px-4 py-5 text-center font-semibold {{ $i == 30 ? 'rounded-r-full' : '' }}">{{ $i }}</th>
            @endfor
          </tr>
        </thead>
        <tbody>
          <tr class="bg-white hover:bg-pink-50 rounded-full shadow-pink-hard transition duration-150">
            <td class="px-4 py-3 text-center rounded-l-full">1</td>
            <td class="px-4 py-3 text-center">Beras</td>
            @for ($i = 1; $i <= 30; $i++)
              <td class="px-4 py-3 text-center {{ $i == 30 ? 'rounded-r-full' : '' }} whitespace-nowrap">Rp. 150.000</td>
            @endfor
          </tr>
        </tbody>
      </table>
    </div>

    
</x-tamu-layout>