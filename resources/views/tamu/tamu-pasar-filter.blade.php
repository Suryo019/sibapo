<x-tamu-layout title="Pasar">
    <div class="w-full py-16 px-6 md:px-0 flex flex-col justify-center items-center text-pink-650">
        <h1 class="text-3xl md:text-5xl font-extrabold mb-6 text-center">Harga Pangan <span id="namaPasar"></span></h1>
        <h5 class="text-md md:text-xl text-shadow mb-5 text-center">Harga rata-rata dibandingkan dengan hari sebelumnya <b>{{ $kemarin }}</b></h5>
        <form action="{{ route('tamu.pasar.search') }}" class="w-full flex justify-center">
            @csrf
            <div class="w-full max-w-md bg-yellow-450 flex justify-between items-center pl-6 pr-3 py-1 rounded-full">
                <span class="bi bi-search mr-5"></span>
                <input
                    type="text"
                    placeholder="Cari Pasar"
                    id="pasar"
                    name="pasar"
                    class="border-none outline-none focus:bg-transparent text-pink-650 placeholder-pink-650 bg-transparent flex-1">
                <button type="button" class="bg-pink-650 rounded-full py-2 w-24 text-white" id="submitBtn">Cari</button>
            </div>
        </form>
    </div>
    {{-- Daftar Komoditas per Pasar --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6 justify-items-center px-6 md:mx-32" id="comoditiesList">
        {{-- Diisi pakai AJAX --}}
    </div>
</x-tamu-layout>

<script>
function capitalize(t){return t.split(" ").map((t=>t.charAt(0).toUpperCase()+t.slice(1).toLowerCase())).join(" ")}function loadKomoditas(){$.ajax({type:"GET",url:"{{ route('api.pasar.search') }}",data:{pasar:$("#pasar").val()},success:function(t){console.log(t);let e=t.data,a=t.inputPasar;$("#comoditiesList").empty(),0===e.length?$("#comoditiesList").html('\n                        <div class="flex flex-col items-center justify-center col-span-full px-28 py-10 text-center text-gray-500 border-4 rounded-xl border-gray-400" id="noDataMessage">\n                            <div class="text-4xl mb-6 ">\n                                <i class="bi bi-exclamation-circle"></i>\n                            </div>\n                            <h3 class="text-2xl font-semibold mb-2">Data Tidak Ditemukan</h3>\n                            <p class="text-sm">Tidak ada pasar yang tersedia.</p>\n                        </div>\n                    '):($("#namaPasar").html(`di ${capitalize(a)}`),$.each(e,(function(t,e){let a="";const s=Number(e.rata_rata_hari_ini).toLocaleString("id-ID"),n=Number(e.selisih).toLocaleString("id-ID");a="Stabil"==e.status?`\n                                <span class="flex justify-center items-center bg-blue-200 w-full rounded-full p-2 text-blue-600 font-extrabold gap-3">\n                                    <i class="bi bi-circle font-extrabold"></i>\n                                    ${e.status} Rp. ${n}\n                                </span>`:"Naik"==e.status?`\n                                <span class="flex justify-center items-center bg-green-200 w-full rounded-full p-2 text-green-600 font-extrabold gap-3">\n                                    <i class="bi bi-arrow-up font-extrabold"></i>\n                                    ${e.status} Rp. ${n}\n                                </span>`:"Turun"==e.status?`\n                                <span class="flex justify-center items-center bg-red-200 w-full rounded-full p-2 text-red-600 font-extrabold gap-3">\n                                    <i class="bi bi-arrow-down font-extrabold"></i>\n                                    ${e.status} Rp. ${n}\n                                </span>`:`\n                                <span class="flex justify-center items-center bg-slate-200 w-full rounded-full p-2 text-slate-600 font-extrabold gap-3">\n                                    ${e.status}\n                                </span>`;let l=`\n                            <div class="bg-white rounded-3xl shadow-md overflow-hidden border h-auto w-72 py-3 px-1">\n                                <div class="h-[40vw] sm:h-40 md:h-44 lg:h-48 flex justify-center items-center overflow-hidden">\n                                    <img src="${e.gambar_komoditas?"/storage/"+e.gambar_komoditas:"/storage/img/landscape-placeholder.svg"}" alt="komoditas" class="object-cover ${e.gambar_komoditas?"":"w-full h-full"}">\n                                </div>\n                                <div class="p-4 flex flex-col items-center gap-1">\n                                    <p class="text-gray-600">${e.komoditas}</p>\n                                    <h3 class="text-2xl font-extrabold">Rp. ${s}/kg</h3>\n                                    <p class="text-lg mb-3">${e.pasar}</p>\n                                    ${a}\n                                </div>\n                            </div>`;$("#comoditiesList").append(l)})))},error:function(t){let e=t.responseJSON.errors,a="";$.each(e,(function(t,e){a+=e+"<br>"})),Swal.fire({icon:"error",title:"Oops...",html:a})}})}$("#pasar").keypress((function(t){13===t.which&&(t.preventDefault(),loadKomoditas())})),$("#submitBtn").on("click",(function(){loadKomoditas()}));
</script>
