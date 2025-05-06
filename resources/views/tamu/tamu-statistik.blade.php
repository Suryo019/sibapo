<x-tamu-layout>
    <div class="w-full flex flex-col justify-center items-center text-pink-600 mb-10 relative px-4 sm:px-0">
        <h1 class="text-4xl sm:text-5xl font-extrabold mb-4 text-center">Statistik Harga</h1>
        <h5 class="text-base sm:text-xl mb-8 text-center">Data perubahan harga setiap komoditas dalam 1 bulan</h5>
    
        {{-- Filter Desktop --}}
        <form action="{{ route('tamu.komoditas') }}" method="GET"
            class="hidden sm:flex gap-4 flex-wrap justify-center items-center">
            @csrf
            <select name="sorting_category" class="border border-pink-600 px-4 py-2 rounded-full bg-white text-sm text-gray-600">
                <option value="pasar">Per Pasar</option>
                <option value="jenis_bahan_pokok">Per Bahan Pokok</option>
            </select>
            <select name="sorting_item" class="border border-pink-600 px-4 py-2 rounded-full bg-white text-sm text-gray-600">
                @foreach ($markets as $market)
                    <option value="{{ $market->pasar }}">{{ $market->pasar }}</option>
                @endforeach
            </select>
            <input type="month" name="periode" value="{{ date('Y-m') }}"
                class="border border-pink-600 px-4 py-2 rounded-full bg-white text-sm text-gray-600">
            <input type="text" name="search" placeholder="Cari Bahan Pokok"
                class="pl-10 pr-4 py-2 border border-pink-600 rounded-full bg-white text-sm text-gray-600 placeholder-gray-500">
        </form>
    
        {{-- Filter Mobile --}}
        <div class="relative w-full sm:hidden flex flex-col items-center">
            <button onclick="toggleMobileFilter()" type="button"
                class="bg-pink-500 hover:bg-pink-600 text-white font-bold py-3 px-8 rounded-full text-base shadow-lg flex items-center gap-2">
                <i class="bi bi-funnel-fill text-lg"></i> Filter
            </button>
            <form id="mobileFilterDropdown"
                class="absolute z-50 hidden top-full mt-2 w-11/12 bg-white rounded-xl shadow-xl border border-pink-300 p-5">
                <div class="flex justify-between items-center mb-4">
                    <h2 class="text-pink-600 text-lg font-semibold text-center w-full">Filter</h2>
                    <button type="button" onclick="toggleMobileFilter()" class="text-gray-400 hover:text-pink-500 text-xl font-bold absolute top-4 right-4">&times;</button>
                </div>
    
                <div class="flex flex-col gap-4">
                    <select name="sorting_category"
                        class="w-full border border-gray-300 px-4 py-2 rounded-full text-sm text-gray-600">
                        <option value="pasar">Per Pasar</option>
                        <option value="jenis_bahan_pokok">Per Bahan Pokok</option>
                    </select>
    
                    <select name="sorting_item"
                        class="w-full border border-gray-300 px-4 py-2 rounded-full text-sm text-gray-600">
                        @foreach ($markets as $market)
                            <option value="{{ $market->pasar }}">{{ $market->pasar }}</option>
                        @endforeach
                    </select>
    
                    <input type="month" name="periode" value="{{ date('Y-m') }}"
                        class="w-full border border-gray-300 px-4 py-2 rounded-full text-sm text-gray-600">
                </div>
    
                <div class="flex justify-end gap-3 mt-6">
                    <button type="reset"
                        class="px-4 py-2 text-sm font-semibold text-yellow-600 border border-yellow-400 rounded-full hover:bg-yellow-100">Reset</button>
                    <button type="submit"
                        class="px-6 py-2 text-sm font-semibold text-white bg-pink-600 hover:bg-pink-700 rounded-full">Cari</button>
                </div>
            </form>
        </div>
    </div>
    
    {{-- Table --}}
    <div class="w-full overflow-x-auto px-4 sm:px-0 relative max-w-7xl mx-auto">
        <table class="min-w-[700px] sm:min-w-full border-separate border-spacing-y-2 text-sm text-gray-700">
            <thead class="sticky top-0 z-10 bg-white">
                <tr class="shadow-md rounded-3xl bg-white text-pink-600">
                    <th class="px-3 py-3 text-center font-semibold rounded-l-full text-xs sm:text-sm">No</th>
                    <th class="px-3 py-3 text-center font-semibold text-xs sm:text-sm">Komoditas</th>
                    @for ($i = 1; $i <= 30; $i++)
                        <th class="px-3 py-3 text-center font-semibold text-xs sm:text-sm {{ $i == 30 ? 'rounded-r-full' : '' }}">{{ $i }}</th>
                    @endfor
                </tr>
            </thead>
            <tbody>
                {{-- pake ajax ntar --}}
            </tbody>
        </table>
    </div>
