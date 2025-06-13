@php
    $imagePath = optional(Auth::user())->user_image 
        ? asset('storage/' . Auth::user()->user_image) 
        : asset('storage/img/placeholder.png');
@endphp

@php
    $imagePath = optional(Auth::user())->user_image 
        ? asset('storage/' . Auth::user()->user_image) 
        : asset('storage/img/placeholder.png');
@endphp

<header {{ $attributes }}>
    <!-- Kiri: Burger Menu dan Nama Dinas di Mobile -->
    <div class="flex md:hidden items-center w-2/3">
        <div id="burger-menu" class="flex justify-center items-center text-green-900 bg-white rounded w-7 h-6 cursor-pointer">
            <i class="bi bi-list text-xl"></i>
        </div>
        <div class="justify-center flex md:hidden ml-4">
            <h1 class="text-lg font-extrabold text-white">{{ $slot }}</h1>
        </div>
    </div>

    <!-- Tengah: Nama Dinas (Desktop) -->
    <h2 class="text-2xl font-extrabold text-center hidden md:block">{{ $slot }}</h2>

    @php
        $linkNotifikasi = match(true) {
            Auth::user()->role->role == 'disperindag' => route('pegawai.disperindag.notifikasi.index'),
            Auth::user()->role->role == 'dkpp' => route('pegawai.dkpp.notifikasi.index'),
            Auth::user()->role->role == 'dtphp' => route('pegawai.dtphp.notifikasi.index'),
            Auth::user()->role->role == 'perikanan' => route('pegawai.perikanan.notifikasi.index'),
            default => 'Admin'
        };
    @endphp
    
    <div class="flex items-center gap-4 mr-4">
        <!-- Wrapper untuk ikon notifikasi -->
        <div class="relative">
          <!-- Icon -->
          <i class="bi bi-bell-fill text-gray-600 cursor-pointer text-2xl" id="notifToggle"></i>
          <!-- Badge jumlah notifikasi -->
          <span id="notifBadge"
                class="absolute -top-2 -right-2 bg-red-500 text-white text-xs rounded-full px-2 py-1 min-w-[20px] text-center hidden">
            0
          </span>
      
          <!-- Panel Notifikasi -->
            <div id="notifPanel"
               class="hidden absolute top-8 right-0 w-[250px] sm:w-96 bg-white shadow-lg rounded-2xl z-50 p-5">
      
            <!-- Header -->
            <div class="flex justify-between items-center mb-4">
              <h3 class="text-lg font-bold">Notifikasi</h3>
              <button id="notifClose" class="text-gray-400 hover:text-gray-600 text-xl">&times;</button>
            </div>
      
            <!-- Loading -->
            <div id="notifLoading" class="text-center py-4">
              <p class="text-gray-500">Memuat notifikasi...</p>
            </div>
      
            <!-- Kontainer Notifikasi -->
            <div id="notifContainer" class="hidden">
              <p class="font-semibold mb-2">Terbaru</p>
              <div id="notifList">
                <!-- Notifikasi dimuat di sini -->
              </div>
      
              <!-- Tombol tandai dibaca -->
              <button id="markAllRead"
                      class="w-full text-sm text-gray-600 hover:text-gray-800 mt-3 py-2 border rounded">
                Tandai Semua Sebagai Dibaca
              </button>
            </div>
            
            @php
                $dinas = match(true) {
                    Auth::user()->role->role == 'disperindag' => 'pegawai.disperindag.notifikasi.index',
                    Auth::user()->role->role == 'dkpp' => 'pegawai.dkpp.notifikasi.index',
                    Auth::user()->role->role == 'dtphp' => 'pegawai.dtphp.notifikasi.index',
                    Auth::user()->role->role == 'perikanan' => 'pegawai.perikanan.notifikasi.index',
                    default => 'Admin'
                };
            @endphp

            <!-- Link ke halaman semua notifikasi -->
            <a href="{{ route($dinas) }}">
              <p class="text-center text-pink-600 mt-4 cursor-pointer hover:underline">Semua Notifikasi</p>
            </a>
        </div>
    </div>
        
    
        <!-- Gambar Profil dan Nama -->
        <div class="flex items-center gap-4 cursor-pointer" id="profile-toggler">     
            <img src="{{ $imagePath }}" alt="Profile"
                class="w-10 h-10 rounded-full bg-gray-300 scale-95 md:scale-100">
            <span class="text-sm hidden md:block">Hi, <b class="text-yellow-500">{{ Auth::user()->username }}</b>!</span>
        </div>

