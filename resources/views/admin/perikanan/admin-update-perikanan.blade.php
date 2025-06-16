<x-admin-layout>
    
        <main class="flex-1 p-6 max-md:p-4 bg-gray-10 border-gray-20 border-[3px] rounded-[20px]">
            <div class="w-full flex items-center gap-2 mb-4">
                <a href="{{ route('perikanan.detail') }}" class="text-decoration-none text-dark flex-shrink-0">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="4" stroke="currentColor" class="w-6 h-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5L8.25 12l7.5-7.5" />
                    </svg>                      
                </a>
                <h3 class="text-2xl font-semibold text-center max-md:text-base">{{ $title }}</h3>
            </div>
        <div class="bg-white p-4 sm:p-6 rounded-lg shadow-md mt-4 border bg-gray-10 border-gray-20">
            <form id="editFishForm" onkeydown="return event.key != 'Enter';">
                @csrf
                @method('PUT')

                <!-- Nama Ikan -->
                <div class="mb-4">
                    <label class="block text-pink-500">Nama Ikan</label>
                    <select id="jenis_ikan_id" name="jenis_ikan_id" class="border p-2 w-full rounded-xl bg-white text-black dark:text-black dark:bg-white">
                        <option value="" selected disabled>Pilih Ikan</option>
                        @foreach ($fishes as $fish)
                            <option value="{{ $fish->id }}" {{ old('jenis_ikan_id', $data->jenis_ikan_id) == $fish->id ? 'selected' : '' }}>
                                {{ $fish->nama_ikan }}
                            </option>                        
                        @endforeach
                    </select>
                </div>

                <!-- Volume Produksi -->
                <div class="mb-4">
                    <label for="ton_produksi" class="block text-sm font-medium text-pink-500 mb-1">Volume Produksi (Ton)</label>
                    <input 
                        type="number" 
                        name="ton_produksi" 
                        id="ton_produksi"
                        value="{{ old('ton_produksi', $data->ton_produksi) }}"
                        placeholder="Contoh: 100" 
                        class="w-full border border-gray-300 p-2 rounded-xl focus:ring-2 focus:ring-pink-500 focus:border-pink-500 transition-colors"
                        required
                        min="0"
                        step="0.01">
                    <p id="ton_produksi_error" class="mt-1 text-sm text-red-600 hidden"></p>
                </div>

                <!-- Tanggal Input -->
                <div class="mb-4">
                    <label for="tanggal_input" class="block text-sm font-medium text-pink-500 mb-1">Tanggal Input</label>
                    <input 
                        type="date" 
                        name="tanggal_input" 
                        id="tanggal_input"
                        value="{{ old('tanggal_input', \Carbon\Carbon::parse($data->tanggal_input)->format('Y-m-d')) }}"
                        class="w-full border border-gray-300 p-2 rounded-xl focus:ring-2 focus:ring-pink-500 focus:border-pink-500 transition-colors"
                        required>
                    <p id="tanggal_input_error" class="mt-1 text-sm text-red-600 hidden"></p>
                </div>
            </form>
        </div>
        
        <!-- Action Buttons -->
        <div class="flex justify-between mt-6">
            <button id="submitBtn" class="inline-flex items-center px-6 py-2 bg-yellow-550 hover:bg-yellow-500 text-white rounded-xl shadow-sm transition-colors duration-200 ">
                Simpan 
            </button>
        </div>
    </main>
</x-admin-layout>

<script>
$("#submitBtn").on("click",(function(){$.ajax({type:"PUT",url:"{{ route('api.dp.update', $data->id) }}",data:{_token:"{{ csrf_token() }}",jenis_ikan_id:$("#jenis_ikan_id").val(),ton_produksi:$("#ton_produksi").val(),tanggal_input:$("#tanggal_input").val()},success:function(t){Swal.fire({icon:"success",title:"Berhasil",text:"Data berhasil diperbarui!",confirmButtonColor:"#16a34a"}).then((()=>{window.location.href="{{ route('perikanan.detail') }}"}))},error:function(t,i,n){let a=t.responseJSON.errors,e="";$.each(a,(function(t,i){e+=i+"<br>"})),Swal.fire({icon:"error",title:"Oops...",html:e})}})}));
</script>