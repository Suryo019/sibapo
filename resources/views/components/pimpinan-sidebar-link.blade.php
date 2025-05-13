{{-- @dd($icon) --}}

@props(['icon' => null])

<li {{ $attributes }}>
    <a href="{{ $attributes['href'] }}" class="pl-4 gap-5 w-full flex items-center">
        {{ $slot }}
    </a>
</li>