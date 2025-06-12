<x-admin-layout>
        <main class="flex-1 p-6 max-md:p-4 bg-gray-10 border-gray-20 border-[3px] rounded-[20px]">
                <div class="w-full flex items-center gap-2 mb-4">
                    <a href="{{ route('dtphp.detail.produksi') }}" class="text-decoration-none text-dark flex-shrink-0">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="4" stroke="currentColor" class="w-6 h-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5L8.25 12l7.5-7.5" />
                        </svg>                      
                    </a>
                    <h3 class="text-lg font-semibold text-center max-md:text-base">Tambah Data</h3>
                </div>

        <div class="bg-white p-6 max-md:p-4 rounded shadow-md mt-4 border bg-gray-10 border-gray-20">
            <form action="" method="POST" onkeydown="return event.key != 'Enter';">
                @csrf
                @method('PUT')
                <div class="mb-4">
                    <label class="block text-pink-500">Nama Tanaman</label>
                    <select id="jenis_tanaman_id" name="jenis_tanaman_id" class="border p-2 w-full rounded-xl bg-white text-black dark:text-black dark:bg-white">
                        <option value="" selected disabled>Pilih Tanaman</option>
                        @foreach ($commodities as $commodity)
                            <option value="{{ $commodity->id }}" {{ old('jenis_tanaman_id', $data->jenis_tanaman_id) == $commodity->id ? 'selected' : '' }}>
                                {{ $commodity->nama_tanaman }}
                            </option>                        
                        @endforeach
                    </select>
                </div>

                <!-- Volume Produksi -->
                <div class="mb-4">
                    <label class="block text-pink-500 text-sm max-md:text-xs mb-1">Volume Produksi (Ton)</label>
                    <input
                      type="text"
                      name="ton_volume_produksi"
                      id="ton_volume_produksi"
                      placeholder="Contoh: 100"
                      class="border border-gray-300 p-2 max-md:p-1.5 w-full rounded-xl text-sm max-md:text-xs"
                      value="{{ old('ton_volume_produksi', $data->ton_volume_produksi) }}"
                    />
                </div>
                  
                <!-- Luas Panen -->
                <div class="mb-4">
                    <label class="block text-pink-500 text-sm max-md:text-xs mb-1">Luas Panen (Hektar)</label>
                    <input
                      type="text"
                      name="hektar_luas_panen"
                      id="hektar_luas_panen"
                      placeholder="Contoh: 7"
                      class="border border-gray-300 p-2 max-md:p-1.5 w-full rounded-xl text-sm max-md:text-xs"
                      value="{{ old('hektar_luas_panen', $data->hektar_luas_panen) }}"
                    />
                </div>
                  
                <!-- Tanggal Input -->
                <div class="mb-4">
                    <label class="block text-pink-500 text-sm max-md:text-xs mb-1">Terakhir Diubah</label>
                    <div class="relative">
                      <input
                        type="date"
                        name="tanggal_input"
                        id="tanggal_input"
                        class="border border-gray-300 p-2 max-md:p-1.5 w-full rounded-xl text-sm max-md:text-xs focus:outline-none focus:ring-2 focus:ring-pink-500"
                        value="{{ old('tanggal_input', \Carbon\Carbon::parse($data->tanggal_input)->format('Y-m-d')) }}"
                      />
                    </div>
                </div>             

                <!-- Tombol -->
                <div class="flex justify-between mt-6 max-md:mt-4">
                    <button type="button" id="submitBtn" class="bg-yellow-550 text-white px-6 py-2 max-md:px-4 max-md:py-1.5 rounded-xl hover:bg-yellow-500 text-sm max-md:text-xs">
                        Simpan
                    </button>
                </div>
            </form>
        </div>
    </main>
</x-admin-layout>

<script>
$(document).ready((function(){$("#submitBtn").on("click",(function(){$.ajax({type:"PUT",url:"{{ route('api.dtphp.update', $data->id) }}",data:{_token:"{{ csrf_token() }}",jenis_tanaman_id:$("#jenis_tanaman_id").val(),ton_volume_produksi:$("#ton_volume_produksi").val(),hektar_luas_panen:$("#hektar_luas_panen").val(),tanggal_input:$("#tanggal_input").val()},success:function(t){Swal.fire({icon:"success",title:"Berhasil",text:"Data berhasil diperbarui!",confirmButtonColor:"#16a34a"}).then((()=>{window.location.href="{{ route('dtphp.detail.produksi') }}"}))},error:function(t,a,n){let e=t.responseJSON.errors,o="";$.each(e,(function(t,a){o+=a+"<br>"})),Swal.fire({icon:"error",title:"Oops...",html:o,confirmButtonColor:"#16a34a"})}})}))}));
</script>