</header>


<!-- Background dark layer -->
<div id="bg-darker"
    class="w-screen h-screen bg-black/70 fixed top-0 left-0 z-40 opacity-0 pointer-events-none transition-opacity duration-500">
</div>

<!-- Sliding profile page -->
<div id="profile-web-page" class="fixed w-full h-full overflow-y-auto top-[-100%] left-0 z-50 bg-cover transition-all duration-500 ease-in-out bg-white">
    <img src="{{ asset('/storage/img/profile-page-bg-fix.png') }}" alt="profile" class="w-full absolute z-0 hidden md:block">
    <img src="{{ asset('/storage/img/profile-page-bg-mobile-fix.png') }}" alt="profile" class="w-full absolute z-0 md:hidden">
    
    <div class="relative z-10 min-h-screen p-4 md:p-8">
        <!-- Back Button -->
        <div class="flex items-center w-fit gap-2 text-white cursor-pointer mb-5" id="profile-back-toggler">
            <iconify-icon icon="mingcute:left-fill" class="text-3xl md:text-5xl"></iconify-icon>
        </div>

        <form class="w-full flex flex-col items-center" method="POST" action="#" enctype="multipart/form-data">
            @csrf

            <!-- Profile Image -->
            <div class="w-40 h-40 md:w-64 md:h-64 rounded-full shadow-white-custom border-white border-4 mb-4 relative">
                <img src="{{ $imagePath }}" alt="Profile Image" id="gambar_profil" class="rounded-full w-full h-full object-cover">
                <input type="file" name="gambar_input" id="gambar_input" hidden>
                <button type="button" id="btn-upload" class="w-12 h-12 md:w-20 md:h-20 bg-pink-650 rounded-full absolute bottom-0 right-0 flex items-center justify-center text-white">
                    <iconify-icon icon="solar:camera-broken" class="text-2xl md:text-4xl"></iconify-icon>
                </button>
            </div>

            <input type="hidden" id="user_id_profile" value="{{ Auth::user()->id }}">
            <input type="hidden" id="user_role_profile" value="{{ Auth::user()->role_id }}">
            <input type="hidden" id="user_role_name" value="{{ Auth::user()->role->role }}">

            @php
                $dinas = match(true) {
                    Auth::user()->role->role == 'disperindag' => 'Dinas Perindustrian dan Perdagangan',
                    Auth::user()->role->role == 'dkpp' => 'Dinas Ketahanan Pangan dan Peternakan',
                    Auth::user()->role->role == 'dtphp' => 'Dinas Tanaman Pangan, Holtikultural, dan Perkebunan',
                    Auth::user()->role->role == 'perikanan' => 'Dinas Perikanan',
                    default => 'Admin'
                };
            @endphp

            <!-- Name & Role -->
            <div class="flex flex-col items-center gap-2 mb-8 text-center">
                <span class="text-2xl md:text-4xl font-semibold text-pink-650 drop-shadow-[0_0_2px_white]">{{ Auth::user()->name }}</span>
                <div class="text-black text-lg md:text-xl">{{ $dinas }}</div>
            </div>

            <!-- Nama -->
            <div class="w-full max-w-md mb-4 px-4">
                <label for="nama" class="flex items-center text-pink-650 text-lg md:text-xl font-semibold mb-2 gap-2">
                    <i class="bi bi-person-fill"></i> Nama
                </label>
                <div class="w-full bg-gray-90 rounded-full flex items-center gap-2">
                    <input type="text" class="flex-1 py-2 px-4 rounded-full outline-none text-gray-550" disabled value="{{ Auth::user()->name }}" id="nama" name="nama">
                    <iconify-icon icon="heroicons:pencil-square-solid" class="text-gray-550 text-xl cursor-pointer" id="btn_edit_nama"></iconify-icon>
                    <iconify-icon icon="ion:checkmark-done" class="text-gray-550 text-xl cursor-pointer hidden" id="btn_edit_nama_selesai"></iconify-icon>
                </div>
            </div>

            <!-- Username -->
            <div class="w-full max-w-md mb-4 px-4">
                <label for="username_profile" class="flex items-center text-pink-650 text-lg md:text-xl font-semibold mb-2 gap-2">
                    <i class="bi bi-person-fill"></i> Username
                </label>
                <div class="w-full bg-gray-90 rounded-full flex items-center gap-2">
                    <input type="text" class="flex-1 py-2 px-4 rounded-full outline-none text-gray-550" disabled value="{{ Auth::user()->username }}" id="username_profile" name="username_profile">
                    <iconify-icon icon="heroicons:pencil-square-solid" class="text-gray-550 text-xl cursor-pointer" id="btn_edit_username"></iconify-icon>
                    <iconify-icon icon="ion:checkmark-done" class="text-gray-550 text-xl cursor-pointer hidden" id="btn_edit_username_selesai"></iconify-icon>
                </div>
            </div>

            <!-- Email -->
            <div class="w-full max-w-md mb-20 px-4">
                <label for="email_profile" class="flex items-center text-pink-650 text-lg md:text-xl font-semibold mb-2 gap-2">
                    <i class="bi bi-envelope-fill"></i> Email
                </label>
                <input type="text" class="w-full py-2 px-4 rounded-full outline-none text-gray-550 bg-gray-90" disabled value="{{ Auth::user()->email }}" id="email_profile" name="email_profile">
            </div>

            <!-- Save Button -->
            <button type="button" id="profile_submit" class="w-10/12 max-w-xs mb-4 p-2 bg-green-500 rounded-full text-white flex justify-center items-center gap-2">
                <iconify-icon icon="material-symbols:save" class="text-xl"></iconify-icon>
                Simpan
            </button>
        </form>

        <!-- Logout -->
        <form class="w-full flex justify-center" action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit" class="w-10/12 max-w-xs p-2 mb-8 bg-red-500 rounded-full text-white flex justify-center items-center gap-2">
                <iconify-icon icon="material-symbols:logout" class="text-xl"></iconify-icon>
                Log Out
            </button>
        </form>
    </div>
