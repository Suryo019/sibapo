<x-pegawai-layout title="Tambah Data Bahan Pokok">
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
            <form action="{{ route('api.bahan_pokok.store') }}" method="post" enctype="multipart/form-data" onkeydown="return event.key != 'Enter';">
                @csrf
                <!-- Nama Bahan Pokok -->
                <div class="mb-4">
                    <label class="block text-pink-500">Nama Bahan Pokok</label>
                    <input type="text" placeholder="Contoh: Daging" 
                           class="border p-2 w-full rounded-xl" id="nama_bahan_pokok">
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
                    <div class="mt-4 flex flex-col ml-8">
                        <span class="text-slate-500 hidden" id="text-preview-gambar">Preview Gambar</span>
                        <img id="gambar_preview" alt="Preview Gambar" 
                            class="w-40 h-40 hidden rounded-xl object-contain border border-pink-200 p-1 shadow">
                    </div>
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
const input=document.getElementById("gambar_bahan_pokok_input"),preview=document.getElementById("gambar_preview");$("#gambar_bahan_pokok_input").on("change",(function(){let a=$("#text-preview-gambar"),e=$("#gambar_preview");e.toggleClass("hidden"),e.toggleClass("block"),a.toggleClass("hidden"),a.toggleClass("block");const t=new FileReader;t.readAsDataURL(this.files[0]),t.onload=function(a){e.attr("src",a.target.result)}})),$("#submitBtn").on("click",(function(){const a=new FormData;a.append("_token","{{ csrf_token() }}"),a.append("nama_bahan_pokok",$("#nama_bahan_pokok").val());let e=$("#gambar_bahan_pokok_input")[0].files[0];void 0!==e&&a.append("gambar_bahan_pokok",e),$.ajax({type:"POST",url:"{{ route('api.bahan_pokok.store') }}",data:a,processData:!1,contentType:!1,success:function(a){$("#nama_bahan_pokok").val(""),$("#gambar_bahan_pokok_input").val(""),$("#gambar_preview").attr("src","").addClass("hidden"),Swal.fire({title:"Berhasil!",text:`Data ${a.data.nama_bahan_pokok} telah disimpan.`,icon:"success",confirmButtonText:"OK"})},error:function(a){let e=a.responseJSON.errors,t="";$.each(e,(function(a,e){t+=e+"<br>"})),Swal.fire({icon:"error",title:"Oops...",html:t})}})}));
</script>