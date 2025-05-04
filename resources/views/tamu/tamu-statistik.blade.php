<x-tamu-layout>
    <div class="w-full flex flex-col justify-center items-center text-pink-650 mb-16">
        <h1 class="text-5xl font-extrabold mb-8">Statistik Harga</h1>
        <h5 class="text-xl text-shadow mb-16">Data perubahan harga setiap bahan pokok dalam 1 bulan</h5>
        <form action="{{ route('tamu.komoditas') }}" method="GET" class="flex flex-wrap gap-16 items-center">
            @csrf
        
            {{-- Sorting Root --}}
            <div>
                <select name="sorting_category" id="sorting_category" class="border border-pink-650 px-4 py-2 rounded-full bg-white text-sm text-gray-500 focus:outline-none">
                    <option value="pasar">Per Pasar</option>
                    <option value="jenis_bahan_pokok">Per Bahan Pokok</option>
                </select>
            </div>
        
            {{-- Sorting Child --}}
            <div>
                <div class="relative flex flex-col">
                  <div class="border border-pink-650 px-4 py-2 rounded-full bg-white text-sm text-gray-500 focus:outline-none flex items-center" id="sorting_child">
                    <input type="text" value="{{ $markets[0]->pasar }}" class="focus:outline-none flex-shrink" id="sorting_item_list_input">
                    <i class="bi bi-caret-down-fill text-pink-650 text-xs"></i>
                  </div>
                  <ul class="bg-white border border-pink-650 rounded-2xl max-h-60 w-full absolute z-20 top-10 overflow-y-auto hidden" id="sorting_item_list_container">
                    <div class="overflow-hidden w-full h-full border-pink-650 rounded-2xl" id="sorting_item_list_container_injector">
                      @foreach ($markets as $data)
                          <li data-pasar="{{ $data->pasar }}" class="p-2 hover:bg-pink-50 text-sm cursor-pointer sorting_item_list">{{ $data->pasar }}</li>
                      @endforeach
                    </div>
                  </ul>
                </div>
            </div>
        
            {{-- Tanggal (Bulan) --}}
            <div>
                <input type="month" name="periode" id="periode"
                    value="{{ date('Y-m') }}"
                    class="border border-pink-650 px-4 py-2 rounded-full bg-white text-sm text-gray-500 focus:outline-none">
            </div>
        
            {{-- Cari Bahan Pokok --}}
            <div class="relative">
                <i class="bi bi-search absolute left-3 top-1/2 transform -translate-y-1/2 text-pink-650"></i>
                <input type="text" name="search" placeholder="Cari Bahan Pokok"
                    class="pl-10 pr-4 py-2 border border-pink-650 rounded-full bg-white text-sm text-gray-500 focus:outline-none placeholder-gray-500">
            </div>
        </form>
    </div>

    {{-- Daftar Komoditas --}}
    <div class="w-[90%] max-w-7xl overflow-auto max-h-screen mx-auto rounded-lg" id="comoditiesList">
      <table class="min-w-full border-separate border-spacing-y-1 text-sm text-gray-700">
        <thead class="sticky top-0 z-10 bg-white" id="comoditiesThead">
          <tr class="shadow-pink-hard rounded-3xl bg-white">
            <th class="px-4 py-5 text-center font-semibold rounded-l-3xl">No</th>
            <th class="px-4 py-5 text-center font-semibold whitespace-nowrap">Pasar</th>
            <th class="px-4 py-5 text-center font-semibold whitespace-nowrap">Bahan Pokok</th>
            @for ($i = 1; $i <= 30; $i++)
              <th class="px-4 py-5 text-center font-semibold {{ $i == 30 ? 'rounded-r-full' : '' }}">{{ $i }}</th>
            @endfor
          </tr>
        </thead>
        <tbody id="comoditiesTbody">
          {{-- Pake ajax ntar --}}
        </tbody>
      </table>
    </div>
</x-tamu-layout>

<script>

