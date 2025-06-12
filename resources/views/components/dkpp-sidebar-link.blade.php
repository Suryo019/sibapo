<li class="pl-[52px] py-2  " id="kelola_dkpp_komoditas">
    <div class="flex items-center justify-between cursor-pointer {{ request()->is('dkpp_komoditas*') ? 'text-yellow-300' : '' }} md:bg-transparent ">
        <span class="flex items-center gap-5 text-sm" >
            <iconify-icon icon="healthicons:vegetables" class="text-xl"></iconify-icon>
            Data Komoditas
        </span>
        <i class="caret-icon bi {{ request()->is('dkpp_komoditas*') ? ' bi-caret-up-fill' : 'bi-caret-down-fill' }}  scale-50 pr-5"></i>
    </div>
</li>

<ul class=" mt-1 {{ request()->is('dkpp_komoditas*') ? 'block' : 'hidden' }}" id="dropdown-content-komoditas">
@php
    $isView = request()->url() === route('dkpp_komoditas.index') || request()->url() === route('dkpp_komoditas.detail');
    $isCreate = request()->url() === route('dkpp_komoditas.create');
    $isEdit = request()->is('dkpp_komoditas.edit');
@endphp

    <li class="pl-[84px] py-1 rounded-md hover:bg-pink-600 {{ $isView ? 'bg-pink-450' : '' }}">
        <a href="{{ route('dkpp_komoditas.index') }}" class="rounded py-1 flex items-center gap-5 text-sm">
        <i class="bi bi-eye-fill"></i>
        Lihat Data
        </a>
    </li>

    <li class="pl-[84px] py-1 rounded-md hover:bg-pink-600 {{ $isCreate ? 'bg-pink-450' : '' }}">
        <a href="{{ route('dkpp_komoditas.create') }}" class="flex items-center gap-5 rounded py-1 text-sm">
        <i class="bi bi-plus-circle-fill"></i>
        Tambah Data
        </a>
    </li>

    <li class="pl-[84px] py-1 rounded-md hover:bg-pink-600 {{ $isEdit ? 'bg-pink-450 block' : 'hidden' }}" id="editNavDkpp">
        <a href="#" class="flex items-center gap-5 rounded py-1 text-sm">
        <i class="bi bi-pencil-fill"></i>
        Ubah Data
        </a>
    </li>
</ul>
    
<script>
$("#kelola_dkpp_komoditas").on("click",(function(){const o=$("#dropdown-content-komoditas"),i=$(this).find(".caret-icon");o.slideToggle(200),i.toggleClass("bi-caret-down-fill bi-caret-up-fill")}));
</script>