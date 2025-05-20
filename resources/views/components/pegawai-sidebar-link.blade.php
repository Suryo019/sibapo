{{-- @dd($icon) --}}

{{-- @props(['icon' => null]) --}}
@props(['dataHref', 'dinas' => null,'viewDetailHref' => null, 'kelolaData' => null, 'routeKelolaKomoditasView' => null, 'routeKelolaKomoditasCreate' => null, 'routeKelolaKomoditas' => null])

{{-- Data komoditas atau yg lain --}}
<li class="pl-7 py-2" id="{{ 'kelola_komoditas_' . $dinas }}">
  <div class="flex items-center justify-between cursor-pointer {{ request()->is($routeKelolaKomoditas . '*') ? 'text-yellow-300' : '' }} md:bg-transparent ">
      <span class="flex items-center gap-5 text-sm" >
          <iconify-icon icon="healthicons:vegetables" class="text-xl"></iconify-icon>
          {{ $kelolaData }}
      </span>
      <i class="caret-icon bi {{ request()->is($routeKelolaKomoditas . '*') ? ' bi-caret-up-fill' : 'bi-caret-down-fill' }}  scale-50 pr-5"></i>
  </div>
</li>

<ul class=" mt-1 dropdown-content-komoditas {{ request()->is($routeKelolaKomoditas . '*') ? 'block' : 'hidden' }}">
  @php
      $isView = request()->url() === $routeKelolaKomoditasView;
      $isCreate = request()->url() === $routeKelolaKomoditasCreate;
      // $isEdit = request()->is($routeKelolaKomoditas . '.edit');
  @endphp

    <li class="pl-[52px] py-1 rounded-md hover:bg-pink-600 {{ $isView ? 'bg-pink-450' : '' }}">
        <a href="{{ $routeKelolaKomoditasView }}" class="rounded py-1 flex items-center gap-5 text-sm">
        <i class="bi bi-eye-fill"></i>
        Lihat Data
        </a>
    </li>

    <li class="pl-[52px] py-1 rounded-md hover:bg-pink-600 {{ $isCreate ? 'bg-pink-450' : '' }}">
        <a href="{{ $routeKelolaKomoditasCreate }}" class="flex items-center gap-5 rounded py-1 text-sm">
        <i class="bi bi-plus-circle-fill"></i>
        Tambah Data
        </a>
    </li>
</ul>

{{-- Kelola data --}}
<li class="pl-7 py-2" id="{{ 'kelola_data_' . $dinas }}">
  <div class="flex items-center justify-between cursor-pointer {{ request()->is('pegawai/' . $dinas . '*') ? 'text-yellow-300' : '' }} md:bg-transparent " >
      <span class="flex items-center gap-5 text-sm">
          <iconify-icon icon="ooui:chart" class="text-xl"></iconify-icon>
          Kelola Data
      </span>
      <i class="caret-icon bi {{ request()->is('pegawai/' . $dinas . '*') ? ' bi-caret-up-fill' : 'bi-caret-down-fill' }}   scale-50 pr-5"></i>
  </div>
</li>

<ul class="mt-1 dropdown-content-kelola-data {{ request()->is($dataHref) ? 'block' : 'hidden' }}">
  <li class="pl-[52px] py-1 rounded-md hover:bg-pink-600 {{ request()->is('pegawai/' . $dinas . '*') || request()->is('pegawai/' . $dinas . '-detail*') ? 'bg-pink-450' : '' }}">
    <a href="{{ route('pegawai.' . $dinas . '.index') }}" class="rounded py-1 flex items-center gap-5 text-sm">
      <i class="bi bi-eye-fill"></i>
      Lihat Data
    </a>
  </li>
  <li class="pl-[52px] py-1 rounded-md hover:bg-pink-600 {{ request()->is('pegawai/' . $dinas . '/create')  ? 'bg-pink-450' : '' }}">
    <a href="{{ route('pegawai.' . $dinas . '.create') }}" class="flex items-center gap-5 rounded py-1 text-sm">
      <i class="bi bi-plus-circle-fill"></i>
      Tambah Data
    </a>
  </li>
  <li class="pl-[52px] py-1 rounded-md hover:bg-pink-600 {{ request()->is('pegawai/' . $dinas . '/*/edit') ? 'bg-pink-450 block' : 'hidden' }}" id="editNav">
    <a href="#" class="flex items-center gap-5 rounded py-1 text-sm">
      <i class="bi bi-pencil-fill"></i>
      Ubah Data
    </a>
  </li>
</ul>

<script>
  $(document).ready(function () {
    $("#kelola_data_{{ $dinas }}").on('click', function () {
      const $dropdown = $(this).next("ul.dropdown-content-kelola-data");
      const $icon = $(this).find('.caret-icon');

      $dropdown.slideToggle(200);
      $icon.toggleClass('bi-caret-down-fill bi-caret-up-fill');
    });

    $('#kelola_komoditas_{{ $dinas }}').on('click', function () {
      const $dropdown = $(this).next("ul.dropdown-content-komoditas");
      const $icon = $(this).find('.caret-icon');

      $dropdown.slideToggle(200);
      $icon.toggleClass('bi-caret-down-fill bi-caret-up-fill');
    });
  });
</script>