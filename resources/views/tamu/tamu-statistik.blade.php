<x-tamu-layout title="Statistik">
<div class="w-full flex flex-col justify-center items-center text-pink-650 mb-16">
    <h1 class="text-5xl font-extrabold mb-8 ">Statistik Harga</h1>
    <h5 class="text-xl text-shadow mb-16 mx-6 text-center">Data perubahan harga setiap bahan pokok dalam 1 bulan</h5>

    {{-- filter dekstop --}}
    <form action="{{ route('tamu.komoditas') }}" method="GET" class="hidden md:flex flex-wrap gap-6 items-center justify-center">
        @csrf

        {{-- Sorting Root --}}
        <div>
            <select name="sorting_category" id="sorting_category"
                class="border border-pink-650 px-4 py-2 rounded-full bg-white text-sm text-gray-500 focus:outline-none">
                <option value="pasar">Per Pasar</option>
                <option value="jenis_bahan_pokok">Per Bahan Pokok</option>
            </select>
        </div>

        {{-- Sorting Child --}}
        <div class="relative flex flex-col">
            <div class="border border-pink-650 px-4 py-2 rounded-full bg-white text-sm text-gray-500 flex items-center cursor-pointer"
                id="sorting_child">
                <input type="text" value="{{ $markets[0]->nama_pasar }}" class="focus:outline-none flex-shrink"
                    id="sorting_item_list_input" name="market" autocomplete="off" readonly>
                <i class="bi bi-caret-down-fill text-pink-650 text-xs ml-2"></i>
            </div>
            <ul class="bg-white border border-pink-650 rounded-2xl max-h-60 w-full absolute z-20 top-12 overflow-y-auto hidden"
                id="sorting_item_list_container">
                <div class="overflow-hidden w-full h-full border-pink-650 rounded-2xl p-1"
                    id="sorting_item_list_container_injector">
                    @foreach ($markets as $data)
                        <li data-pasar="{{ $data->nama_pasar }}"
                            class="p-2 hover:bg-pink-50 text-sm cursor-pointer sorting_item_list">
                            {{ $data->nama_pasar }}
                        </li>
                    @endforeach
                </div>
            </ul>
        </div>

        {{-- Periode --}}
        <div>
            <input type="month" name="periode" id="periode" value="{{ date('Y-m') }}"
                class="border border-pink-650 px-4 py-2 rounded-full bg-white text-sm text-gray-500 focus:outline-none">
        </div>

        {{-- Search --}}
        <div class="relative">
            <i class="bi bi-search absolute left-3 top-1/2 transform -translate-y-1/2 text-pink-650"></i>
            <input type="text" name="search" id="search" placeholder="Cari Bahan Pokok"
                class="pl-10 pr-4 py-2 border border-pink-650 rounded-full bg-white text-sm text-gray-500 focus:outline-none placeholder-gray-500">
        </div>
    </form>

    {{-- Button filter --}}
    <div class="w-full flex justify-center mt-6 md:hidden relative">
        <button id="mobileFilterBtn"
            class="bg-pink-600 text-white px-6 py-2 rounded-full shadow hover:bg-pink-700 focus:outline-none flex items-center gap-2">
            <i class="bi bi-funnel-fill"></i> Filter
        </button>

        {{-- dropdown --}}
        <div id="mobileFilterDropdown"
            class="absolute top-14 w-[95%] max-w-md bg-white border border-pink-200 rounded-2xl shadow-xl p-6 z-50 hidden">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-lg font-semibold text-pink-600">Filter</h2>
                <button id="closeFilterDropdown"
                    class="text-xl text-gray-600 hover:text-red-500 font-bold">&times;</button>
            </div>
            <form action="{{ route('tamu.komoditas') }}" method="GET" class="flex flex-col gap-4">
                @csrf
                <select name="sorting_category"
                    class="border px-4 py-2 rounded-full bg-white text-sm text-gray-500">
                    <option value="pasar">Per Pasar</option>
                    <option value="jenis_bahan_pokok">Per Bahan Pokok</option>
                </select>

                <select name="market"
                    class="border px-4 py-2 rounded-full bg-white text-sm text-gray-500">
                    @foreach ($markets as $data)
                        <option value="{{ $data->nama_pasar }}">{{ $data->nama_pasar }}</option>
                    @endforeach
                </select>

                <input type="month" name="periode" value="{{ date('Y-m') }}"
                    class="border px-4 py-2 rounded-full bg-white text-sm text-gray-500">

                <div class="flex justify-end gap-4 mt-2"> {{-- revisi buttton --}}
                    <button type="reset"
                        class="px-4 py-2 bg-orange-500 text-white rounded-full text-sm hover:bg-yellow-550">Reset</button>
                    <button type="submit"
                        class="px-4 py-2 bg-pink-600 text-white rounded-full text-sm hover:bg-pink-700">Cari</button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- Tabel Komoditas --}}
<div class="w-[90%] max-w-7xl overflow-auto max-h-screen mx-auto rounded-lg" id="comoditiesList">
    <table class="min-w-full border-separate border-spacing-y-1 text-sm text-gray-700">
        <thead class="sticky top-0 z-10 bg-white" id="comoditiesThead">
            <tr class="shadow-pink-hard rounded-3xl bg-white">
                <th class="px-4 py-5 text-center font-semibold rounded-l-3xl">No</th>
                <th class="px-4 py-5 text-center font-semibold whitespace-nowrap">Pasar</th>
                <th class="px-4 py-5 text-center font-semibold whitespace-nowrap">Bahan Pokok</th>
                @for ($i = 1; $i <= 30; $i++)
                    <th
                        class="px-4 py-5 text-center font-semibold {{ $i == 30 ? 'rounded-r-full' : '' }}">
                        {{ $i }}
                    </th>
                @endfor
            </tr>
        </thead>
        <tbody id="comoditiesTbody">
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


    // button filter

    document.addEventListener('DOMContentLoaded', () => {
        const filterBtn = document.getElementById('mobileFilterBtn');
        const dropdown = document.getElementById('mobileFilterDropdown');
        const closeBtn = document.getElementById('closeFilterDropdown');

        filterBtn.addEventListener('click', () => {
            dropdown.classList.toggle('hidden');
        });

        closeBtn.addEventListener('click', () => {
            dropdown.classList.add('hidden');
        });
    });
</script>