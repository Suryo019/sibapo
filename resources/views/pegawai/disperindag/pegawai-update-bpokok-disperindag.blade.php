<x-pegawai-layout title="Ubah Data Bahan Pokok">
    <main class="flex-1 p-6 max-md:p-4 bg-gray-10 border-gray-20 border-[3px] rounded-[20px]">
        <div class="w-full flex items-center gap-2 mb-4">
            <a href="{{ route('pegawai.disperindag.bahanpokok.index') }}" class="text-decoration-none text-dark flex-shrink-0">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="4" stroke="currentColor" class="w-6 h-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5L8.25 12l7.5-7.5" />
                </svg>                      
            </a>
            <h2 class="text-2xl font-semibold text-black-">{{ $title }}</h2>
        </div>

    
        <div class="bg-white p-6 rounded shadow-md mt-4 border bg-gray-10 border-gray-20">
            <form action="" method="post" enctype="multipart/form-data" onkeydown="return event.key != 'Enter';">
                @csrf
                @method('PUT')
                
                <input type="text" class="hidden" value="{{ $data->id }}" id="bahan_pokok_id">

                <!-- Nama Pasar -->
                <div class="mb-4">
                    <label for="nama_bahan_pokok" class="block text-pink-500">Nama Bahan Pokok</label>
                    <input type="text" name="nama_bahan_pokok" placeholder="Contoh: Daging" 
                           class="border p-2 w-full rounded-xl" id="nama_bahan_pokok"
                           value="{{ old('nama_bahan_pokok', $data->nama_bahan_pokok) }}">
                </div>
    
                <!-- Gambar Bahan Pokok -->
                <div class="mb-4">
                    <label class="block text-pink-500 mb-2" for="gambar_bahan_pokok_input">Gambar Bahan Pokok</label>

                    <!-- Custom file upload button -->
                    <label for="gambar_bahan_pokok_input" 
                        class="inline-flex items-center px-4 py-2 bg-pink-500 text-white text-sm font-medium rounded-xl cursor-pointer hover:bg-pink-600 transition">
                        <i class="bi bi-upload me-2"></i> Pilih Gambar
                    </label>

                    <input type="file" name="gambar_bahan_pokok" id="gambar_bahan_pokok_input" class="hidden" accept="image/*">

                    <!-- Preview -->
                    @if ($data->gambar_bahan_pokok)
                        <div class="mt-4 flex flex-col ml-8">
                            <span class="text-slate-500 block" id="text-preview-gambar">Preview Gambar</span>
                            <img src="{{ asset('storage/' . $data->gambar_bahan_pokok) }}" id="gambar_preview" alt="Preview Gambar" 
                                class="w-40 h-40 block rounded-xl object-contain border border-pink-200 p-1 shadow">
                        </div>
                    @else
                       <div class="mt-4 flex flex-col ml-8">
                            <span class="text-slate-500 block" id="text-preview-gambar">Preview Gambar</span>
                            <img src="{{ asset('storage/img/landscape-placeholder.svg') }}" id="gambar_preview" alt="Preview Gambar" 
                                class="w-40 h-40 block rounded-xl object-contain border border-pink-200 p-1 shadow">
                        </div>
                    @endif
                </div>
            </form> 
        </div>
        
        <!-- Tombol -->
        <div class="flex justify-between mt-4">
            <button type="button" id="submitBtn" class="bg-yellow-550 text-white px-6 py-2 rounded-xl hover:bg-yellow-400">Simpan</button>
        </div>
        
    </main>
</x-pegawai-layout>

<script>
const id=$("#bahan_pokok_id").val();$("#gambar_bahan_pokok_input").on("change",(function(){$("#text-preview-gambar");let a=$("#gambar_preview");const n=new FileReader;n.readAsDataURL(this.files[0]),n.onload=function(n){a.attr("src",n.target.result)}})),$("#submitBtn").on("click",(function(){const a=new FormData;a.append("_token","{{ csrf_token() }}"),a.append("nama_bahan_pokok",$("#nama_bahan_pokok").val());const n=$("#gambar_bahan_pokok_input")[0].files[0];n&&a.append("gambar_bahan_pokok",n),$.ajax({type:"POST",url:`/api/bahan_pokok/${id}?_method=PUT`,data:a,processData:!1,contentType:!1,success:function(a){Swal.fire({title:"Berhasil!",text:`Data ${a.data.nama_bahan_pokok} telah diperbarui.`,icon:"success",confirmButtonText:"OK"}).then((()=>{window.location.href="{{ route('pegawai.disperindag.bahanpokok.index') }}"}))},error:function(a,n,e){let o=a.responseJSON.errors,t="";$.each(o,(function(a,n){t+=n+"<br>"})),Swal.fire({icon:"error",title:"Oops...",html:t})}})}));
</script>