</x-tamu-layout>

{{-- <script src="{{ asset('/js/tamu-statistik.js') }}"></script> --}}

<script>
  $(document).ready(function () {
    const sorting_category = $("#sorting_category");
    const sorting_item_list_container = $("#sorting_item_list_container");
    const sorting_item_list_container_injector = $(
        "#sorting_item_list_container_injector"
    );
    const sorting_item_list_input = $("#sorting_item_list_input");
    const periode = $("#periode");
    const search = $("#search");

    // Ubah sorting child items
    sorting_category.on("change", function () {
        const value = $(this).val();
        $.ajax({
            type: "GET",
            url: `/api/sorting_items`,
            data: { data: value },
            success: function (response) {
                const results = response.data;

                let list_items = ``;
                let url = "";

                if (value == "pasar") {
                    $.each(results, function (index, value) {
                        list_items += `
                <li data-pasar="${value.nama_pasar}" class="p-2 hover:bg-pink-50 text-sm cursor-pointer sorting_item_list">${value.nama_pasar}</li>
              `;
                    });

                    sorting_item_list_input.val(results[0].nama_pasar);
                    url = "/api/statistik_pasar";
                } else if (value == "jenis_bahan_pokok") {
                    $.each(results, function (index, value) {
                        list_items += `
                <li data-jenis_bahan_pokok="${value.nama_bahan_pokok}" class="p-2 hover:bg-pink-50 text-sm cursor-pointer sorting_item_list">${value.nama_bahan_pokok}</li>
              `;
                    });
                    sorting_item_list_input.val(results[0].nama_bahan_pokok);
                    url = "/api/statistik_jenis_bahan_pokok";
                }

                sorting_item_list_container_injector.html(list_items);

                filter(url, sorting_item_list_input.val());
            },
            error: function (xhr, status, error) {
                let errors = xhr.responseJSON.errors;
                let message = "";

                $.each(errors, function (key, value) {
                    message += value + "<br>";
                });
                console.log(message);
            },
        });
    });

    // Toggle Sorting Child Container
    $("#sorting_child").on("click", function () {
        sorting_item_list_container.toggleClass("hidden");
    });

    // String matching
    sorting_item_list_input.on("input", function () {
        sorting_item_list_container.removeClass("hidden");

        const input_value = $(this).val().toLowerCase();
        const list_items = sorting_item_list_container_injector.find("li");

        list_items.each(function () {
            const item_text = $(this).text().toLowerCase();

            if (item_text.includes(input_value)) {
                $(this).removeClass("hidden");
            } else {
                $(this).addClass("hidden");
            }
        });
    });

    // Filter Bahan Pokok
    filter("/api/statistik_pasar", sorting_item_list_input.val());

    function filter(url, selectedValue) {
        sorting_item_list_container.addClass("hidden");

        $.ajax({
            type: "GET",
            url: url,
            data: {
                data: selectedValue,
                periode: periode.val(),
            },
            success: function (response) {
                const data = response.data;
                const jumlahHari = response.jumlahHari;

                // Render THEAD
                let theadHtml = `
            <tr class="shadow-pink-hard rounded-3xl bg-white">
              <th class="px-4 py-5 text-center font-semibold rounded-l-3xl">No</th>
              <th class="px-4 py-5 text-center font-semibold whitespace-nowrap">Pasar</th>
              <th class="px-4 py-5 text-center font-semibold whitespace-nowrap">Bahan Pokok</th>
          `;

                for (let i = 1; i <= jumlahHari; i++) {
                    const roundedClass =
                        i === jumlahHari ? "rounded-r-full" : "";
                    theadHtml += `<th class="px-4 py-5 text-center font-semibold ${roundedClass}">${i}</th>`;
                }

                theadHtml += `</tr>`;
                $("#comoditiesThead").html(theadHtml);

                // Render TBODY
                let tbodyHtml = "";

                if (Object.keys(data).length === 0) {
                    tbodyHtml = `
              <tr class="bg-white">
                <td colspan="${
                    3 + jumlahHari
                }" class="py-5 px-8 bg-pink-50 text-gray-500 italic">
                  Data tidak ditemukan.
                </td>
              </tr>
            `;
                } else {
                    let index = 1;
                    Object.values(data).forEach((row) => {
                        tbodyHtml += `
                <tr class="bg-white hover:bg-pink-50 rounded-full shadow-pink-hard transition duration-150">
                  <td class="px-4 py-3 text-center rounded-l-full">${index++}</td>
                  <td class="px-4 py-3 text-center whitespace-nowrap">${
                      row.pasar
                  }</td>
                  <td class="px-4 py-3 text-center whitespace-nowrap jenis_bahan_pokok_col">${
                      row.jenis_bahan_pokok
                  }</td>
              `;

                        for (let i = 1; i <= jumlahHari; i++) {
                            const harga = row.harga_per_tanggal[i] ?? "-";
                            const roundedClass =
                                i === jumlahHari ? "rounded-r-full" : "";
                            tbodyHtml += `<td class="px-4 py-3 text-center ${roundedClass} whitespace-nowrap">Rp. ${harga}</td>`;
                        }

                        tbodyHtml += "</tr>";
                    });
                }

                $("#comoditiesTbody").html(tbodyHtml);
            },
            error: function (xhr, status, error) {
                let errors = xhr.responseJSON.errors;
                let message = "";

                $.each(errors, function (key, value) {
                    message += value + "<br>";
                });
                console.log(message);
            },
        });
    }

    $("#periode").on("change", function () {
        const data_for_period = sorting_item_list_input.val();
        if (sorting_category.val() == "pasar") {
            filter(`/api/statistik_pasar`, data_for_period);
        } else if (sorting_category.val() == "jenis_bahan_pokok") {
            filter(`/api/statistik_jenis_bahan_pokok`, data_for_period);
        }
    });

    $(document).on("click", ".sorting_item_list", function () {
        if (sorting_category.val() == "pasar") {
            const pasar = $(this).data("pasar");
            sorting_item_list_input.val(pasar);
            filter(`/api/statistik_pasar`, pasar);
        } else if (sorting_category.val() == "jenis_bahan_pokok") {
            const jenis_bahan_pokok = $(this).data("jenis_bahan_pokok");
            sorting_item_list_input.val(jenis_bahan_pokok);
            filter(`/api/statistik_jenis_bahan_pokok`, jenis_bahan_pokok);
        }
    });

    // Search berdasarkan data yang udah tampell
    search.on("input", function () {
        const input_value = $(this).val().toLowerCase();
        let jenis_bahan_pokok_col = $(".jenis_bahan_pokok_col");

        jenis_bahan_pokok_col.each(function () {
            let item_text = $(this).text().toLowerCase();

            if (item_text.includes(input_value)) {
                $(this).parent().removeClass("hidden");
            } else {
                $(this).parent().addClass("hidden");
            }
        });
    });
});


//button filter buat mobile

function toggleMobileFilter() {
        const dropdown = document.getElementById('mobileFilterDropdown');
        dropdown.classList.toggle('hidden');
    }
</script>