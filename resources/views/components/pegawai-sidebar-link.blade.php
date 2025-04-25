{{-- @dd($icon) --}}

@props(['icon' => null])

<li {{ $attributes }}>
    {{-- <iconify-icon icon="{{ $icon }}" class="text-xl"></iconify-icon> --}}
    <a href="{{ $attributes['href'] }}" class="pl-4 gap-5 w-full flex items-center">
        <i class="bi {{ $icon }}"></i>
        {{ $slot }}
    </a>
</li>