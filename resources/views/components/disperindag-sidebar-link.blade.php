{{-- @dd($attributes['icon']) --}}

{{-- @props(['viewHref', 'createHref', 'viewData', 'createData', 'updateData' => null, 'dataHref', 'dinas' => null,'viewDetailHref' => null]) --}}

<li class="mb-2 rounded-lg max-md:bg-pink-650" >
    <div class="cursor-pointer toggle-dropdown {{ request()->is('disperindag*') || request()->is('bahan_pokok*') || request()->is('pasar*')  ? 'text-yellow-300' : '' }} md:bg-transparent" id="disperindag">
      <div class="flex justify-between items-center py-2 rounded-lg hover:bg-pink-600">
        <span class="pl-7 flex items-center gap-5 text-sm">
          <iconify-icon icon="mage:basket-fill" class="text-xl"></iconify-icon>
          DISPERINDAG
        </span>
        <i class="caret-icon bi {{ request()->is('disperindag*') || request()->is('bahan_pokok*') || request()->is('pasar*')  ? ' bi-caret-up-fill' : 'bi-caret-down-fill' }}   scale-50 pr-5"></i>
      </div>
    </div>
  
    <ul class="{{ request()->is('disperindag*') || request()->is('bahan_pokok*') || request()->is('pasar*')  ? 'block' : 'hidden' }}" id="dropdown-content">
        <li class="pl-[52px] py-2  " id="kelola_bahan_pokok">
            <div class="flex items-center justify-between cursor-pointer {{ request()->is('bahan_pokok*') ? 'text-yellow-300' : '' }} md:bg-transparent ">
                <span class="flex items-center gap-5 text-sm" >
                    <iconify-icon icon="healthicons:vegetables" class="text-xl"></iconify-icon>
                    Data Bahan Pokok
                </span>
                <i class="caret-icon bi {{ request()->is('bahan_pokok*') ? ' bi-caret-up-fill' : 'bi-caret-down-fill' }}   scale-50 pr-5"></i>
            </div>
        </li>

        <ul class=" mt-1 {{ request()->is('bahan_pokok*') ? 'block' : 'hidden' }}" id="dropdown-content-bahan-pokok">
            @php
                $isView = request()->url() === route('bahan_pokok.index') || request()->url() === route('bahan_pokok.detail');
                $isCreate = request()->url() === route('bahan_pokok.create');
                $isEdit = request()->is('bahan_pokok.edit');
            @endphp
    
                <li class="pl-[84px] py-1 rounded-md hover:bg-pink-600 {{ $isView ? 'bg-pink-450' : '' }}">
                    <a href="{{ route('bahan_pokok.index') }}" class="rounded py-1 flex items-center gap-5 text-sm">
                    <i class="bi bi-eye-fill"></i>
                    Lihat Data
                    </a>
                </li>
    
                <li class="pl-[84px] py-1 rounded-md hover:bg-pink-600 {{ $isCreate ? 'bg-pink-450' : '' }}">
                    <a href="{{ route('bahan_pokok.create') }}" class="flex items-center gap-5 rounded py-1 text-sm">
                    <i class="bi bi-plus-circle-fill"></i>
                    Tambah Data
                    </a>
                </li>
    
                <li class="pl-[84px] py-1 rounded-md hover:bg-pink-600 {{ $isEdit ? 'bg-pink-450 block' : 'hidden' }}" id="editNav">
                    <a href="#" class="flex items-center gap-5 rounded py-1 text-sm">
                    <i class="bi bi-pencil-fill"></i>
                    Ubah Data
                    </a>
                </li>
            </ul>

        <li class="pl-[52px] py-2 " id="kelola_pasar">
            <div class="flex items-center justify-between cursor-pointer {{ request()->is('pasar*') ? 'text-yellow-300' : '' }} md:bg-transparent ">
                <span class="flex items-center gap-5 text-sm">
                    <iconify-icon icon="lsicon:marketplace-filled" class="text-xl"></iconify-icon>
                    Data Pasar
                </span>
                <i class="caret-icon bi {{ request()->is('pasar*')  ? ' bi-caret-up-fill' : 'bi-caret-down-fill' }}   scale-50 pr-5"></i>
            </div>
        </li>

        <ul class=" mt-1 {{ request()->is('pasar*') ? 'block' : 'hidden' }}" id="dropdown-content-kelola-pasar">
            @php
                $isView = request()->url() === route('pasar.index') || request()->url() === route('pasar.detail');
                $isCreate = request()->url() === route('pasar.create');
                $isEdit = request()->is('pasar.edit');
            @endphp
    
                <li class="pl-[84px] py-1 rounded-md hover:bg-pink-600 {{ $isView ? 'bg-pink-450' : '' }}">
                    <a href="{{ route('pasar.index') }}" class="rounded py-1 flex items-center gap-5 text-sm">
                    <i class="bi bi-eye-fill"></i>
                    Lihat Data
                    </a>
                </li>
    
                <li class="pl-[84px] py-1 rounded-md hover:bg-pink-600 {{ $isCreate ? 'bg-pink-450' : '' }}">
                    <a href="{{ route('pasar.create') }}" class="flex items-center gap-5 rounded py-1 text-sm">
                    <i class="bi bi-plus-circle-fill"></i>
                    Tambah Data
                    </a>
                </li>
    
                <li class="pl-[84px] py-1 rounded-md hover:bg-pink-600 {{ $isEdit ? 'bg-pink-450 block' : 'hidden' }}" id="editNav">
                    <a href="#" class="flex items-center gap-5 rounded py-1 text-sm">
                    <i class="bi bi-pencil-fill"></i>
                    Ubah Data
                    </a>
                </li>
            </ul>

        <li class="pl-[52px] py-2"  id="kelola_data">
            <div class="flex items-center justify-between cursor-pointer {{ request()->is('disperindag*') ? 'text-yellow-300' : '' }} md:bg-transparent " >
                <span class="flex items-center gap-5 text-sm">
                    <iconify-icon icon="ooui:chart" class="text-xl"></iconify-icon>
                    Kelola Data
                </span>
                <i class="caret-icon bi {{ request()->is('disperindag*') ? ' bi-caret-up-fill' : 'bi-caret-down-fill' }}   scale-50 pr-5"></i>
            </div>
        </li>

        <ul class=" mt-1 {{ request()->is('disperindag*') ? 'block' : 'hidden' }}" id="dropdown-content-kelola-data">
        @php
            $isView = request()->url() === route('disperindag.index') || request()->url() === route('disperindag.detail');
            $isCreate = request()->url() === route('disperindag.create');
            $isEdit = request()->is('disperindag/*/edit');
        @endphp

            <li class="pl-[84px] py-1 rounded-md hover:bg-pink-600 {{ $isView ? 'bg-pink-450' : '' }}">
                <a href="{{ route('disperindag.index') }}" class="rounded py-1 flex items-center gap-5 text-sm">
                <i class="bi bi-eye-fill"></i>
                Lihat Data
                </a>
            </li>

            <li class="pl-[84px] py-1 rounded-md hover:bg-pink-600 {{ $isCreate ? 'bg-pink-450' : '' }}">
                <a href="{{ route('disperindag.create') }}" class="flex items-center gap-5 rounded py-1 text-sm">
                <i class="bi bi-plus-circle-fill"></i>
                Tambah Data
                </a>
            </li>

            <li class="pl-[84px] py-1 rounded-md hover:bg-pink-600 {{ $isEdit ? 'bg-pink-450 block' : 'hidden' }}" id="editNav">
                <a href="#" class="flex items-center gap-5 rounded py-1 text-sm">
                <i class="bi bi-pencil-fill"></i>
                Ubah Data
                </a>
            </li>
        </ul>
    </ul>
  </li>
  


