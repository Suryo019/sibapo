<x-tamu-layout title="Statistik">
<div class="w-full flex flex-col justify-center items-center text-pink-650 mb-16 px-4">
    <h1 class="text-3xl sm:text-5xl font-extrabold mb-4 sm:mb-8 text-center">Statistik Harga</h1>
    <h5 class="text-base sm:text-xl text-shadow mb-8 sm:mb-16 mx-4 text-center">
        Data perubahan harga setiap bahan pokok dalam 1 bulan
    </h5>

    {{-- Filter Form --}}
    <form action="{{ route('tamu.komoditas') }}" method="GET"
        class="w-full max-w-5xl flex flex-col sm:flex-row flex-wrap gap-4 sm:gap-6 items-center justify-center">
        @csrf

        {{-- Sorting Root --}}
        <div class="w-full sm:w-auto">
            <select name="sorting_category" id="sorting_category"
                class="w-full border border-pink-650 px-4 py-2 rounded-full bg-white text-sm text-gray-500 focus:outline-none">
                <option value="pasar">Per Pasar</option>
                <option value="jenis_bahan_pokok">Per Bahan Pokok</option>
            </select>
        </div>

        {{-- Sorting Child --}}
        <div class="w-full sm:w-auto relative">
            <div
                class="w-full border border-pink-650 px-4 py-2 rounded-full bg-white text-sm text-gray-500 flex items-center cursor-pointer"
                id="sorting_child">
                <input type="text" value="{{ $markets[0]->nama_pasar }}"
                    class="focus:outline-none flex-shrink bg-transparent w-full" id="sorting_item_list_input" name="market"
                    autocomplete="off" readonly>
                <i class="bi bi-caret-down-fill text-pink-650 text-xs ml-2"></i>
            </div>
            <ul class="bg-white border border-pink-650 rounded-2xl max-h-60 w-full absolute z-20 top-10 overflow-y-auto hidden"
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
        <div class="w-full sm:w-auto">
            <input type="month" name="periode" id="periode" value="{{ date('Y-m') }}"
                class="w-full border border-pink-650 px-4 py-2 rounded-full bg-white text-sm text-gray-500 focus:outline-none">
        </div>

        {{-- Search --}}
        <div class="w-full sm:w-auto relative">
            <i class="bi bi-search absolute left-3 top-1/2 transform -translate-y-1/2 text-pink-650"></i>
            <input type="text" name="search" id="search" placeholder="Cari Bahan Pokok"
                class="pl-10 pr-4 py-2 w-full border border-pink-650 rounded-full bg-white text-sm text-gray-500 focus:outline-none placeholder-gray-500">
        </div>
    </form>
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

