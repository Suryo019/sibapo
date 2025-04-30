<x-tamu-layout>
    <div class="w-full h-96 flex flex-col justify-center items-center text-pink-650 ">
        <h1 class="text-5xl font-extrabold mb-10">Harga Pangan <span id="namaPasar"></span></h1>
        <h5 class="text-xl text-shadow mb-7">Harga rata-rata dibandingkan dengan hari sebelumnya <b>{{ $kemarin }}</b></h5>
        <form action="{{ route('tamu.komoditas') }}">
            @csrf
            <div class="w-96 bg-yellow-450 flex justify-between items-center pl-6 pr-3 py-1 rounded-full">
                <span class="bi bi-search mr-5"></span>
                <input type="text" placeholder="Cari Pasar" id="jenis_bahan_pokok" name="jenis_bahan_pokok" class="border-none outline-none focus:bg-transparent text-pink-650 placeholder-pink-650 bg-transparent flex-1">
                <button type="button" class="bg-pink-650 rounded-full py-2 w-24 text-white" id="submitBtn">Cari</button>
            </div>
        </form>
    </div>

    {{-- Daftar Komoditas --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-3 gap-6 justify-items-center" id="comoditiesList">
        {{-- DIisi pake ajax --}}
    </div>
</x-tamu-layout>
