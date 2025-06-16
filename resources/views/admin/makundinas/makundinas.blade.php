<x-admin-layout>
    <div class="flex flex-col lg:flex-row justify-between gap-4 mb-6">
        <!-- Search Component -->
        <x-search>
            Cari nama...
        </x-search>
        
        {{-- Filter --}}
        <div class="flex justify-end">
            <div class="relative flex justify-end">
                <x-filter></x-filter>

                <!-- Modal Background -->
                <x-filter-modal>
                    <form action="{{ route('makundinas.index') }}" method="get">
                        <div class="space-y-4">
                            <!-- Pilih Dinas -->
                            <div class="flex flex-col">
                                <label for="pilih_dinas" class="block text-sm font-medium text-gray-700 mb-1">Pilih Dinas</label>
                                <select name="dinas" id="pilih_dinas" class="w-full border border-gray-300 p-2 rounded-lg bg-white shadow-sm focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-colors">
                                    <option value="">Semua Dinas</option>
                                    @foreach ($roles as $dinas)
                                        <option value="{{ $dinas->role }}" {{ request('dinas') == $dinas->role ? 'selected' : '' }}>
                                            {{ $dinas->role }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    
                        <div class="w-full flex justify-end gap-3 mt-10">
                            <a href="{{ route('makundinas.index') }}" class="bg-yellow-550 text-white rounded-lg w-20 p-1 text-center">Reset</a>
                            <button type="submit" class="bg-pink-650 text-white rounded-lg w-20 p-1">Cari</button>
                        </div>
                    </form>
                </x-filter-modal> 
            </div> 
        </div> 
    </div>
    
    <main class="flex-1 p-6 max-md:p-4 bg-gray-10 border-gray-20 border-[3px] rounded-[20px]">

        <div class="w-full flex items-center gap-2 mb-4">
            <a href="" class="text-decoration-none text-dark flex-shrink-0">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="4" stroke="currentColor" class="w-6 h-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5L8.25 12l7.5-7.5" />
                </svg>                       
            </a>
            <h3 class="text-2xl font-extrabold text-center max-md:text-base">{{ $title }}</h3>
        </div>

        <div class="bg-white p-6 rounded shadow-md mt-4 border bg-gray-10 border-gray-20 overflow-x-auto">

            <!-- Tabel -->
            @if (isset($data) && count($data) != 0)
            <div class="min-w-full inline-block align-middle">
                <div class="overflow-auto">
                    <table class="min-w-full divide-y">
                        <thead class="bg-gray-100">
                            <tr>
                                <th rowspan="2" class="px-2 py-2 text-center">No</th>
                                {{-- <th rowspan="2" class="px-2 py-2 text-center">Id</th> --}}
                                <th rowspan="2" class="px-2 py-2 text-center">Role</th>
                                <th rowspan="2" class="px-2 py-2 text-center">Name</th>
                                <th rowspan="2" class="px-2 py-2 text-center">Email</th>
                                <th rowspan="2" class="px-2 py-2 text-center">Username</th>
                                <th rowspan="2" class="px-2 py-2 text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y">
                            @foreach ($data as $item)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-2 py-2 text-center">{{ $loop->iteration }}</td>
                                    {{-- <td class="px-2 py-2 text-center">{{ $item->id }}</td> --}}
                                    <td class="px-2 py-2 text-center">{{ $item->role }}</td>
                                    <td class="px-2 py-2 text-center">{{ $item->name }}</td>
                                    <td class="px-2 py-2 text-center">{{ $item->email }}</td>
                                    <td class="px-2 py-2 text-center">{{ $item->username }}</td>
                                    <td class="px-2 py-2 text-center">
                                        <div class="flex justify-center gap-1">
                                            <a href="{{ route('makundinas.edit', $item->id) }}">
                                                <button class="bg-yellow-400 text-white rounded-md w-10 h-10 hover:bg-yellow-500">
                                                  <i class="bi bi-pencil-square"></i>
                                                </button>
                                              </a>
                                              <button class="deleteBtn bg-red-500 text-white rounded-md w-10 h-10 md:w-10 md:h-10 flex items-center justify-center"
                                                data-id="{{ $item->id }}"> <!-- Menggunakan data-id di sini -->
                                              <i class="bi bi-trash-fill text-xs md:text-base"></i>
                                          </button>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- Modal --}}
            <div id="modal" class="fixed inset-0 bg-black bg-opacity-50 hidden justify-center items-center z-40 p-4">
                <div class="bg-white p-6 rounded-lg w-[90%] max-w-2xl shadow-lg relative">
                    <h2 class="text-xl font-semibold mb-4">Pilih Data untuk Di<span id="actionPlaceholder"></span></h2>
                    <div id="editDataList" class="space-y-4 max-h-96 overflow-y-auto mb-4"></div>
                    <div class="text-right" id="closeListModal">
                        <button class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded">Tutup</button>
                    </div>
                </div>
            </div>
    
            @else
            <div class="flex items-center justify-center h-64">
                <div class="text-center p-4 border-2 border-dashed border-gray-300 rounded-lg shadow-md bg-gray-50">
                    <h3 class="text-lg font-semibold text-gray-500">Data Not Found</h3>
                    <p class="text-gray-400">We couldn't find any data matching your request. Please try again later.</p>
                </div>
            </div>
            @endif

        </div>

        {{-- Modal Delete --}}
        <div id="deleteModal" class="hidden w-full h-full">
            <div class="fixed inset-0 bg-black bg-opacity-50 flex justify-center items-center z-40 p-4">
                <div class="bg-white rounded-lg w-full max-w-md shadow-lg relative">
                    <div class="p-4 md:p-6">
                        <h2 class="text-lg md:text-xl font-semibold mb-6 text-center">Yakin menghapus data?</h2>
                        <div class="flex flex-col sm:flex-row justify-center gap-4">
                            <button class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-full text-sm md:text-base" id="closeBtn">Batal</button>
                            <button class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-full text-sm md:text-base" id="yesBtn">Ya, Hapus</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </main>
