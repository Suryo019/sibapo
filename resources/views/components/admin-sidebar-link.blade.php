{{-- @dd($attributes) --}}

@props(['viewData', 'createData'])

<li class="mb-2" id={{ $name }}>
    <details class="group rounded-md cursor-pointer">
      <summary class="list-none rounded-md {{ request()->is($attributes->get('dataHref')) ? 'text-yellow-300' : '' }} bg-green-900 md:bg-transparent">
        <div class="flex justify-between items-center py-2 px-4 rounded hover:bg-green-800">
          <span>{{ $name }}</span>
          <i class="caret-icon bi bi-caret-down-fill scale-50"></i>
        </div>
      </summary>
      <ul class="mt-1 pb-2 bg-green-910 rounded-md overflow-hidden">
        <li class="pl-4 hover:bg-green-800">
          <a {{ $createData->attributes }} class="block py-1 px-2 rounded">{{ $createData }}</a>
        </li>
        <li class="pl-4 hover:bg-green-800">
          <a {{ $viewData->attributes }} class="block py-1 px-2 rounded">{{ $viewData }}</a>
        </li>
      </ul>
    </details>
</li>

<script>
  $('#{{ $name }}').click(function(){
    $(this).children().toggleClass("bg-green-910");
    $(this).find('.caret-icon').toggleClass('bi-caret-down-fill');
    $(this).find('.caret-icon').toggleClass('bi-caret-up-fill');
  })
</script>