{{-- @dd($data) --}}

<x-tamu-layout>
    <x-tamu-header></x-tamu-header>

    {{-- Body --}}
    <div class="relative my-20 px-4 sm:px-8 md:px-16 lg:mx-32 lg:px-0 text-center lg:text-left bg-gradient-to-r from-pink-100 to-white lg:bg-none">
        <h1 class="text-2xl sm:text-3xl md:text-4xl lg:text-5xl font-extrabold leading-tight">
            <span class="block sm:hidden">
                Harga rata-rata<br>
                komoditas hari ini di Jember
            </span>
            <span class="hidden sm:inline">
                Harga rata-rata komoditas hari ini di Jember
            </span>
        </h1>
        <h5 class="text-sm sm:text-base text-slate-600 mt-3 sm:mt-5 mb-5 sm:mb-7">
            Harga dibandingkan dengan hari sebelumnya <b>{{ $kemarin }}</b>
        </h5>

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