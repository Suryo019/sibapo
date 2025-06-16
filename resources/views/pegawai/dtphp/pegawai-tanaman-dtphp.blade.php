{{-- @dd($data) --}}
<x-pegawai-layout title="Data Tanaman">
    <div class="w-full flex justify-between gap-4 mb-4">
        <!-- Search bar -->
        <x-search>
            Cari tanaman...
        </x-search>
    </div>
    
    {{-- Main Content --}}
    <main class="flex-1 p-6 max-md:p-4 bg-gray-10 border-gray-20 border-[3px] rounded-[20px]">
    
        <div class="w-full flex items-center gap-2 mb-4 flex-wrap">
            <a href="{{ route('pegawai.dtphp.dashboard') }}" class="text-dark flex-shrink-0">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="4" stroke="currentColor" class="w-6 h-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5L8.25 12l7.5-7.5" />
                </svg>                      
            </a>
            <h3 class="text-2xl md:text-xl font-semibold text-black">{{ $title }}</h3>
        </div>
    
        <div class="bg-white p-4 md:p-6 rounded shadow-md mt-4">
            @if (isset($data) && count($data) != 0)
            <div class="overflow-x-auto">
                <table class="min-w-full text-xs md:text-sm divide-y">
                    <thead class="bg-gray-100">
                        <tr>
                            <th rowspan="2" class="px-2 py-2 text-center">No</th>
                            <th rowspan="2" class="px-2 py-2 text-center">Jenis Tanaman</th>
                            <th rowspan="2" class="px-2 py-2 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y">
                        @foreach ($data as $item)
                        <tr class="hover:bg-gray-50">
                            <td class="px-2 py-2 text-center">{{ $loop->iteration }}</td>
                            <td class="px-2 py-2 text-center">{{ $item['nama_tanaman'] }}</td>
                            <td class="px-2 py-2 text-center">
                                <div class="flex justify-center gap-1">
                                    <a href="{{ route('pegawai.jenis-tanaman.edit', $item->id) }}">
                                        <button class="bg-yellow-400 text-white rounded-md w-10 h-10">
                                            <i class="bi bi-pencil-square"></i>
                                        </button>
                                    </a>
                                    <button class="deleteBtn bg-red-500 text-white rounded-md w-10 h-10 md:w-10 md:h-10 flex items-center justify-center"
                                        data-id="{{ $item['id'] }}"
                                        data-nama-jenis-tanaman="{{ $item['nama_tanaman'] }}"
                                        >
                                    <i class="bi bi-trash-fill text-xs md:text-base"></i>
                                </button>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            
            <!-- Modal Confirm Delete -->
            <div id="modal" class="hidden">
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

            @else
            <div class="flex items-center justify-center h-64">
                <div class="text-center p-4 border-2 border-dashed border-gray-300 rounded-lg shadow-md bg-gray-50">
                    <h3 class="text-lg font-semibold text-gray-500">Data Not Found</h3>
                    <p class="text-gray-400">We couldn't find any data matching your request. Please try again later.</p>
                </div>
            </div>
            @endif
        </div>
    
    </main>
     
</x-pegawai-layout>

<script>
$(document).on("click",".deleteBtn",(function(){let t=$(this).data("id");$("#modal").show(),$("#yesBtn").on("click",(function(){$("#modal").hide(),$.ajax({type:"DELETE",url:`/api/jenis-tanaman/${t}`,data:{_token:"{{ csrf_token() }}"},success:function(t){Swal.fire({title:"Berhasil!",text:`${t.message}`,icon:"success",confirmButtonText:"OK"}).then((()=>{location.reload()}))},error:function(t,e,n){Swal.fire({icon:"error",title:"Oops...",html:n})}})}))})),$("#closeBtn").on("click",(function(){$("#modal").hide()})),$(document).ready((function(){function t(t){const e=$("#no-search-results");if(t)if(0===e.length){const t='\n                        <tr id="no-search-results">\n                            <td colspan="14" class="text-center py-8">\n                                <div class="flex flex-col items-center justify-center">\n                                    <svg class="w-12 h-12 text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">\n                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>\n                                    </svg>\n                                    <h3 class="text-lg font-medium text-gray-500 mb-2">Tidak ada hasil ditemukan</h3>\n                                    <p class="text-gray-400">Coba gunakan kata kunci yang berbeda</p>\n                                </div>\n                            </td>\n                        </tr>\n                    ';$("tbody").append(t)}else e.show();else e.hide()}let e;$("#search").on("input",(function(){const e=$(this).val().toLowerCase().trim(),n=$("tbody tr");if(""===e)return n.show(),void t(!1);let o=0;n.each((function(){$(this).find("td").eq(1).text().toLowerCase().includes(e)?($(this).show(),o++):$(this).hide()})),t(0===o)})),$("#search").on("input",(function(){clearTimeout(e);const n=$(this);e=setTimeout((function(){!function(e){const n=e.toLowerCase().trim(),o=$("tbody tr:not(#no-search-results)");if(""===n)return o.show(),void t(!1);let i=0;o.each((function(){const t=$(this).find("td").eq(1).text().toLowerCase();t.includes(n)?($(this).show(),i++,function(t,e,n){if(""===e.trim())return void t.html(n);new RegExp(`(${o=e,o.replace(/[.*+?^${}()|[\]\\]/g,"\\$&")})`,"gi");var o}($(this).find("td:first"),e,t)):$(this).hide()})),t(0===i)}(n.val())}),200)}))}));
</script>
