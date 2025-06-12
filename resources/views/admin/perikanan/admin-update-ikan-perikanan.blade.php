<x-admin-layout>
    <main class="flex-1 p-6 max-md:p-4 bg-gray-10 border-gray-20 border-[3px] rounded-[20px]">
        <div class="w-full flex items-center gap-2 mb-4">
            <a href="{{ route('jenis-ikan.index') }}" class="text-decoration-none text-dark flex-shrink-0">
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

                <input type="text" class="hidden" value="{{ $data->id }}" id="jenis_ikan_id">
                
                <!-- Nama Ikan -->
                <div class="mb-4">
                    <label for="nama_ikan" class="block text-pink-500">Nama Ikan</label>
                    <input type="text" name="nama_ikan" placeholder="Contoh: Nila" 
                           class="border p-2 w-full rounded-xl" id="nama_ikan"
                           value="{{ old('nama_ikan', $data->nama_ikan) }}">
                </div>
    
            </form> 
        </div>
        
        <!-- Tombol -->
        <div class="flex justify-between mt-4">
            <button type="button" id="submitBtn" class="bg-yellow-550 text-white px-6 py-2 rounded-xl hover:bg-yellow-400">Simpan</button>
        </div>
        
    </main>
</x-admin-layout>

<script>
const id=$("#jenis_ikan_id").val();$("#submitBtn").on("click",(function(){$.ajax({type:"PUT",url:`/api/jenis-ikan/${id}`,data:{_token:"{{ csrf_token() }}",nama_ikan:$("#nama_ikan").val()},success:function(n){$("#nama_ikan").val(""),Swal.fire({title:"Berhasil!",text:`Data ikan ${n.data.nama_ikan} telah diperbarui.`,icon:"success",confirmButtonText:"OK"}).then((()=>{window.location.href="{{ route('jenis-ikan.index') }}"}))},error:function(n,a,i){let e=n.responseJSON.errors,t="";$.each(e,(function(n,a){t+=a+"<br>"})),Swal.fire({icon:"error",title:"Oops...",html:t})}})}));
</script>