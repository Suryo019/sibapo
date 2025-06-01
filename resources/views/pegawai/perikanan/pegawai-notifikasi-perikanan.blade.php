<x-pegawai-layout title="Notifikasi">

    <div class="flex flex-wrap items-center gap-2 mb-4">
        <div class="flex-1 min-w-[150px]">
            <div class="h-[42px] w-full">
                <x-search-notifikasi class="h-full !py-2 !px-4" />
            </div>
        </div>
        <div class="w-auto">
            <x-filter-notifikasi />
        </div>
    </div>

    <div class="space-y-6 mt-6">
        @foreach ($notifikasis as $label => $items)
            <div>
                <h3 class="text-lg font-semibold text-gray-800 mb-2">{{ $label }}</h3>

                <div class="space-y-3">
                    @foreach ($items as $notif)
                        <div class="flex flex-col sm:flex-row sm:items-center bg-white p-4 rounded-lg shadow justify-between">
                            <div class="flex flex-col space-y-1">
                                <div class="flex items-start space-x-4">
                                    {{-- Ganti ikon sesuai role --}}
                                    <iconify-icon 
                                        icon="
                                            {{ 
                                                $notif->role->role === 'disperindag' ? 'mage:basket-fill' :
                                                ($notif->role->role === 'dkpp' ? 'healthicons:plantation-worker-alt' :
                                                ($notif->role->role === 'dp' ? 'majesticons:fish' :
                                                ($notif->role->role === 'dtphp' ? 'mdi:tree' : 'mdi:alert-circle')))
                                            }}" 
                                        class="text-xl text-pink-600">
                                    </iconify-icon>

                                    <p class="text-sm">
                                        <span class="font-semibold text-yellow-500 text-uppercase">{{ strtoupper($notif->role->role) }}</span>,
                                        <span class="text-gray-600">{{ $notif->pesan }}</span>
                                    </p>
                                </div>
                                <span class="text-xs text-gray-400 ml-8">{{ $notif->tanggal_pesan->diffForHumans() }}</span>
                            </div>
                            <div class="mt-3 sm:mt-0">
                                <span class="bg-green-500 text-white text-xs px-3 py-1 rounded-full whitespace-nowrap w-36 text-center block sm:inline-block">Tandai Selesai</span>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endforeach
    </div>

</x-pegawai-layout>