<script>
$(document).ready(function () {
    const sortingCategory = $("#sorting_category");
    const itemListContainer = $("#sorting_item_list_container");
    const itemListInjector = $("#sorting_item_list_container_injector");
    const itemListInput = $("#sorting_item_list_input");
    const periodeSelect = $("#periode");
    const search = $("#search");

    function fetchTableData(url, keyword) {
        itemListContainer.addClass("hidden");

        $.ajax({
            type: "GET",
            url: url,
            data: {
                data: keyword,
                periode: periodeSelect.val()
            },
            success: function (response) {
                const data = response.data;
                const jumlahHari = response.jumlahHari;

                // Table head
                let theadHTML = `
                    <tr class="shadow-pink-hard rounded-3xl bg-white">
                        <th class="px-4 py-5 text-center font-semibold rounded-l-3xl">No</th>
                        <th class="px-4 py-5 text-center font-semibold whitespace-nowrap">Pasar</th>
                        <th class="px-4 py-5 text-center font-semibold whitespace-nowrap">Bahan Pokok</th>
                `;
                for (let i = 1; i <= jumlahHari; i++) {
                    theadHTML += `<th class="px-4 py-5 text-center font-semibold ${i === jumlahHari ? "rounded-r-full" : ""}">${i}</th>`;
                }
                theadHTML += "</tr>";
                $("#comoditiesThead").html(theadHTML);

                // Table body
                let tbodyHTML = "";
                if (Object.keys(data).length === 0) {
                    tbodyHTML = `
                        <tr class="bg-white">
                            <td colspan="${3 + jumlahHari}" class="py-5 px-8 bg-pink-50 text-gray-500 italic">
                                Data tidak ditemukan.
                            </td>
                        </tr>
                    `;
                } else {
                    let no = 1;
                    Object.values(data).forEach(item => {
                        tbodyHTML += `
                            <tr class="bg-white hover:bg-pink-50 rounded-full shadow-pink-hard transition duration-150">
                                <td class="px-4 py-3 text-center rounded-l-full">${no++}</td>
                                <td class="px-4 py-3 text-center whitespace-nowrap">${item.pasar}</td>
                                <td class="px-4 py-3 text-center whitespace-nowrap jenis_bahan_pokok_col">${item.jenis_bahan_pokok}</td>
                        `;
                        for (let i = 1; i <= jumlahHari; i++) {
                            const harga = item.harga_per_tanggal[i];
                            const hargaDisplay = harga ? parseInt(harga).toLocaleString("id-ID") : "-";
                            tbodyHTML += `<td class="px-4 py-3 text-center ${i === jumlahHari ? "rounded-r-full" : ""} whitespace-nowrap">Rp. ${hargaDisplay}</td>`;
                        }
                        tbodyHTML += "</tr>";
                    });
                }

                $("#comoditiesTbody").html(tbodyHTML);
            },
            error: function (xhr) {
                let errors = xhr.responseJSON.errors;
                let errorMessage = "";
                $.each(errors, function (key, value) {
                    errorMessage += value + "<br>";
                });
                console.error(errorMessage);
            }
        });
    }

    sortingCategory.on("change", function () {
        const selectedValue = $(this).val();

        $.ajax({
            type: "GET",
            url: "/api/sorting_items",
            data: { data: selectedValue },
            success: function (response) {
                const items = response.data;
                let listHTML = "";
                let endpoint = "";

                if (selectedValue === "pasar") {
                    $.each(items, function (i, item) {
                        listHTML += `<li data-pasar="${item.nama_pasar}" class="p-2 hover:bg-pink-50 text-sm cursor-pointer sorting_item_list">${item.nama_pasar}</li>`;
                    });
                    itemListInput.val(items[0].nama_pasar);
                    endpoint = "/api/statistik_pasar";

                } else if (selectedValue === "jenis_bahan_pokok") {
                    $.each(items, function (i, item) {
                        listHTML += `<li data-jenis_bahan_pokok="${item.nama_bahan_pokok}" class="p-2 hover:bg-pink-50 text-sm cursor-pointer sorting_item_list">${item.nama_bahan_pokok}</li>`;
                    });
                    itemListInput.val(items[0].nama_bahan_pokok);
                    endpoint = "/api/statistik_jenis_bahan_pokok";
                }

                itemListInjector.html(listHTML);
                fetchTableData(endpoint, itemListInput.val());
            },
            error: function (xhr) {
                let errors = xhr.responseJSON.errors;
                let errorMessage = "";
                $.each(errors, function (key, value) {
                    errorMessage += value + "<br>";
                });
                console.error(errorMessage);
            }
        });
    });

    // Toggle dropdown
    $("#sorting_child").on("click", function () {
        itemListContainer.toggleClass("hidden");
    });

    // Filter input in dropdown
    itemListInput.on("input", function () {
        itemListContainer.removeClass("hidden");
        const keyword = $(this).val().toLowerCase();
        itemListInjector.find("li").each(function () {
            const text = $(this).text().toLowerCase();
            $(this).toggleClass("hidden", !text.includes(keyword));
        });
    });

    // Load data awal
    fetchTableData("/api/statistik_pasar", itemListInput.val());

    // Perubahan periode
    periodeSelect.on("change", function () {
        const keyword = itemListInput.val();
        const selected = sortingCategory.val();
        if (selected === "pasar") {
            fetchTableData("/api/statistik_pasar", keyword);
        } else if (selected === "jenis_bahan_pokok") {
            fetchTableData("/api/statistik_jenis_bahan_pokok", keyword);
        }
    });

    // Klik pada item list
    $(document).on("click", ".sorting_item_list", function () {
        if (sortingCategory.val() === "pasar") {
            const val = $(this).data("pasar");
            itemListInput.val(val);
            fetchTableData("/api/statistik_pasar", val);
        } else if (sortingCategory.val() === "jenis_bahan_pokok") {
            const val = $(this).data("jenis_bahan_pokok");
            itemListInput.val(val);
            fetchTableData("/api/statistik_jenis_bahan_pokok", val);
        }
    });

    // Search filter
    search.on("input", function () {
        const keyword = $(this).val().toLowerCase();
        $(".jenis_bahan_pokok_col").each(function () {
            const text = $(this).text().toLowerCase();
            $(this).parent().toggleClass("hidden", !text.includes(keyword));
        });
    });
});

// Toggle untuk tampilan mobile
document.addEventListener("DOMContentLoaded", () => {
    const filterBtn = document.getElementById("mobileFilterBtn");
    const dropdown = document.getElementById("mobileFilterDropdown");
    const closeBtn = document.getElementById("closeFilterDropdown");

    filterBtn.addEventListener("click", () => {
        dropdown.classList.toggle("hidden");
    });

    closeBtn.addEventListener("click", () => {
        dropdown.classList.add("hidden");
    });
});
</script>