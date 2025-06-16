{{-- @dd($data) --}}
<x-pegawai-layout title="Detail Data Dinas">
    <div class="flex justify-between items-center gap-4 my-4">
        <!-- Search bar -->
        <x-search>Cari bahan pokok...</x-search>
    
        {{-- Filter --}}
        <div class="flex justify-end max-md:w-full">
            <x-filter></x-filter>
    
            <!-- Modal Background -->
            <x-filter-modal>
                <form action="" method="get" class="space-y-4">
                    <!-- Urutan -->
                    <div class="flex flex-col">
                        <label for="pilih_urutan" class="block text-sm font-medium text-gray-700 mb-1">Urutkan</label>
                        <select name="urutkan" class="border border-black p-2 rounded-full bg-white w-full select2" id="pilih_urutan">
                            <option value="asc" {{ old('urutkan') == 'az' ? 'selected' : '' }}>A - Z</option>
                            <option value="desc" {{ old('urutkan') == 'za' ? 'selected' : '' }}>Z - A</option>
                        </select>
                    </div>

                    <!-- Pilih Pasar -->
                    <div class="flex flex-col">
                        <label for="pilih_pasar" class="block text-sm font-medium text-gray-700 mb-1">Pilih Pasar</label>
                        <select name="pasar" class="border border-black p-2 rounded-full bg-white w-full select2" id="pilih_pasar">
                            @foreach ($markets as $market)
                                <option value="{{ $market->nama_pasar }}" {{ old('pasar') == $market->nama_pasar ? 'selected' : '' }}>{{ $market->nama_pasar }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Pilih Periode -->
                    <div class="flex flex-col">
                        <label for="periode" class="block text-sm font-medium text-gray-700 mb-1">Pilih Periode</label>
                        <input type="month" value="{{ date('Y-m') }}" name="periode" id="periode" class="border w-full max-md:w-full p-2 rounded bg-white text-xs">
                    </div>

                    <div class="w-full flex justify-end gap-3 mt-10">
                        <button type="reset" class="bg-yellow-550 text-white rounded-lg w-20 p-1">Reset</button>
                        <button type="button" id="submitBtn" class="bg-pink-650 text-white rounded-lg w-20 p-1">Cari</button>
                    </div>
                </form>
            </x-filter-modal>
        </div>
    </div>
    
    {{-- Main Content --}}
    <main class="flex-1 p-6 max-md:p-4 bg-gray-10 border-gray-20 border-[3px] rounded-[20px]">
    
        <div class="w-full flex items-center gap-2 mb-4 flex-wrap">
            <a href="{{ route('pegawai.disperindag.index') }}" class="text-dark flex-shrink-0">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="4" stroke="currentColor" class="w-6 h-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5L8.25 12l7.5-7.5" />
                </svg>                      
            </a>
            <h3 class="text-lg md:text-2xl font-semibold text-black hidden" id="header_data"><span id="header_pasar"></span> - Bulan <span id="header_periode"></span></h3>
        </div>
    
        <div class="bg-white p-4 md:p-6 rounded shadow-md mt-4">
            <div class="overflow-x-auto">
                <table class="min-w-full text-xs md:text-sm divide-y">
                    <thead class="bg-gray-100" id="comoditiesThead">
                        <tr>
                            <th rowspan="2" class="px-2 py-2 text-center">No</th>
                            <th rowspan="2" class="px-2 py-2 text-center">Aksi</th>
                            <th rowspan="2" class="px-2 py-2 text-center">Jenis Komoditas</th>
                            <th rowspan="2" class="px-2 py-2 text-center">Gambar</th>
                            @for ($i = 1; $i <= 30; $i++)
                                <th class="px-2 py-1 text-center">{{ $i }}</th>
                            @endfor
                        </tr>
                    </thead>
                    <tbody class="divide-y" id="comoditiesTbody">
                        {{-- Pake ajax --}}
                    </tbody>
                </table>
            </div>
    
            {{-- Modal --}}
            <div id="modal" class="fixed inset-0 bg-black bg-opacity-50 hidden justify-center items-center z-40">
                <div class="bg-white p-6 rounded-lg w-[90%] max-w-2xl shadow-lg relative">
                    <h2 class="text-xl font-semibold mb-4">Pilih Data untuk Di<span id="actionPlaceholder"></span></h2>
                    <div id="editDataList" class="space-y-4 max-h-96 overflow-y-auto mb-4">
                        {{-- Diisi pake ajax --}}
                    </div>
                    <div class="text-right" id="closeListModal">
                        <button class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded">Tutup</button>
                    </div>
                </div>
            </div>
            
            {{-- Modal Delete --}}
            <div id="deleteModal" class="hidden w-full h-full">
                <div class="fixed inset-0 bg-black bg-opacity-50 flex justify-center items-center z-40">
                    <div class="bg-white p-6 rounded-lg w-[90%] max-w-sm shadow-lg">
                        <h2 class="text-xl font-semibold mb-6 text-center">Yakin menghapus data?</h2>
                        <div class="flex justify-around">
                            <button class="bg-pink-500 hover:bg-pink-400 text-white px-4 py-2 rounded-full" id="closeBtn">Tutup</button>
                            <button class="bg-pink-500 hover:bg-pink-400 text-white px-4 py-2 rounded-full" id="yesBtn">Yakin</button>
                        </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    
    </main>
     
</x-pegawai-layout>

<script>
const pilih_pasar=$("#pilih_pasar"),periode=$("#periode"),header_pasar=$("#header_pasar"),header_periode=$("#header_periode"),header_data=$("#header_data"),pilih_urutan=$("#pilih_urutan"),modal=$("#modal"),search=$("#search");function toggleModal(){const t=document.getElementById("filterModal");t.classList.toggle("hidden"),t.classList.toggle("flex")}function formatRupiah(t){return null==t||"-"===t?"-":(t=parseInt(t.toString().replace(/\./g,""),10)).toLocaleString("id-ID")}function filter(t){$.ajax({type:"GET",url:t,data:{data:pilih_pasar.val(),periode:periode.val(),sort:pilih_urutan.val()},success:function(t){const a=t.data,e=t.jumlahHari;header_pasar.html(pilih_pasar.val()),header_periode.html(t.bulan),header_data.removeClass("hidden");let n='\n                    <tr>\n                    <th rowspan="2" class="px-2 py-2 text-center">No</th>\n                    <th rowspan="2" class="px-2 py-2 text-center">Aksi</th>\n                    <th rowspan="2" class="px-2 py-2 text-center whitespace-nowrap">Jenis Bahan Pokok</th>\n                ';for(let t=1;t<=e;t++)n+=`<th class="px-2 py-1 text-center">${t}</th>`;n+="</tr>",$("#comoditiesThead").html(n);let s="";if(0===Object.keys(a).length)s=`\n                    <tr class="bg-white">\n                        <td colspan="${3+e}" class="py-5 px-8 bg-pink-50 text-gray-500 italic">\n                        Data tidak ditemukan.\n                        </td>\n                    </tr>\n                    `;else{let t=1;Object.values(a).forEach((a=>{s+=`\n                            <tr class="hover:bg-gray-50">\n                                <td class="px-2 py-2 text-center">${t++}</td>\n                                <td class="px-2 py-2 text-center">\n                                    <div class="flex justify-center gap-1">\n                                        <button class="editBtn bg-yellow-400 text-white rounded-md w-4 h-4 md:w-10 md:h-10 flex items-center justify-center"\n                                            data-bahan-pokok="${a.jenis_bahan_pokok}">\n                                            <i class="bi bi-pencil-square text-xs md:text-base"></i>\n                                        </button>\n                                        <button class="deleteBtn bg-red-500 text-white rounded-md w-4 h-4 md:w-10 md:h-10 flex items-center justify-center"\n                                            data-bahan-pokok="${a.jenis_bahan_pokok}">\n                                            <i class="bi bi-trash-fill text-xs md:text-base"></i>\n                                        </button>\n                                    </div>\n                                </td>\n                                <td class="px-2 py-2 text-center whitespace-nowrap jenis_bahan_pokok_col">${a.jenis_bahan_pokok}</td>\n                        `;for(let t=1;t<=e;t++){let e=a.harga_per_tanggal[t];null!=e&&"-"!==e?(e=parseInt(e.toString().replace(/\./g,""),10),e=e.toLocaleString("id-ID"),e=`Rp. ${e}`):e="-",s+=`<td class="px-2 py-2 text-center whitespace-nowrap">${e}</td>`}s+="</tr>"}))}$("#comoditiesTbody").html(s)},error:function(t,a,e){let n=t.responseJSON.errors,s="";$.each(n,(function(t,a){s+=a+"<br>"})),console.log(s)}})}$("#filterBtn").on("click",(function(){$("#filterModal").toggleClass("hidden")})),$("#submitBtn").on("click",(function(){filter("/api/dpp-filter")})),$("#closeListModal").on("click",(function(){$(this).closest("#modal").removeClass("flex").addClass("hidden")})),$(document).on("click",".editBtn",(function(){modal.removeClass("hidden").addClass("flex"),$("#actionPlaceholder").html("edit");const t=$(this).data("bahan-pokok");$.ajax({type:"GET",url:`/api/dpp/${t}`,data:{periode:periode.val(),pasar:pilih_pasar.val()},success:function(t){const a=t.data;$("#editDataList").empty(),a.forEach((t=>{let a=formatRupiah(t.kg_harga),e=`\n                        <div class="border rounded-md p-4 shadow-sm flex items-center justify-between">\n                            <div>\n                                <p class="text-sm text-gray-500">Jenis Bahan Pokok: <span class="font-medium">${t.nama_bahan_pokok}</span></p>\n                                <p class="text-sm text-gray-500">Pasar: <span class="font-medium">${t.nama_pasar}</span></p>\n                                <p class="text-sm text-gray-500">Tanggal: <span class="font-medium">${t.tanggal_dibuat}</span></p>\n                                <p class="text-sm text-gray-500">Harga: <span class="font-medium">Rp. ${a}</span></p>\n                            </div>\n                            <a href="/pegawai/disperindag/data/${t.id}/edit" class="bg-yellow-500 text-white px-3 py-1 rounded text-sm hover:bg-yellow-600">Ubah</a>\n                        </div>\n                    `;$("#editDataList").append(e)}))},error:function(t){console.log(t.responseText)}})})),$(document).on("click",".deleteBtn",(function(){$("#modal").removeClass("hidden").addClass("flex"),$("#actionPlaceholder").html("hapus");const t=$(this).data("bahan-pokok");$.ajax({type:"GET",url:`/api/dpp/${t}`,data:{periode:periode.val(),pasar:pilih_pasar.val()},success:function(t){const a=t.data;$("#editDataList").empty(),a.forEach((t=>{let a=formatRupiah(t.kg_harga),e=`\n                        <div class="border rounded-md p-4 shadow-sm flex items-center justify-between">\n                            <div>\n                                <p class="text-sm text-gray-500">Jenis Bahan Pokok: <span class="font-medium">${t.nama_bahan_pokok}</span></p>\n                                <p class="text-sm text-gray-500">Pasar: <span class="font-medium">${t.nama_pasar}</span></p>\n                                <p class="text-sm text-gray-500">Tanggal: <span class="font-medium">${t.tanggal_dibuat}</span></p>\n                                <p class="text-sm text-gray-500">Harga: <span class="font-medium">Rp. ${a}</span></p>\n                            </div>\n                            <button data-id="${t.id}" class="btnConfirm bg-red-500 text-white px-3 py-1 rounded text-sm hover:bg-red-600">Hapus</button>\n                        </div>\n                    `;$("#editDataList").append(e)}))},error:function(t){console.log(t.responseText)}})})),$(document).on("click",".btnConfirm",(function(){let t=$(this).data("id");$("#deleteModal").show(),$("#yesBtn").off("click").on("click",(function(){$.ajax({type:"DELETE",url:`/api/dpp/${t}`,success:function(t){console.log(t),Swal.fire({title:"Berhasil!",text:`Data ${t.data.nama_bahan_pokok} telah dihapus.`,icon:"success",confirmButtonText:"OK"}).then((()=>{location.reload()}))},error:function(t,a,e){Swal.fire({icon:"error",title:"Oops...",html:e})}}),$("#deleteModal").hide()}))})),$(document).on("click","#closeBtn",(function(){$("#deleteModal").hide()})),filter("/api/dpp-filter"),search.on("input",(function(){const t=$(this).val().toLowerCase();$(".jenis_bahan_pokok_col").each((function(){$(this).text().toLowerCase().includes(t)?$(this).parent().removeClass("hidden"):$(this).parent().addClass("hidden")}))}));
</script>
