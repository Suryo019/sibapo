<x-tamu-layout>
    <div class="w-full flex flex-col justify-center items-center text-pink-650 mb-16">
        <h1 class="text-5xl font-extrabold mb-8">Statistik Harga</h1>
        <h5 class="text-xl text-shadow mb-16">Data perubahan harga setiap bahan pokok dalam 1 bulan</h5>
        <form action="{{ route('tamu.komoditas') }}" method="GET" class="flex flex-wrap gap-16 items-center">
            @csrf
        
            {{-- Sorting Root --}}
            <div>
                <select name="sorting_category" id="sorting_category" class="border border-pink-650 px-4 py-2 rounded-full bg-white text-sm text-gray-500 focus:outline-none">
                    <option value="pasar">Per Pasar</option>
                    <option value="jenis_bahan_pokok">Per Bahan Pokok</option>
                </select>
            </div>
        
            {{-- Sorting Child --}}
            <div>
                <div class="relative flex flex-col">
                  <div class="border border-pink-650 px-4 py-2 rounded-full bg-white text-sm text-gray-500 focus:outline-none flex items-center" id="sorting_child">
                    <input type="text" value="{{ $markets[0]->pasar }}" class="focus:outline-none flex-shrink" id="sorting_item_list_input" autocomplete="off">
                    <i class="bi bi-caret-down-fill text-pink-650 text-xs"></i>
                  </div>
                  <ul class="bg-white border border-pink-650 rounded-2xl max-h-60 w-full absolute z-20 top-10 overflow-y-auto hidden" id="sorting_item_list_container">
                    <div class="overflow-hidden w-full h-full border-pink-650 rounded-2xl p-1" id="sorting_item_list_container_injector">
                      @foreach ($markets as $data)
                          <li data-pasar="{{ $data->pasar }}" class="p-2 hover:bg-pink-50 text-sm cursor-pointer sorting_item_list">{{ $data->pasar }}</li>
                      @endforeach
                    </div>
                  </ul>
                </div>
            </div>
        
            {{-- Tanggal (Bulan) --}}
            <div>
                <input type="month" name="periode" id="periode"
                    value="{{ date('Y-m') }}"
                    class="border border-pink-650 px-4 py-2 rounded-full bg-white text-sm text-gray-500 focus:outline-none">
            </div>
        
            {{-- Cari Bahan Pokok --}}
            <div class="relative">
                <i class="bi bi-search absolute left-3 top-1/2 transform -translate-y-1/2 text-pink-650"></i>
                <input type="text" name="search" id="search" placeholder="Cari Bahan Pokok"
                    class="pl-10 pr-4 py-2 border border-pink-650 rounded-full bg-white text-sm text-gray-500 focus:outline-none placeholder-gray-500">
            </div>
        </form>
    </div>

    {{-- Daftar Komoditas --}}
    <div class="w-[90%] max-w-7xl overflow-auto max-h-screen mx-auto rounded-lg" id="comoditiesList">
      <table class="min-w-full border-separate border-spacing-y-1 text-sm text-gray-700">
        <thead class="sticky top-0 z-10 bg-white" id="comoditiesThead">
          <tr class="shadow-pink-hard rounded-3xl bg-white">
            <th class="px-4 py-5 text-center font-semibold rounded-l-3xl">No</th>
            <th class="px-4 py-5 text-center font-semibold whitespace-nowrap">Pasar</th>
            <th class="px-4 py-5 text-center font-semibold whitespace-nowrap">Bahan Pokok</th>
            @for ($i = 1; $i <= 30; $i++)
              <th class="px-4 py-5 text-center font-semibold {{ $i == 30 ? 'rounded-r-full' : '' }}">{{ $i }}</th>
            @endfor
          </tr>
        </thead>
        <tbody id="comoditiesTbody">
          {{-- Pake ajax ntar --}}
        </tbody>
      </table>
    </div>
</x-tamu-layout>

<script src="{{ asset('/js/tamu-statistik.js') }}"></script>