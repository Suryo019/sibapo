@props(['viewHref', 'createHref', 'viewData', 'createData', 'updateData' => null, 'dataHref', 'dinas' => null,'viewDetailHref' => null])

<li class="mb-2 rounded-lg max-md:bg-pink-650" id="{{ $dinas }}">
  <div class="cursor-pointer toggle-dropdown {{ request()->is($dataHref) ? 'text-yellow-300' : '' }} md:bg-transparent">
    <div class="flex justify-between items-center py-2 rounded-lg hover:bg-pink-600">
      <span class="pl-7 flex items-center gap-5 text-sm">
        <iconify-icon icon="{{ $attributes['icon'] }}" class="text-xl"></iconify-icon>
        {{ $name }}
      </span>
      <i class="caret-icon bi {{ request()->is($dataHref)  ? ' bi-caret-up-fill' : 'bi-caret-down-fill' }}   scale-50 pr-5"></i>
    </div>
  </div>

  <ul class="dropdown-content mt-1 {{ request()->is($dataHref) ? 'block' : 'hidden' }}">
    <li class="pl-[52px] py-1 rounded-md hover:bg-pink-600 {{ request()->url() === $viewHref || request()->url() === $viewDetailHref ? 'bg-pink-450' : '' }}">
      <a href="{{ $viewHref }}" class="rounded py-1 flex items-center gap-5 text-sm">
        <i class="bi bi-eye-fill"></i>
        {{ $viewData }}
      </a>
    </li>
    <li class="pl-[52px] py-1 rounded-md hover:bg-pink-600 {{ request()->url() === $createHref ? 'bg-pink-450' : '' }}">
      <a href="{{ $createHref }}" class="flex items-center gap-5 rounded py-1 text-sm">
        <i class="bi bi-plus-circle-fill"></i>
        {{ $createData }}
      </a>
    </li>
    <li class="pl-[52px] py-1 rounded-md hover:bg-pink-600 {{ request()->is($dinas . '/*/edit') ? 'bg-pink-450 block' : 'hidden' }}" id="editNav">
      <a href="{{ $createHref }}" class="flex items-center gap-5 rounded py-1 text-sm">
        <i class="bi bi-pencil-fill"></i>
        {{ $updateData }}
      </a>
    </li>
  </ul>
</li>

<script>
$(document).ready((function(){$("#{{ $dinas }} .toggle-dropdown").on("click",(function(){const n=$(this).closest("li"),o=n.find(".dropdown-content"),i=n.find(".caret-icon");o.slideToggle(200),i.toggleClass("bi-caret-down-fill bi-caret-up-fill")}))}));
</script>