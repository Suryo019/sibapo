<ul class="max-md:mb-2 max-md:rounded-lg max-md:bg-pink-650">
    {{-- Kelola bahan pokok --}}
    <li class="pl-7 py-2  " id="kelola_bahan_pokok">
        <div class="flex items-center justify-between cursor-pointer {{ request()->is('pegawai/disperindag/bahanpokok*') ? 'text-yellow-300' : '' }} md:bg-transparent ">
            <span class="flex items-center gap-5 text-sm" >
                <iconify-icon icon="healthicons:vegetables" class="text-xl"></iconify-icon>
                Data Bahan Pokok
            </span>
            <i class="caret-icon bi {{ request()->is('pegawai/disperindag/bahanpokok*') ? ' bi-caret-up-fill' : 'bi-caret-down-fill' }} scale-50 pr-5"></i>
        </div>
    </li>

    <ul class=" mt-1 {{ request()->is('pegawai/disperindag/bahanpokok*') ? 'block' : 'hidden' }}" id="dropdown-content-bahan-pokok">
        @php
            $isView = request()->url() === route('pegawai.disperindag.bahanpokok.index') ;
            $isCreate = request()->url() === route('pegawai.disperindag.bahanpokok.create');
            $isEdit = request()->is('pegawai/disperindag/bahanpokok/edit/*');
        @endphp

        <li class="pl-[52px] py-1 rounded-md hover:bg-pink-600 {{ $isView ? 'bg-pink-450' : '' }}">
            <a href="{{ route('pegawai.disperindag.bahanpokok.index') }}" class="rounded py-1 flex items-center gap-5 text-sm">
            <i class="bi bi-eye-fill"></i>
            Lihat Data
            </a>
        </li>
        
        <li class="pl-[52px] py-1 rounded-md hover:bg-pink-600 {{ $isCreate ? 'bg-pink-450' : '' }}">
            <a href="{{ route('pegawai.disperindag.bahanpokok.create') }}" class="flex items-center gap-5 rounded py-1 text-sm">
            <i class="bi bi-plus-circle-fill"></i>
            Tambah Data
            </a>
        </li>
        
        <li class="pl-[52px] py-1 rounded-md hover:bg-pink-600 {{ $isEdit ? 'bg-pink-450 block' : 'hidden' }}" id="editNav">
            <a href="#" class="flex items-center gap-5 rounded py-1 text-sm">
            <i class="bi bi-pencil-fill"></i>
            Ubah Data
            </a>
        </li>
    </ul>
</ul>

<ul class="max-md:mb-2 max-md:rounded-lg max-md:bg-pink-650">
    {{-- Kelola pasar --}}
    <li class="pl-7 py-2 " id="kelola_pasar">
        <div class="flex items-center justify-between cursor-pointer {{ request()->is('pegawai/disperindag/pasar*') ? 'text-yellow-300' : '' }} md:bg-transparent ">
            <span class="flex items-center gap-5 text-sm">
                <iconify-icon icon="lsicon:marketplace-filled" class="text-xl"></iconify-icon>
                Data Pasar
            </span>
            <i class="caret-icon bi {{ request()->is('pegawai/disperindag/pasar*')  ? ' bi-caret-up-fill' : 'bi-caret-down-fill' }} scale-50 pr-5"></i>
        </div>
    </li>

    <ul class=" mt-1 {{ request()->is('pegawai/disperindag/pasar*') ? 'block' : 'hidden' }}" id="dropdown-content-kelola-pasar">
        @php
            $isView = request()->url() === route('pegawai.disperindag.pasar.index') ;
            $isCreate = request()->url() === route('pegawai.disperindag.pasar.create');
            $isEdit = request()->is('pegawai/disperindag/pasar/edit/*');
        @endphp
        <li class="pl-[52px] py-1 rounded-md hover:bg-pink-600 {{ $isView ? 'bg-pink-450' : '' }}">
            <a href="{{ route('pegawai.disperindag.pasar.index') }}" class="rounded py-1 flex items-center gap-5 text-sm">
            <i class="bi bi-eye-fill"></i>
            Lihat Data
            </a>
        </li>

        <li class="pl-[52px] py-1 rounded-md hover:bg-pink-600 {{ $isCreate ? 'bg-pink-450' : '' }}">
            <a href="{{ route('pegawai.disperindag.pasar.create') }}" class="flex items-center gap-5 rounded py-1 text-sm">
            <i class="bi bi-plus-circle-fill"></i>
            Tambah Data
            </a>
        </li>

        <li class="pl-[52px] py-1 rounded-md hover:bg-pink-600 {{ $isEdit ? 'bg-pink-450 block' : 'hidden' }}" id="editNav">
            <a href="#" class="flex items-center gap-5 rounded py-1 text-sm">
            <i class="bi bi-pencil-fill"></i>
            Ubah Data
            </a>
        </li>
    </ul>