$(document).ready(function() {
  const sorting_category = $('#sorting_category');
  const sorting_item_list_container = $('#sorting_item_list_container');
  const sorting_item_list_container_injector = $('#sorting_item_list_container_injector');
  const sorting_item_list_input = $('#sorting_item_list_input');
  const periode = $('#periode');
  
  // Ubah sorting child items
  sorting_category.on('change', function() {
    const value = $(this).val();
    $.ajax({
      type: 'GET',
      url: `{{ route('api.sorting_items') }}`,
      data: { data: value },
      success: function (response) {
        const results = response.data;
        let list_items = ``;
        let url = ''
  
        if (value == 'pasar') {
          $.each(results, function (index, value) {
            list_items += `
              <li data-pasar="${value.pasar}" class="p-2 hover:bg-pink-50 text-sm cursor-pointer sorting_item_list">${value.pasar}</li>
            `;
          });
  
          sorting_item_list_input.val(results[0].pasar);
          url = '/api/statistik_pasar';
        } else if (value == 'jenis_bahan_pokok') {
          $.each(results, function (index, value) {
            list_items += `
              <li data-jenis_bahan_pokok="${value.jenis_bahan_pokok}" class="p-2 hover:bg-pink-50 text-sm cursor-pointer sorting_item_list">${value.jenis_bahan_pokok}</li>
            `;
          });
          sorting_item_list_input.val(results[0].jenis_bahan_pokok);
          url = '/api/statistik_jenis_bahan_pokok';
        }
  
        sorting_item_list_container_injector.html(list_items);

        // filter(url, sorting_item_list_input.val())
      },
      error: function(xhr, status, error) {
      let errors = xhr.responseJSON.errors;
      let message = '';
  
      $.each(errors, function(key, value) {
          message += value + '<br>';
      });
      console.log(message);
      }
    });
  
  
  });
  
  $('#sorting_child').on('click', function() {
    sorting_item_list_container.toggleClass('hidden');
  });
  
  filter('/api/statistik_pasar', sorting_item_list_input.val());
  
  function filter(url, selectedValue) {
    sorting_item_list_container.addClass('hidden');
  
    $.ajax({
      type: 'GET',
      url: url,
      data: {
        data: selectedValue,
        periode: periode.val(),
      },
      success: function(response) {
        const data = response.data;
        const jumlahHari = response.jumlahHari;

        console.log(data);
        
  
        // 1. Render THEAD
        let theadHtml = `
          <tr class="shadow-pink-hard rounded-3xl bg-white">
            <th class="px-4 py-5 text-center font-semibold rounded-l-3xl">No</th>
            <th class="px-4 py-5 text-center font-semibold whitespace-nowrap">Pasar</th>
            <th class="px-4 py-5 text-center font-semibold whitespace-nowrap">Bahan Pokok</th>
        `;

  
        for (let i = 1; i <= jumlahHari; i++) {
          const roundedClass = (i === jumlahHari) ? 'rounded-r-full' : '';
          theadHtml += `<th class="px-4 py-5 text-center font-semibold ${roundedClass}">${i}</th>`;
        }
  
        theadHtml += `</tr>`;
        $('#comoditiesThead').html(theadHtml);
  
        // 2. Render TBODY
        let tbodyHtml = '';
        let index = 1;
  
        Object.values(data).forEach(row => {
          tbodyHtml += `
            <tr class="bg-white hover:bg-pink-50 rounded-full shadow-pink-hard transition duration-150">
              <td class="px-4 py-3 text-center rounded-l-full">${index++}</td>
              <td class="px-4 py-3 text-center whitespace-nowrap">${row.pasar}</td>
              <td class="px-4 py-3 text-center whitespace-nowrap">${row.jenis_bahan_pokok}</td>
          `;

  
          for (let i = 1; i <= jumlahHari; i++) {
            const harga = row.harga_per_tanggal[i] ?? '-';
            const roundedClass = (i === jumlahHari) ? 'rounded-r-full' : '';
            tbodyHtml += `<td class="px-4 py-3 text-center ${roundedClass} whitespace-nowrap">Rp. ${harga}</td>`;
          }
  
          tbodyHtml += '</tr>';
        });
  
        $('#comoditiesTbody').html(tbodyHtml);
      },
      error: function(xhr, status, error) {
        let errors = xhr.responseJSON.errors;
        let message = '';
  
        $.each(errors, function(key, value) {
            message += value + '<br>';
        });
        console.log(message);
        }
    });
  }

  $('#periode').on('change', function() {
    const data_for_period = sorting_item_list_input.val();
    if (sorting_category.val() == 'pasar') {
      filter(`/api/statistik_pasar`, data_for_period);
    } else if (sorting_category.val() == 'jenis_bahan_pokok') {
      filter(`/api/statistik_jenis_bahan_pokok`, data_for_period);
    }
  })
  
  $(document).on('click', '.sorting_item_list', function() {
    if (sorting_category.val() == 'pasar') {
      const pasar = $(this).data('pasar');
      sorting_item_list_input.val(pasar);
      filter(`/api/statistik_pasar`, pasar);
    } else if (sorting_category.val() == 'jenis_bahan_pokok') {
      const jenis_bahan_pokok = $(this).data('jenis_bahan_pokok');
      sorting_item_list_input.val(jenis_bahan_pokok);
      filter(`/api/statistik_jenis_bahan_pokok`, jenis_bahan_pokok);
    }
  });
});


</script>