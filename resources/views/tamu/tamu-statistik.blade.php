<x-tamu-layout title="Statistik">
<div class="w-full flex flex-col justify-center items-center text-pink-650 mb-16 px-4">
    <h1 class="text-3xl sm:text-5xl font-extrabold mb-4 sm:mb-8 text-center">Statistik Harga</h1>
    <h5 class="text-base sm:text-xl text-shadow mb-8 sm:mb-16 mx-4 text-center">
        Data perubahan harga setiap bahan pokok dalam 1 bulan
    </h5>

    {{-- Filter Form --}}
    <form action="{{ route('tamu.komoditas') }}" method="GET"
        class="w-full max-w-5xl flex flex-col sm:flex-row flex-wrap gap-4 sm:gap-6 items-center justify-center">
        @csrf

        {{-- Sorting Root --}}
        <div class="w-full sm:w-auto">
            <select name="sorting_category" id="sorting_category"
                class="w-full border border-pink-650 px-4 py-2 rounded-full bg-white text-sm text-gray-500 focus:outline-none">
                <option value="pasar">Per Pasar</option>
                <option value="jenis_bahan_pokok">Per Bahan Pokok</option>
            </select>
        </div>

        {{-- Sorting Child --}}
        <div class="w-full sm:w-auto relative">
            <div
                class="w-full border border-pink-650 px-4 py-2 rounded-full bg-white text-sm text-gray-500 flex items-center cursor-pointer"
                id="sorting_child">
                <input type="text" value="{{ $markets[0]->nama_pasar }}"
                    class="focus:outline-none flex-shrink bg-transparent w-full" id="sorting_item_list_input" name="market"
                    autocomplete="off" readonly>
                <i class="bi bi-caret-down-fill text-pink-650 text-xs ml-2"></i>
            </div>
            <ul class="bg-white border border-pink-650 rounded-2xl max-h-60 w-full absolute z-20 top-12 overflow-y-auto hidden"
                id="sorting_item_list_container">
                <div class="overflow-hidden w-full h-full border-pink-650 rounded-2xl p-1"
                    id="sorting_item_list_container_injector">
                    @foreach ($markets as $data)
                        <li data-pasar="{{ $data->nama_pasar }}"
                            class="p-2 hover:bg-pink-50 text-sm cursor-pointer sorting_item_list">
                            {{ $data->nama_pasar }}
                        </li>
                    @endforeach
                </div>
            </ul>
        </div>

        {{-- Periode --}}
        <div class="w-full sm:w-auto">
            <input type="month" name="periode" id="periode" value="{{ date('Y-m') }}"
                class="w-full border border-pink-650 px-4 py-2 rounded-full bg-white text-sm text-gray-500 focus:outline-none">
        </div>

        {{-- Search --}}
        <div class="w-full sm:w-auto relative">
            <i class="bi bi-search absolute left-3 top-1/2 transform -translate-y-1/2 text-pink-650"></i>
            <input type="text" name="search" id="search" placeholder="Cari Bahan Pokok"
                class="pl-10 pr-4 py-2 w-full border border-pink-650 rounded-full bg-white text-sm text-gray-500 focus:outline-none placeholder-gray-500">
        </div>
    </form>
</div>


{{-- Tabel Komoditas --}}
<div class="w-[90%] max-w-7xl overflow-auto max-h-screen mx-auto rounded-lg" id="comoditiesList">
    <table class="min-w-full border-separate border-spacing-y-1 text-sm text-gray-700">
        <thead class="sticky top-0 z-10 bg-white" id="comoditiesThead">
            <tr class="shadow-pink-hard rounded-3xl bg-white">
                <th class="px-4 py-5 text-center font-semibold rounded-l-3xl">No</th>
                <th class="px-4 py-5 text-center font-semibold whitespace-nowrap">Pasar</th>
                <th class="px-4 py-5 text-center font-semibold whitespace-nowrap">Bahan Pokok</th>
                @for ($i = 1; $i <= 30; $i++)
                    <th
                        class="px-4 py-5 text-center font-semibold {{ $i == 30 ? 'rounded-r-full' : '' }}">
                        {{ $i }}
                    </th>
                @endfor
            </tr>
        </thead>
        <tbody id="comoditiesTbody">
            {{-- pake ajax ntar --}}
        </tbody>
    </table>
</div>
</x-tamu-layout>