</div>

<script>
const dinas=$("#user_role_name").val();$(document).on("click","#btn_edit_nama",(function(){$(this).addClass("hidden"),$("#btn_edit_nama_selesai").removeClass("hidden"),$("#nama").removeAttr("disabled"),$("#nama").addClass("border-2")})),$(document).on("click","#btn_edit_nama_selesai",(function(){$(this).addClass("hidden"),$("#btn_edit_nama").removeClass("hidden"),$("#nama").attr("disabled",!0),$("#nama").removeClass("border-2")})),$(document).on("click","#btn_edit_username",(function(){$(this).addClass("hidden"),$("#btn_edit_username_selesai").removeClass("hidden"),$("#username_profile").removeAttr("disabled"),$("#username_profile").addClass("border-2")})),$(document).on("click","#btn_edit_username_selesai",(function(){$(this).addClass("hidden"),$("#btn_edit_username").removeClass("hidden"),$("#username_profile").attr("disabled",!0),$("#username_profile").removeClass("border-2")})),$(document).on("click","#profile_submit",(function(){const e=$("#user_id_profile").val(),n=new FormData;n.append("name",$("#nama").val()),n.append("username",$("#username_profile").val()),n.append("role_id",$("#user_role_profile").val()),n.append("email",$("#email_profile").val());const t=$("#gambar_input")[0];t.files.length>0&&n.append("user_image",t.files[0]),$.ajax({type:"POST",url:`/api/makundinas/${e}?_method=PUT`,data:n,contentType:!1,processData:!1,cache:!1,success:function(e){Swal.fire({title:"Berhasil!",text:"Profile telah di update!.",icon:"success",confirmButtonText:"OK"}).then((()=>{location.reload()}))},error:function(e){let n=e.responseJSON.errors,t="";$.each(n,(function(e,n){t+=n+"<br>"})),Swal.fire({icon:"error",title:"Oops...",html:t})}})})),$(document).on("click","#btn-upload",(function(){$("#gambar_input").click()})),$("#gambar_input").on("change",(function(){$("#text-preview-gambar");let e=$("#gambar_profil");const n=new FileReader;n.readAsDataURL(this.files[0]),n.onload=function(n){e.attr("src",n.target.result)}})),$(document).on("click","#profile-toggler",(function(){$("#bg-darker").removeClass("pointer-events-none").addClass("pointer-events-auto").addClass("opacity-100").removeClass("opacity-0"),$("#profile-web-page").removeClass("top-[-100%]").addClass("top-0")})),$(document).on("click","#profile-back-toggler",(function(){$("#profile-web-page").removeClass("top-0").addClass("top-[-100%]"),$("#bg-darker").removeClass("opacity-100").addClass("opacity-0").one("transitionend",(function(){$(this).addClass("pointer-events-none").removeClass("pointer-events-auto")}))})),$("#burger-menu").on("click",(function(){$("#sidebar").removeClass("hidden").toggleClass("hidden").slideToggle("slow")})),document.addEventListener("DOMContentLoaded",(function(){const e=document.getElementById("notifToggle"),n=document.getElementById("notifPanel"),t=document.getElementById("notifClose"),a=document.getElementById("notifBadge"),i=document.getElementById("notifContainer"),o=document.getElementById("notifLoading"),s=document.getElementById("notifList"),r=document.getElementById("markAllRead");function d(){o.classList.remove("hidden"),i.classList.add("hidden"),fetch(`/pegawai/${dinas}/notifications/header`).then((e=>e.json())).then((e=>{l(e.unread_count),function(e){if(0===e.length)return void(s.innerHTML='<p class="text-gray-500 text-center py-4">Tidak ada notifikasi</p>');let n="";e.forEach((function(e){const t=e.is_read,a=t?"bg-gray-50":"bg-white border-pink-300",i=t?"text-gray-500":"text-pink-600",o=function(e){const n=new Date,t=Math.floor((n-e)/1e3);if(t<60)return"Baru saja";if(t<3600){return`${Math.floor(t/60)} menit yang lalu`}if(t<86400){return`${Math.floor(t/3600)} jam yang lalu`}return`${Math.floor(t/86400)} hari yang lalu`}(new Date(e.tanggal_pesan));let s={disperindag:"mage:basket-fill",dkpp:"healthicons:plantation-worker-alt",perikanan:"majesticons:fish",dtphp:"mdi:tree"}[e.role.role]??"mdi:alert-circle";n+=`\n            <div class="flex items-start p-4 mb-2 border rounded-lg ${a} cursor-pointer hover:bg-gray-100" \n                onclick="markNotificationAsRead(${e.id})">\n                <iconify-icon \n                    icon="${s}" \n                    class="text-4xl text-pink-600 mr-3">\n                </iconify-icon>\n                <div class="flex-1">\n                    <p class="text-sm ${i} font-bold">\n                        <span class="text-yellow-500">${e.role?.role||"SISTEM"}</span>, \n                        <span class="text-pink-600 font-normal">${e.pesan}</span>\n                    </p>\n                    <span class="text-xs text-gray-400">${o}</span>\n                </div>\n                ${t?"":'<div class="w-2 h-2 bg-red-500 rounded-full mt-2"></div>'}\n            </div>\n\n            `})),s.innerHTML=n}(e.notifications),o.classList.add("hidden"),i.classList.remove("hidden")})).catch((e=>{console.error("Error:",e),o.classList.add("hidden"),i.classList.remove("hidden"),s.innerHTML='<p class="text-gray-500 text-center">Gagal memuat notifikasi</p>'}))}function l(e){e>0?(a.textContent=e>99?"99+":e,a.classList.remove("hidden")):a.classList.add("hidden")}d(),e.addEventListener("click",(function(){n.classList.toggle("hidden"),n.classList.contains("hidden")||d()})),t.addEventListener("click",(function(){n.classList.add("hidden")})),document.addEventListener("click",(function(t){e.contains(t.target)||n.contains(t.target)||n.classList.add("hidden")})),r.addEventListener("click",(function(){fetch(`/pegawai/${dinas}/notifications/mark-read`,{method:"POST",headers:{"Content-Type":"application/json","X-CSRF-TOKEN":document.querySelector('meta[name="csrf-token"]').getAttribute("content")},body:JSON.stringify({})}).then((e=>e.json())).then((e=>{e.success&&d()})).catch((e=>console.error("Error:",e)))})),window.markNotificationAsRead=function(e){fetch(`/pegawai/${dinas}/notifications/mark-read`,{method:"POST",headers:{"Content-Type":"application/json","X-CSRF-TOKEN":document.querySelector('meta[name="csrf-token"]').getAttribute("content")},body:JSON.stringify({notification_id:e})}).then((e=>e.json())).then((e=>{e.success&&d()})).catch((e=>console.error("Error:",e)))},setInterval((function(){n.classList.contains("hidden")&&fetch(`/pegawai/${dinas}/notifications/header`).then((e=>e.json())).then((e=>{l(e.unread_count)})).catch((e=>console.error("Error:",e)))}),3e4)}));
</script>