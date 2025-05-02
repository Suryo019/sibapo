$(".editBtn").on("click", function () {
    const modal = $("#modal");
    modal.removeClass("hidden").addClass("flex");
    $("#actionPlaceholder").html("edit");

    const bahanPokok = $(this).data("bahan-pokok");

    $.ajax({
        type: "GET",
        url: `/api/dpp/${bahanPokok}`,
        data: {
            periode_bulan: $(this).data("periode-bulan"),
            periode_tahun: $(this).data("periode-tahun"),
        },
        success: function (response) {
            const data = response.data;
            $("#editDataList").empty();
            data.forEach((element) => {
                let listCard = `
                    <div class="border rounded-md p-4 shadow-sm flex items-center justify-between">
                        <div>
                            <p class="text-sm text-gray-500">Jenis Bahan Pokok: <span class="font-medium">${element.jenis_bahan_pokok}</span></p>
                            <p class="text-sm text-gray-500">Pasar: <span class="font-medium">${element.pasar}</span></p>
                            <p class="text-sm text-gray-500">Tanggal: <span class="font-medium">${element.tanggal_dibuat}</span></p>
                            <p class="text-sm text-gray-500">Harga: <span class="font-medium">Rp. ${element.kg_harga}</span></p>
                        </div>
                        <a href="/pegawai/disperindag/${element.id}/edit" class="bg-yellow-500 text-white px-3 py-1 rounded text-sm hover:bg-yellow-600">Ubah</a>
                    </div>
                `;
                $("#editDataList").append(listCard);
            });
        },
        error: function (xhr) {
            console.log(xhr.responseText);
        },
    });
});

$(".deleteBtn").on("click", function () {
    const modal = $("#modal");
    modal.removeClass("hidden").addClass("flex");
    $("#actionPlaceholder").html("hapus");

    const bahanPokok = $(this).data("bahan-pokok");

    $.ajax({
        type: "GET",
        url: `/api/dpp/${bahanPokok}`,
        data: {
            periode_bulan: $(this).data("periode-bulan"),
            periode_tahun: $(this).data("periode-tahun"),
        },
        success: function (response) {
            const data = response.data;
            $("#editDataList").empty();
            data.forEach((element) => {
                let listCard = `
                    <div class="border rounded-md p-4 shadow-sm flex items-center justify-between">
                        <div>
                            <p class="text-sm text-gray-500">Jenis Bahan Pokok: <span class="font-medium">${element.jenis_bahan_pokok}</span></p>
                            <p class="text-sm text-gray-500">Tanggal: <span class="font-medium">${element.tanggal_dibuat}</span></p>
                            <p class="text-sm text-gray-500">Harga: <span class="font-medium">Rp. ${element.kg_harga}</span></p>
                        </div>
                        <button data-id="${element.id}" class="btnConfirm bg-red-500 text-white px-3 py-1 rounded text-sm hover:bg-red-600">Hapus</button>
                    </div>
                `;
                $("#editDataList").append(listCard);
            });
        },
        error: function (xhr) {
            console.log(xhr.responseText);
        },
    });
});
