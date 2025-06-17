<x-admin-layout>
    
    <!-- Search dan Dropdown -->
    <div class="flex items-center justify-between gap-4 mb-6">
        <!-- Search Component -->
        <x-search>
            Cari ikan...
        </x-search>
        
        {{-- Filter --}}
    <div class="flex justify-end">
        <div class="relative flex justify-end">
            <x-filter></x-filter>

            <!-- Modal Background -->
            <x-filter-modal>
                <form action="{{ route('perikanan.detail') }}" method="get">
                    <div class="space-y-4">
                        <!-- Pilih urutan -->
                        <div class="flex flex-col">
                            <label for="pilih_urutan" class="block text-sm font-medium text-gray-700 mb-1">Pilih Urutan</label>
                            <select name="order" class="w-full border border-gray-300 p-2 rounded-lg bg-white shadow-sm focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-colors">
                                <option value="asc" {{ request('order') == 'asc' ? 'selected' : '' }}>A - Z</option>
                                <option value="desc" {{ request('order') == 'desc' ? 'selected' : '' }}>Z - A</option>
                            </select>
                        </div>
                
                        <!-- Pilih periode -->
                        <div class="flex flex-col">
                            <label for="pilih_periode" class="block text-sm font-medium text-gray-700 mb-1">Pilih Periode</label>
                            <input type="month" value="{{ $_GET['periode'] ?? date('Y-m') }}" name="periode" id="periode" class="w-full border border-gray-300 p-2 rounded-lg bg-white shadow-sm focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-colors">
                        </div>
                    </div>
                
                    <div class="w-full flex justify-end gap-3 mt-10">
                        <a href="{{ route('perikanan.detail') }}" class="bg-yellow-550 text-white rounded-lg w-20 p-1 text-center">Reset</a>
                        <button type="submit" class="bg-pink-650 text-white rounded-lg w-20 p-1">Cari</button>
                    </div>
                </form>
            </x-filter-modal> 
        </div> 
      </div> 
    </div>


    <main class="flex-1 p-6 max-md:p-4 bg-gray-10 border-gray-20 border-[3px] rounded-[20px]">
        <div class="w-full flex items-center gap-2 mb-4">
            <a href="{{ route('perikanan.index') }}" class="text-decoration-none text-dark flex-shrink-0">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="4" stroke="currentColor" class="w-6 h-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5L8.25 12l7.5-7.5" />
                </svg>                      
            </a>
            <h2 class="text-2xl font-semibold">
                DATA VOLUME PRODUKSI IKAN TAHUN {{ isset($_GET['periode']) ? date('Y', strtotime($_GET['periode'] . '-01')) : date('Y') }}
            </h2>
        </div>        

        <div class="bg-white p-4 sm:p-6 rounded-lg shadow-md mt-4 border bg-gray-10 border-gray-20">

            <!-- Tabel Responsif -->
            @if (isset($data))
            <div class="overflow-x-auto">
                <table class="min-w-full  border-gray-300">
                    <thead class="">
                        <tr>
                            <th class=" px-4 py-2 whitespace-nowrap">Jenis Ikan</th>
                            @php
                                $namaBulan = [
                                    1 => 'Jan', 2 => 'Feb', 3 => 'Mar', 4 => 'Apr',
                                    5 => 'Mei', 6 => 'Jun', 7 => 'Jul', 8 => 'Agu',
                                    9 => 'Sep', 10 => 'Okt', 11 => 'Nov', 12 => 'Des'
                                ];
                            @endphp
                            @foreach ($namaBulan as $bulan)
                                <th class=" px-2 py-2 text-center whitespace-nowrap">{{ $bulan }}</th>
                            @endforeach
                            <th class=" px-4 py-2">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($data as $item)
                                <td class="border-b px-4 py-2 text-center">{{ $item['nama_ikan'] }}</td>

                            @for ($bulan = 1; $bulan <= 12; $bulan++)
                                <td class="border-b px-2 py-2 text-center whitespace-nowrap">
                                    @if (isset($item['produksi_per_bulan'][$bulan]))
                                        {{ number_format($item['produksi_per_bulan'][$bulan], 0, ',', '.') }}
                                    @else
                                        -
                                    @endif
                                </td>
                            @endfor

                                <td class="border-b px-4 py-2">
                                    <div class="flex justify-center gap-2">
                                        <button class="editBtn bg-yellow-400 hover:bg-yellow-500 text-white rounded-md w-10 h-10 flex items-center justify-center transition-colors"
                                            data-ikan="{{ $item['nama_ikan'] }}">
                                            <i class="bi bi-pencil-square"></i>
                                        </button>
                                    
                                        <button class="deleteBtn bg-red-500 hover:bg-red-600 text-white rounded-md w-10 h-10 flex items-center justify-center transition-colors" 
                                            data-ikan="{{ $item['nama_ikan'] }}">
                                            <i class="bi bi-trash-fill"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                {{-- Modal --}}
                <div id="modal" class="fixed inset-0 bg-black bg-opacity-50 hidden justify-center items-center z-40">
                    <div class="bg-white p-6 rounded-lg w-[90%] max-w-2xl shadow-lg relative">
                        <h2 class="text-xl font-semibold mb-4">Pilih Data untuk Di<span id="actionPlaceholder"></span></h2>
                        <div id="editDataList" class="space-y-4 max-h-96 overflow-y-auto mb-4"></div>
                        <div class="text-right" id="closeListModal">
                            <button class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded">Tutup</button>
                        </div>
                    </div>
                </div>
                
                {{-- Modal Delete --}}
                <div id="deleteModal" class="hidden w-full h-full">
                    <div class="fixed inset-0 bg-black bg-opacity-50 flex justify-center items-center z-40">
                        <div class="bg-white p-6 rounded-lg w-[25%] max-w-2xl shadow-lg relative">
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

            @else
            <div class="flex items-center justify-center h-64">
                <div class="text-center p-4 border-2 border-dashed border-gray-300 rounded-lg shadow-md bg-gray-50">
                    <h3 class="text-lg font-semibold text-gray-500">Data Tidak Ditemukan</h3>
                    <p class="text-gray-400">Tidak ada data yang sesuai dengan kriteria pencarian.</p>
                </div>
            </div>
            @endif
    </main>