</ul>

<ul class="max-md:mb-2 max-md:rounded-lg max-md:bg-pink-650">
    {{-- Kelola Data Disperindag --}}
    <li class="pl-7 py-2"  id="kelola_data">
        <div class="flex items-center justify-between cursor-pointer {{ request()->is('pegawai/disperindag/data*') || request()->is('pegawai/disperindag-detail') ? 'text-yellow-300' : '' }} md:bg-transparent " >
            <span class="flex items-center gap-5 text-sm">
                <iconify-icon icon="ooui:chart" class="text-xl"></iconify-icon>
                Kelola Data
            </span>
            <i class="caret-icon bi {{ request()->is('pegawai/disperindag/data*') || request()->is('pegawai/disperindag-detail') ? ' bi-caret-up-fill' : 'bi-caret-down-fill' }} scale-50 pr-5"></i>
        </div>
    </li>
    
    <ul class=" mt-1 {{ request()->is('pegawai/disperindag/data*') || request()->is('pegawai/disperindag-detail') ? 'block' : 'hidden' }}" id="dropdown-content-kelola-data">
        @php
            $isView = request()->url() === route('pegawai.disperindag.index') || request()->url() === route('pegawai.disperindag.detail');
            $isCreate = request()->url() === route('pegawai.disperindag.create');
            $isEdit = request()->is('pegawai/disperindag/data/edit/*');
        @endphp
    
        <li class="pl-[52px] py-1 rounded-md hover:bg-pink-600 {{ $isView ? 'bg-pink-450' : '' }}">
            <a href="{{ route('pegawai.disperindag.index') }}" class="rounded py-1 flex items-center gap-5 text-sm">
            <i class="bi bi-eye-fill"></i>
            Lihat Data
            </a>
        </li>
    
        <li class="pl-[52px] py-1 rounded-md hover:bg-pink-600 {{ $isCreate ? 'bg-pink-450' : '' }}">
            <a href="{{ route('pegawai.disperindag.create') }}" class="flex items-center gap-5 rounded py-1 text-sm">
            <i class="bi bi-plus-circle-fill"></i>
            Tambah Data
            </a>
        </li>
    
        <li class="pl-[52px] py-1 rounded-md hover:bg-pink-600 {{ $isEdit ? 'bg-pink-450 block' : 'hidden' }}" id="editNav">
            <a href="#" class="flex items-center gap-5 rounded py-1 text-sm">
            <i class="bi bi-pencil-fill"></i>
            Ubah Data
            </a>
        </li>
    </ul>
</ul>

<script>
$(document).ready((function(){$("#kelola_data").on("click",(function(){const o=$("#dropdown-content-kelola-data"),l=$(this).find(".caret-icon");o.slideToggle(200),l.toggleClass("bi-caret-down-fill bi-caret-up-fill")})),$("#kelola_pasar").on("click",(function(){const o=$("#dropdown-content-kelola-pasar"),l=$(this).find(".caret-icon");o.slideToggle(200),l.toggleClass("bi-caret-down-fill bi-caret-up-fill")})),$("#kelola_bahan_pokok").on("click",(function(){const o=$("#dropdown-content-bahan-pokok"),l=$(this).find(".caret-icon");o.slideToggle(200),l.toggleClass("bi-caret-down-fill bi-caret-up-fill")})),$("#disperindag").on("click",(function(){const o=$("#dropdown-content"),l=$(this).find(".caret-icon");o.slideToggle(200),l.toggleClass("bi-caret-down-fill bi-caret-up-fill")}))}));
</script>
