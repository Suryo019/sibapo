{{-- @dd($attributes) --}}

@props(['viewData', 'createData'])

<li class="mb-2" id={{ $name }}>
    <details class="group rounded-md cursor-pointer">
      <summary class="list-none rounded-md {{ request()->is($attributes->get('dataHref')) ? 'text-yellow-300' : '' }}">
        <div class="flex justify-between items-center py-2 px-4 rounded hover:bg-green-800">
          <span>{{ $name }}</span>
          <i class="caret-icon bi bi-caret-down-fill scale-50"></i>
        </div>
      </summary>
      <ul class="ml-4 mt-1 pb-2">
        <li>
          <a {{ $createData->attributes }} class="block py-1 px-2 rounded">{{ $createData }}</a>
        </li>
        <li>
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