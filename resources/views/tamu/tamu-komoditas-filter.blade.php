<x-tamu-layout title="Bahan Pokok">
    <div class="w-full py-16 px-6 md:px-0 flex flex-col justify-center items-center text-pink-650">
        <h1 class="text-3xl md:text-5xl font-extrabold mb-6 text-center">Harga Bahan Pokok</h1>
        <h5 class="text-md md:text-xl text-shadow mb-5 text-center">
            Harga rata-rata dibandingkan dengan hari sebelumnya <b>{{ $kemarin }}</b>
        </h5>
        <form action="{{ route('tamu.komoditas') }}">
            @csrf
            <div class="w-full sm:w-auto relative z-20">
                <div class="w-full relative max-w-md bg-yellow-450 flex justify-between items-center pl-6 pr-3 py-1 rounded-full" id="sorting_child">
                    <span class="bi bi-search mr-5"></span>
                    <input type="text" 
                        placeholder="Cari Bahan Pokok" 
                        id="jenis_bahan_pokok" 
                        name="jenis_bahan_pokok"
                        autocomplete="off"
                        class="border-none outline-none focus:bg-transparent text-pink-650 placeholder-pink-650 bg-transparent flex-1">
                    <button type="button" class="bg-pink-650 rounded-full py-2 w-24 text-white" id="submitBtn">Cari</button>
                </div>
                <ul class="bg-white border border-pink-650 rounded-2xl max-h-60 w-full absolute z-20 top-14 overflow-y-auto hidden" id="sorting_item_list_container">
                    <div class="overflow-hidden w-full h-full border-pink-650 rounded-2xl p-1"
                        id="sorting_item_list_container_injector">
                        @foreach ($bahan_pokok as $single_bahan_pokok)
                            <li data-jenis_bahan_pokok="{{ $single_bahan_pokok->nama_bahan_pokok }}"
                                class="p-2 hover:bg-pink-50 text-sm cursor-pointer sorting_item_list">
                                {{ $single_bahan_pokok->nama_bahan_pokok }}
                            </li>
                        @endforeach
                    </div>
                </ul>
            </div>
        </form>
    </div>

    {{-- Daftar Komoditas --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6 justify-items-center mx-32" id="comoditiesList">
        {{-- DIisi pake ajax --}}
    </div>
</x-tamu-layout>

<script>
    const itemListInput=$("#jenis_bahan_pokok"),itemListContainer=$("#sorting_item_list_container"),itemListInjector=$("#sorting_item_list_container_injector");function capitalize(t){return t.split(" ").map((t=>t.charAt(0).toUpperCase()+t.slice(1).toLowerCase())).join(" ")}function loadKomoditas(){$.ajax({type:"GET",url:"{{ route('api.komoditas') }}",data:{jenis_bahan_pokok:$("#jenis_bahan_pokok").val()},success:function(t){let e=t.data;$("#comoditiesList").empty(),0===e.length?$("#comoditiesList").html('\n                    <div class="flex flex-col items-center justify-center col-span-full px-28 py-10 text-center text-gray-500 border-4 rounded-xl border-gray-400" id="noDataMessage">\n                        <div class="text-4xl mb-6">\n                            <i class="bi bi-exclamation-circle"></i>\n                        </div>\n                        <h3 class="text-2xl font-semibold mb-2">Data Tidak Ditemukan</h3>\n                        <p class="text-sm">Saat ini tidak ada komoditas yang tersedia.</p>\n                    </div>\n                '):$.each(e,(function(t,e){let n="";const a=Number(e.selisih).toLocaleString("id-ID");n="Stabil"===e.status?`\n                            <span class="flex justify-center items-center bg-blue-200 w-full rounded-full p-2 text-blue-600 font-extrabold gap-3">\n                                <i class="bi bi-circle font-extrabold"></i>\n                                ${e.status} Rp. ${a}\n                            </span>`:"Naik"===e.status?`\n                            <span class="flex justify-center items-center bg-green-200 w-full rounded-full p-2 text-green-600 font-extrabold gap-3">\n                                <i class="bi bi-arrow-up font-extrabold"></i>\n                                ${e.status} Rp. ${a}\n                            </span>`:"Turun"===e.status?`\n                            <span class="flex justify-center items-center bg-red-200 w-full rounded-full p-2 text-red-600 font-extrabold gap-3">\n                                <i class="bi bi-arrow-down font-extrabold"></i>\n                                ${e.status} Rp. ${a}\n                            </span>`:`\n                            <span class="flex justify-center items-center bg-slate-200 w-full rounded-full p-2 text-slate-600 font-extrabold gap-3">\n                                ${e.status}\n                            </span>`;const s=Number(e.rata_rata_hari_ini).toLocaleString("id-ID");let i=`\n                        <div class="bg-white rounded-3xl shadow-md overflow-hidden border h-auto w-72 py-3 px-1">\n                            <div class="h-[40vw] sm:h-40 md:h-44 lg:h-48 flex justify-center items-center overflow-hidden">\n                                <img src="${e.gambar_komoditas?"/storage/"+e.gambar_komoditas:"/storage/img/landscape-placeholder.svg"}" alt="komoditas" class="object-cover ${e.gambar_komoditas?"":"w-full h-full"}">\n                            </div>\n                            <div class="p-4 flex flex-col items-center gap-1">\n                                <p class="text-gray-600">${e.komoditas}</p>\n                                <h3 class="text-2xl font-extrabold">Rp. ${s}/kg</h3>\n                                <p class="text-lg mb-3">${e.pasar}</p>\n                                ${n}\n                            </div>\n                        </div>\n                    `;$("#comoditiesList").append(i)}))},error:function(t){let e=t.responseJSON.errors,n="";$.each(e,(function(t,e){n+=e+"<br>"})),Swal.fire({icon:"error",title:"Oops...",html:n})}})}$(document).on("click",".sorting_item_list",(function(){const t=$(this).data("jenis_bahan_pokok");itemListInput.val(t),itemListContainer.addClass("hidden")})),$("#jenis_bahan_pokok").on("click",(function(){itemListContainer.toggleClass("hidden")})),$("#jenis_bahan_pokok").keypress((function(t){13===t.which&&(t.preventDefault(),loadKomoditas())})),$("#submitBtn").on("click",(function(){loadKomoditas()}));
</script>
