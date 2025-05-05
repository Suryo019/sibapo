{{-- @dd($data) --}}

<x-tamu-layout>
    <x-tamu-header></x-tamu-header>

    {{-- Body --}}
    <div class="mx-32 my-20">
        <h1 class="text-5xl font-extrabold">Harga rata-rata bahan pokok hari ini di Jember</h1>
        <h5 class="text-slate-600 mt-5 mb-7">Harga dibandingkan dengan hari sebelumnya <b>{{ $kemarin }}</b></h5>

        {{-- Daftar Komoditas --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-3 gap-6 justify-items-center">
            @foreach ($data as $item)
            <div class="bg-white rounded-3xl shadow-md overflow-hidden border h-72 w-72 py-3 px-1">
                <div class="h-[50%] flex justify-center">
                    @if ($item['gambar_komoditas'])
                        <img src="{{ asset('storage/' . $item['gambar_komoditas']) }}" alt="komoditas" class="object-cover">
                    @else
                        <img src="{{ asset('storage/img/landscape-placeholder.svg') }}" alt="komoditas" class="object-cover">
                    @endif
                </div>
                <div class="p-4 h-[50%]">
                    <p class="text-gray-600">{{ $item['komoditas'] }}</p>
                    <h3 class="text-2xl font-extrabold mb-4">Rp. {{ $item['rata_rata_hari_ini'] }}/kg</h3>
                    @if ($item['status'] == 'Stabil')
                        <span class="flex justify-center items-center bg-blue-200 w-full rounded-full p-2 text-blue-600 font-extrabold gap-3">
                            <i class="bi bi-circle font-extrabold"></i>
                            {{ $item['status'] }} Rp. {{ $item['selisih'] }}
                        </span>
                    @elseif ($item['status'] == 'Naik')
                        <span class="flex justify-center items-center bg-green-200 w-full rounded-full p-2 text-green-600 font-extrabold gap-3">
                            <i class="bi bi-arrow-up font-extrabold"></i>
                            {{ $item['status'] }} Rp. {{ $item['selisih'] }}
                        </span>
                    @elseif ($item['status'] == 'Turun')
                        <span class="flex justify-center items-center bg-red-200 w-full rounded-full p-2 text-red-600 font-extrabold gap-3">
                            <i class="bi bi-arrow-down font-extrabold"></i>
                            {{ $item['status'] }} Rp. {{ $item['selisih'] }}
                        </span>
                    @else
                        <span class="flex justify-center items-center bg-slate-200 w-full rounded-full p-2 text-slate-600 font-extrabold gap-3">
                            {{ $item['status'] }}
                        </span>
                    @endif
                </div>
            </div>
            @endforeach
        </div>
    </div>
</x-tamu-layout>