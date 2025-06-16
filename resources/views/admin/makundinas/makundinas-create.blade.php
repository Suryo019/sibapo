<x-admin-layout>
    <main class="flex-1 p-6 max-md:p-4 bg-gray-10 border-gray-20 border-[3px] rounded-[20px]">
        <div class="w-full flex items-center gap-2 mb-4">
            <a href="{{ route('makundinas.index') }}" class="text-decoration-none text-dark flex-shrink-0">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="4" stroke="currentColor" class="w-6 h-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5L8.25 12l7.5-7.5" />
                </svg>                      
            </a>
            <h3 class="text-2xl font-semibold text-center max-md:text-base">{{ $title }}</h3>
        </div>

        <div class="bg-white p-6 rounded shadow-md mt-4 border bg-gray-10 border-gray-20">
            <form action="{{ route('api.makundinas.store') }}" method="post" enctype="multipart/form-data" onkeydown="return event.key != 'Enter';">
                @csrf
                <!-- Dinas -->
                <div class="mb-4">
                    <label class="block text-pink-500">Dinas</label>
                    <select name="role_id" class="border p-2 w-full rounded-xl" id="dinas">
                        <option value="" disabled selected>Pilih Dinas</option>
                        @foreach ($roles as $role)
                            <option value="{{ $role->id }}">{{ ucfirst($role->role) }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Nama Lengkap -->
                <div class="mb-4">
                    <label class="block text-pink-500">Nama Lengkap</label>
                    <input type="text" placeholder="Contoh: Ahmad Selamet" 
                           class="border p-2 w-full rounded-xl" id="nama">
                </div>
    
                <!-- Username -->
                <div class="mb-4">
                    <label class="block text-pink-500">Username</label>
                    <input type="text" placeholder="Contoh: ahmadselamet99" 
                           class="border p-2 w-full rounded-xl" id="username">
                </div>

                <!-- Email/No Telp. -->
                <div class="mb-4">
                    <label class="block text-pink-500">Email</label>
                    <input type="text" name="email" placeholder="Contoh: ahmadselamet99@mail.com" 
                           class="border p-2 w-full rounded-xl" id="emailno" required>
                </div>

                <!-- Password -->
                <div class="mb-4">
                    <label class="block text-pink-500">Password</label>
                    <input type="password" name="password" placeholder="*********" 
                           class="border p-2 w-full rounded-xl" id="pass" required>
                </div>

                <!-- Confirm Password -->
                <div class="mb-4">
                    <label class="block text-pink-500">Confirm Password</label>
                    <input type="password" name="password_confirmation" placeholder="*********" 
                           class="border p-2 w-full rounded-xl" id="conpass" required>
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
$("#submitBtn").on("click",(function(){const a=new FormData;a.append("_token","{{ csrf_token() }}"),a.append("role_id",$("#dinas").val()),a.append("name",$("#nama").val()),a.append("username",$("#username").val()),a.append("email",$("#emailno").val()),a.append("password",$("#pass").val()),a.append("password_confirmation",$("#conpass").val()),$.ajax({type:"POST",url:"{{ route('api.makundinas.store') }}",data:a,processData:!1,contentType:!1,success:function(a){$("#dinas").val(""),$("#nama").val(""),$("#username").val(""),$("#emailno").val(""),$("#pass").val(""),$("#conpass").val(""),Swal.fire({title:"Berhasil!",text:`Data user ${a.data.name} dari Dinas ${a.data.role.role} telah disimpan.`,icon:"success",confirmButtonText:"OK"}).then((()=>{location.reload()}))},error:function(a){let e=a.responseJSON.errors,n="";$.each(e,(function(a,e){n+=e+"<br>"})),Swal.fire({icon:"error",title:"Oops...",html:n})}})}));
</script>
