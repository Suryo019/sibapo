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
            url: `{{ route('api.sorting_items') }}`,
            data: { data: value },
            success: function (response) {
                const results = response.data;
                let list_items = ``;
                let url = "";

                if (value == "pasar") {
                    $.each(results, function (index, value) {
                        list_items += `
                <li data-pasar="${value.pasar}" class="p-2 hover:bg-pink-50 text-sm cursor-pointer sorting_item_list">${value.pasar}</li>
              `;
                    });

                    sorting_item_list_input.val(results[0].pasar);
                    url = "/api/statistik_pasar";
                } else if (value == "jenis_bahan_pokok") {
                    $.each(results, function (index, value) {
                        list_items += `
                <li data-jenis_bahan_pokok="${value.jenis_bahan_pokok}" class="p-2 hover:bg-pink-50 text-sm cursor-pointer sorting_item_list">${value.jenis_bahan_pokok}</li>
              `;
                    });
                    sorting_item_list_input.val(results[0].jenis_bahan_pokok);
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