<script>
  $(document).ready(function () {
    $('#kelola_data').on('click', function () {
      const $dropdown = $("#dropdown-content-kelola-data");
      const $icon = $(this).find('.caret-icon');

      $dropdown.slideToggle(200);
      $icon.toggleClass('bi-caret-down-fill bi-caret-up-fill'); // ganti icon
    });
    
    $('#kelola_pasar').on('click', function () {
      const $dropdown = $("#dropdown-content-kelola-pasar");
      const $icon = $(this).find('.caret-icon');

      $dropdown.slideToggle(200);
      $icon.toggleClass('bi-caret-down-fill bi-caret-up-fill'); // ganti icon
    });

    $('#kelola_bahan_pokok').on('click', function () {
      const $dropdown = $("#dropdown-content-bahan-pokok");
      const $icon = $(this).find('.caret-icon');
        
      $dropdown.slideToggle(200);
      $icon.toggleClass('bi-caret-down-fill bi-caret-up-fill'); // ganti icon
    });

    $('#disperindag').on('click', function () {
      const $dropdown = $("#dropdown-content");
      const $icon = $(this).find('.caret-icon');
        
      $dropdown.slideToggle(200);
      $icon.toggleClass('bi-caret-down-fill bi-caret-up-fill'); // ganti icon
    });
    
  });



</script>