</x-admin-layout>

<script>
const periode=$("#periode");function toggleModal(){const t=document.getElementById("filterModal");t.classList.toggle("hidden"),t.classList.toggle("flex")}$("#filterBtn").on("click",(function(){$("#filterModal").toggleClass("hidden")})),$("#closeListModal").on("click",(function(){$(this).closest("#modal").removeClass("flex").addClass("hidden")})),$("#closeBtn").on("click",(function(){$(this).closest("#modal").removeClass("flex").addClass("hidden")})),$(".editBtn").on("click",(function(){$("#modal").removeClass("hidden").addClass("flex");const t=$(this).data("ikan");$.ajax({type:"GET",url:`/api/dp/${t}`,data:{periode:periode.val()},success:function(t){const e=t.data;$("#editDataList").empty();e.forEach((t=>{let e=`\n                        <div class="border rounded-md p-4 shadow-sm flex items-center justify-between">\n                            <div>\n                                <p class="text-sm text-gray-500">Jenis Ikan: <span class="font-medium">${t.nama_ikan}</span></p>\n                                <p class="text-sm text-gray-500">Produksi: <span class="font-medium">${t.ton_produksi} Ton</span></p>\n                                <p class="text-sm text-gray-500">Tanggal: <span class="font-medium">${n=t.tanggal_input,new Date(n).toLocaleDateString("id-ID",{day:"2-digit",month:"long",year:"numeric"})}</span></p>\n                            </div>\n                            <a href="perikanan/${t.id}/edit" class="bg-yellow-500 text-white px-3 py-1 rounded text-sm hover:bg-yellow-600">Ubah</a>\n                        </div>\n                    `;var n;$("#editDataList").append(e)}))},error:function(t){console.log(t.responseText)}})})),$(".deleteBtn").on("click",(function(){$("#modal").removeClass("hidden").addClass("flex");const t=$(this).data("ikan");$.ajax({type:"GET",url:`/api/dp/${t}`,data:{periode:periode.val()},success:function(t){const e=t.data;$("#editDataList").empty();e.forEach((t=>{let e=`\n                        <div class="border rounded-md p-4 shadow-sm flex items-center justify-between">\n                            <div>\n                                <p class="text-sm text-gray-500">Jenis Ikan: <span class="font-medium">${t.nama_ikan}</span></p>\n                                <p class="text-sm text-gray-500">Produksi: <span class="font-medium">${t.ton_produksi} Ton</span></p>\n                                <p class="text-sm text-gray-500">Tanggal: <span class="font-medium">${n=t.tanggal_input,new Date(n).toLocaleDateString("id-ID",{day:"2-digit",month:"long",year:"numeric"})}</span></p>\n                                \n                            </div>\n                            \n                            <button data-id="${t.id}" class="btnConfirm bg-red-500 text-white px-3 py-1 rounded text-sm hover:bg-red-600">Hapus</button>\n                        </div>\n                    `;var n;$("#editDataList").append(e)}))},error:function(t){console.log(t.responseText)}})})),$(document).on("click",".btnConfirm",(function(){let t=$(this).data("id");$("#deleteModal").show(),$("#yesBtn").off("click").on("click",(function(){$.ajax({type:"DELETE",url:`/api/dp/${t}`,data:{_token:"{{ csrf_token() }}"},success:function(t){Swal.fire({title:"Berhasil!",text:`Data ${t.data.nama_ikan} telah dihapus.`,icon:"success",confirmButtonText:"OK"}).then((()=>{location.reload()}))},error:function(t,e,n){Swal.fire({icon:"error",title:"Oops...",html:n})}}),$("#deleteModal").hide()}))})),$(document).on("click","#closeBtn",(function(){$("#deleteModal").hide()})),$(document).ready((function(){function t(t){const e=$("#no-search-results");if(t)if(0===e.length){const t='\n                        <tr id="no-search-results">\n                            <td colspan="14" class="text-center py-8">\n                                <div class="flex flex-col items-center justify-center">\n                                    <svg class="w-12 h-12 text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">\n                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>\n                                    </svg>\n                                    <h3 class="text-lg font-medium text-gray-500 mb-2">Tidak ada hasil ditemukan</h3>\n                                    <p class="text-gray-400">Coba gunakan kata kunci yang berbeda</p>\n                                </div>\n                            </td>\n                        </tr>\n                    ';$("tbody").append(t)}else e.show();else e.hide()}let e;$("#search").on("input",(function(){const e=$(this).val().toLowerCase().trim(),n=$("tbody tr");if(""===e)return n.show(),void t(!1);let s=0;n.each((function(){$(this).find("td:first").text().toLowerCase().includes(e)?($(this).show(),s++):$(this).hide()})),t(0===s)})),$("#search").on("input",(function(){clearTimeout(e);const n=$(this);e=setTimeout((function(){!function(e){const n=e.toLowerCase().trim(),s=$("tbody tr:not(#no-search-results)");if(""===n)return s.show(),void t(!1);let a=0;s.each((function(){const t=$(this).find("td:first").text().toLowerCase();t.includes(n)?($(this).show(),a++,function(t,e,n){if(""===e.trim())return void t.html(n);new RegExp(`(${s=e,s.replace(/[.*+?^${}()|[\]\\]/g,"\\$&")})`,"gi");var s}($(this).find("td:first"),e,t)):$(this).hide()})),t(0===a)}(n.val())}),200)}))}));
</script>