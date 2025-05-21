{{-- @dd($attributes['dinas_komoditas_route']) --}}

@props(['dinas' => null, 'dinas_komoditas_route' => null])

<li class="pl-[52px] py-2  " id="{{ 'kelola_komoditas_' . $dinas }}">
    <div class="flex items-center justify-between cursor-pointer {{ request()->is($dinas_komoditas_route . '*') ? 'text-yellow-300' : '' }} md:bg-transparent ">
        <span class="flex items-center gap-5 text-sm" >
            <iconify-icon icon="healthicons:vegetables" class="text-xl"></iconify-icon>
            {{ $slot }}
        </span>
        <i class="caret-icon bi {{ request()->is($dinas_komoditas_route . '*') ? ' bi-caret-up-fill' : 'bi-caret-down-fill' }}  scale-50 pr-5"></i>
    </div>
</li>

<ul class=" mt-1 {{ request()->is($dinas_komoditas_route . '*') ? 'block' : 'hidden' }}" id="dropdown-content-komoditas">
@php
    $isView = request()->url() === route($dinas_komoditas_route . '.index') || request()->url() === route($dinas_komoditas_route . '.detail');
    $isCreate = request()->url() === route($dinas_komoditas_route . '.create');
    // $isEdit = request()->is($dinas_komoditas_route . '.edit');
@endphp

    <li class="pl-[84px] py-1 rounded-md hover:bg-pink-600 {{ $isView ? 'bg-pink-450' : '' }}">
        <a href="{{ route($dinas_komoditas_route . '.index') }}" class="rounded py-1 flex items-center gap-5 text-sm">
        <i class="bi bi-eye-fill"></i>
        Lihat Data
        </a>
    </li>

    <li class="pl-[84px] py-1 rounded-md hover:bg-pink-600 {{ $isCreate ? 'bg-pink-450' : '' }}">
        <a href="{{ route($dinas_komoditas_route . '.create') }}" class="flex items-center gap-5 rounded py-1 text-sm">
        <i class="bi bi-plus-circle-fill"></i>
        Tambah Data
        </a>
    </li>

    {{-- <li class="pl-[84px] py-1 rounded-md hover:bg-pink-600 {{ $isEdit ? 'bg-pink-450 block' : 'hidden' }}" id="{{ 'editNav' . $dinas }}">
        <a href="#" class="flex items-center gap-5 rounded py-1 text-sm">
        <i class="bi bi-pencil-fill"></i>
        Ubah Data
        </a>
    </li> --}}
</ul>
    
{{-- Yg dibutuin : 1. nama dinas ($dinas), 2. rute komoditas ($dinas_komoditas_route), 3. $slot buat nama menu --}}

<script>
    
$('#kelola_komoditas_{{ $dinas }}').on('click', function () {
    const $dropdown = $("#dropdown-content-komoditas");
    const $icon = $(this).find('.caret-icon');

    $dropdown.slideToggle(200);
    $icon.toggleClass('bi-caret-down-fill bi-caret-up-fill');
});

</script>