<script>
$(document).ready((function(){const t=$("#sorting_category"),a=$("#sorting_item_list_container"),n=$("#sorting_item_list_container_injector"),e=$("#sorting_item_list_input"),s=$("#periode"),o=$("#search");function i(t,n){a.addClass("hidden"),$.ajax({type:"GET",url:t,data:{data:n,periode:s.val()},success:function(t){const a=t.data,n=t.jumlahHari;let e='\n            <tr class="shadow-pink-hard rounded-3xl bg-white">\n              <th class="px-4 py-5 text-center font-semibold rounded-l-3xl">No</th>\n              <th class="px-4 py-5 text-center font-semibold whitespace-nowrap">Pasar</th>\n              <th class="px-4 py-5 text-center font-semibold whitespace-nowrap">Bahan Pokok</th>\n          ';for(let t=1;t<=n;t++){e+=`<th class="px-4 py-5 text-center font-semibold ${t===n?"rounded-r-full":""}">${t}</th>`}e+="</tr>",$("#comoditiesThead").html(e);let s="";if(0===Object.keys(a).length)s=`\n              <tr class="bg-white">\n                <td colspan="${3+n}" class="py-5 px-8 bg-pink-50 text-gray-500 italic">\n                  Data tidak ditemukan.\n                </td>\n              </tr>\n            `;else{let t=1;Object.values(a).forEach((a=>{s+=`\n                <tr class="bg-white hover:bg-pink-50 rounded-full shadow-pink-hard transition duration-150">\n                  <td class="px-4 py-3 text-center rounded-l-full">${t++}</td>\n                  <td class="px-4 py-3 text-center whitespace-nowrap">${a.pasar}</td>\n                  <td class="px-4 py-3 text-center whitespace-nowrap jenis_bahan_pokok_col">${a.jenis_bahan_pokok}</td>\n              `;for(let t=1;t<=n;t++){const e=a.harga_per_tanggal[t],o=e?parseInt(e).toLocaleString("id-ID"):"-";s+=`<td class="px-4 py-3 text-center ${t===n?"rounded-r-full":""} whitespace-nowrap">Rp. ${o}</td>`}s+="</tr>"}))}$("#comoditiesTbody").html(s)},error:function(t,a,n){let e=t.responseJSON.errors,s="";$.each(e,(function(t,a){s+=a+"<br>"})),console.log(s)}})}t.on("change",(function(){const t=$(this).val();$.ajax({type:"GET",url:"/api/sorting_items",data:{data:t},success:function(a){const s=a.data;let o="",r="";"pasar"==t?($.each(s,(function(t,a){o+=`\n                <li data-pasar="${a.nama_pasar}" class="p-2 hover:bg-pink-50 text-sm cursor-pointer sorting_item_list">${a.nama_pasar}</li>\n              `})),e.val(s[0].nama_pasar),r="/api/statistik_pasar"):"jenis_bahan_pokok"==t&&($.each(s,(function(t,a){o+=`\n                <li data-jenis_bahan_pokok="${a.nama_bahan_pokok}" class="p-2 hover:bg-pink-50 text-sm cursor-pointer sorting_item_list">${a.nama_bahan_pokok}</li>\n              `})),e.val(s[0].nama_bahan_pokok),r="/api/statistik_jenis_bahan_pokok"),n.html(o),i(r,e.val())},error:function(t,a,n){let e=t.responseJSON.errors,s="";$.each(e,(function(t,a){s+=a+"<br>"})),console.log(s)}})})),$("#sorting_child").on("click",(function(){a.toggleClass("hidden")})),e.on("input",(function(){a.removeClass("hidden");const t=$(this).val().toLowerCase();n.find("li").each((function(){$(this).text().toLowerCase().includes(t)?$(this).removeClass("hidden"):$(this).addClass("hidden")}))})),i("/api/statistik_pasar",e.val()),$("#periode").on("change",(function(){const a=e.val();"pasar"==t.val()?i("/api/statistik_pasar",a):"jenis_bahan_pokok"==t.val()&&i("/api/statistik_jenis_bahan_pokok",a)})),$(document).on("click",".sorting_item_list",(function(){if("pasar"==t.val()){const t=$(this).data("pasar");e.val(t),i("/api/statistik_pasar",t)}else if("jenis_bahan_pokok"==t.val()){const t=$(this).data("jenis_bahan_pokok");e.val(t),i("/api/statistik_jenis_bahan_pokok",t)}})),o.on("input",(function(){const t=$(this).val().toLowerCase();$(".jenis_bahan_pokok_col").each((function(){$(this).text().toLowerCase().includes(t)?$(this).parent().removeClass("hidden"):$(this).parent().addClass("hidden")}))}))})),document.addEventListener("DOMContentLoaded",(()=>{const t=document.getElementById("mobileFilterBtn"),a=document.getElementById("mobileFilterDropdown"),n=document.getElementById("closeFilterDropdown");t.addEventListener("click",(()=>{a.classList.toggle("hidden")})),n.addEventListener("click",(()=>{a.classList.add("hidden")}))}));
</script>