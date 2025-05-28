{{-- @dd($data) --}}

<x-tamu-layout>
    <x-tamu-header></x-tamu-header>

    {{-- Body --}}
    <div class="relative my-20 px-4 sm:px-8 md:px-16 lg:mx-32 lg:px-0 text-center lg:text-left">
        <h1 class="text-2xl sm:text-3xl md:text-4xl lg:text-5xl font-extrabold leading-tight">
            <span class="block sm:hidden">
                Harga rata-rata<br>
                komoditas hari ini di Jember
            </span>
            <span class="hidden sm:inline">
                Harga rata-rata bahan pokok hari ini di Jember
            </span>
        </h1>
        <h5 class="text-sm sm:text-base text-slate-600 mt-3 sm:mt-5 mb-5 sm:mb-7">
            Harga dibandingkan dengan hari sebelumnya <b>{{ $kemarin }}</b>
        </h5>

        {{-- Daftar Komoditas --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 2xl:grid-cols-4 gap-6 justify-items-center">
            @foreach ($data as $item)
            <div class="bg-white rounded-3xl shadow-md overflow-hidden border py-3 px-2 w-[90%] sm:w-64 md:w-72 lg:w-80 xl:w-72 h-auto">
                <div class="h-[40vw] sm:h-40 md:h-44 lg:h-48 flex justify-center items-center overflow-hidden">
                    @if ($item['gambar_komoditas'])
                        <img src="{{ asset('storage/' . $item['gambar_komoditas']) }}" alt="komoditas" class="object-cover w-full h-full">
                    @else
                        <img src="{{ asset('storage/img/landscape-placeholder.svg') }}" alt="komoditas" class="object-cover w-full h-full">
                    @endif
                </div>
                <div class="p-3">
                    <p class="text-gray-600 text-sm md:text-base">{{ $item['komoditas'] }}</p>
                    <h3 class="text-lg md:text-xl lg:text-2xl font-extrabold mb-2">Rp. {{ $item['rata_rata_hari_ini'] }}/kg</h3>
                    @php
                        $statusClass = match($item['status']) {
                            'Naik' => 'bg-green-200 text-green-600',
                            'Turun' => 'bg-red-200 text-red-600',
                            'Stabil' => 'bg-blue-200 text-blue-600',
                            default => 'bg-slate-200 text-slate-600',
                        };
                        $icon = match($item['status']) {
                            'Naik' => 'bi-arrow-up',
                            'Turun' => 'bi-arrow-down',
                            'Stabil' => 'bi-circle',
                            default => '',
                        };
                    @endphp
                    <span class="flex justify-center items-center {{ $statusClass }} w-full rounded-full p-2 font-semibold text-sm md:text-base gap-2">
                        @if ($icon)
                            <i class="bi {{ $icon }}"></i>
                        @endif
                        {{ $item['status'] }} @if($item['selisih']) Rp. {{ $item['selisih'] }} @endif
                    </span>
                </div>
            </div>
            @endforeach
        </div>

    </div>
</x-tamu-layout>