</x-admin-layout>

<script>
function toggleModal(){const t=document.getElementById("filterModal");t.classList.toggle("hidden"),t.classList.toggle("flex")}$("#filterBtn").on("click",(function(){$("#filterModal").toggleClass("hidden")})),$(document).on("click",".deleteBtn",(function(){let t=$(this).data("id");$("#deleteModal").show(),$("#yesBtn").off("click").on("click",(function(){$.ajax({type:"DELETE",url:`/api/makundinas/${t}`,success:function(t){Swal.fire({title:"Berhasil!",text:`User ${t.data.name} dari Dinas ${t.data.role} telah dihapus.`,icon:"success",confirmButtonText:"OK"}).then((()=>{location.reload()}))},error:function(t,e,n){Swal.fire({icon:"error",title:"Oops...",html:n})}}),$("#deleteModal").hide()}))})),$(document).on("click","#closeBtn",(function(){$("#deleteModal").hide()})),$(document).ready((function(){function t(t){const e=$("#no-search-results");if(t)if(0===e.length){const t='\n                        <tr id="no-search-results">\n                            <td colspan="14" class="text-center py-8">\n                                <div class="flex flex-col items-center justify-center">\n                                    <svg class="w-12 h-12 text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">\n                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>\n                                    </svg>\n                                    <h3 class="text-lg font-medium text-gray-500 mb-2">Tidak ada hasil ditemukan</h3>\n                                    <p class="text-gray-400">Coba gunakan kata kunci yang berbeda</p>\n                                </div>\n                            </td>\n                        </tr>\n                    ';$("tbody").append(t)}else e.show();else e.hide()}let e;$("#search").on("input",(function(){const e=$(this).val().toLowerCase().trim(),n=$("tbody tr");if(""===e)return n.show(),void t(!1);let o=0;n.each((function(){$(this).find("td:first").text().toLowerCase().includes(e)?($(this).show(),o++):$(this).hide()})),t(0===o)})),$("#search").on("input",(function(){clearTimeout(e);const n=$(this);e=setTimeout((function(){!function(e){const n=e.toLowerCase().trim(),o=$("tbody tr:not(#no-search-results)");if(""===n)return o.show(),void t(!1);let i=0;o.each((function(){const t=$(this).find("td"),e=t.eq(0).text().toLowerCase(),o=t.eq(1).text().toLowerCase(),s=t.eq(2).text().toLowerCase(),a=t.eq(3).text().toLowerCase();e.includes(n)||o.includes(n)||s.includes(n)||a.includes(n)?($(this).show(),i++):$(this).hide()})),t(0===i)}(n.val())}),200)}))}));
</script>
