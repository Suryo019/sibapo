<x-admin-layout>

    <div class="flex flex-wrap items-center gap-2 mb-4">
        <div class="flex-1 min-w-[150px]">
            <div class="h-[42px] w-full">
                <x-search-notifikasi class="h-full !py-2 !px-4"></x-search-notifikasi>
            </div>
        </div>
        <div class="w-auto">
            <x-filter-notifikasi></x-filter-notifikasi>
        </div>
    </div>      

    <div class="space-y-6 mt-6">
        <div>
            <h3 class="text-lg font-semibold text-gray-800 mb-2">Hari ini</h3>

            <div class="space-y-3">
                <!-- DISPERINDAG -->
                <div class="flex flex-col sm:flex-row sm:items-center bg-white p-4 rounded-lg shadow justify-between">
                    <div class="flex flex-col space-y-1">
                        <div class="flex items-start space-x-4">
                            <iconify-icon icon="mage:basket-fill" class="text-xl text-pink-600"></iconify-icon>
                            <p class="text-sm">
                                <span class="font-semibold text-yellow-500">DISPERINDAG</span>,
                                <span class="text-gray-600">Belum menginputkan data untuk periode ini. Silakan lakukan peninjauan lebih lanjut.</span>
                            </p>
                        </div>
                        <span class="text-xs text-gray-400 ml-8">Baru saja</span>
                    </div>
                    <div class="mt-3 sm:mt-0">
                        <span class="bg-green-500 text-white text-xs px-3 py-1 rounded-full whitespace-nowrap w-36 text-center block sm:inline-block">Tandai Sebagai Selesai</span>
                    </div>
                </div>

                <!-- DKPP -->
                <div class="flex flex-col sm:flex-row sm:items-center bg-white p-4 rounded-lg shadow justify-between">
                    <div class="flex flex-col space-y-1">
                        <div class="flex items-start space-x-4">
                            <iconify-icon icon="healthicons:plantation-worker-alt" class="text-xl text-pink-600"></iconify-icon>
                            <p class="text-sm">
                                <span class="font-semibold text-yellow-500">DKPP</span>,
                                <span class="text-gray-600">Belum menginputkan data untuk periode ini. Silakan lakukan peninjauan lebih lanjut.</span>
                            </p>
                        </div>
                        <span class="text-xs text-gray-400 ml-8">Baru saja</span>
                    </div>
                    <div class="mt-3 sm:mt-0">
                        <span class="bg-green-500 text-white text-xs px-3 py-1 rounded-full whitespace-nowrap w-36 text-center block sm:inline-block">Tandai Sebagai Selesai</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- KEMARIN -->
        <div>
            <h3 class="text-lg font-semibold text-gray-800 mb-2">Kemarin</h3>

            <div class="flex flex-col sm:flex-row sm:items-center bg-white p-4 rounded-lg shadow justify-between">
                <div class="flex flex-col space-y-1">
                    <div class="flex items-start space-x-4">
                        <iconify-icon icon="majesticons:fish" class="text-xl text-pink-600"></iconify-icon>
                        <p class="text-sm">
                            <span class="font-semibold text-yellow-500">PERIKANAN</span>,
                            <span class="text-gray-600">Belum menginputkan data untuk periode ini. Silakan lakukan peninjauan lebih lanjut.</span>
                        </p>
                    </div>
                    <span class="text-xs text-gray-400 ml-8">Baru saja</span>
                </div>
                <div class="mt-3 sm:mt-0">
                    <span class="bg-gray-400 text-white text-xs px-3 py-1 rounded-full whitespace-nowrap w-36 text-center block sm:inline-block">Selesai</span>
                </div>
            </div>
        </div>
    </div>

</x-admin-layout>
