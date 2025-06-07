{{-- @dd($notifikasis["Hari Ini"] [0]->role->role) --}}

<x-pegawai-layout title="Notifikasi">
    <div class="flex items-center gap-2 mb-4">
        <div class="flex-1 min-w-[150px]">
            <div class="h-[42px] w-full">
                <x-search-notifikasi class="h-full !py-2 !px-4" />
            </div>
        </div>
        <div class="w-auto">
            <x-pegawai-filter-notifikasi />
        </div>
    </div>

    <!-- Alert untuk feedback -->
    <div id="alertContainer" class="hidden mb-4">
        <div id="alertMessage" class="p-4 rounded-lg text-sm"></div>
    </div>

    <div class="space-y-6 mt-6">
        @foreach ($notifikasis as $label => $items)
            <div>
                <h3 class="text-lg font-semibold text-gray-800 mb-2">{{ $label }}</h3>

                <div class="space-y-3">
                    @foreach ($items as $notif)
                        <div class="flex flex-col sm:flex-row sm:items-center bg-white p-4 rounded-lg shadow justify-between notif-item {{ $notif->is_completed ? 'opacity-75 bg-gray-50' : '' }}" 
                             data-notif-id="{{ $notif->id }}">
                            <div class="flex flex-col space-y-1">
                                <div class="flex items-start space-x-4">
                                    {{-- Icon berdasarkan status --}}
                                    @php
                                        $roleIcons = [
                                            'disperindag' => 'mage:basket-fill',
                                            'dkpp'        => 'healthicons:plantation-worker-alt',
                                            'perikanan'   => 'majesticons:fish',
                                            'dtphp'       => 'mdi:tree',
                                        ];
                                    
                                        $icon = $roleIcons[$notif->role->role] ?? 'mdi:alert-circle';
                                    @endphp
                                    
                                    <iconify-icon 
                                        icon="{{ $icon }}" 
                                        class="text-xl text-pink-600">
                                    </iconify-icon>

                                    <div class="flex-1">
                                        <p class="text-sm">
                                            <span class="font-semibold text-yellow-500 text-uppercase">{{ strtoupper($notif->role->role) }}</span>,
                                            <span class="text-gray-600 {{ $notif->is_completed ? 'line-through' : '' }}">{{ $notif->pesan }}</span>
                                        </p>
                                        
                                        {{-- Tampilkan info jika sudah selesai --}}
                                        @if($notif->is_completed && $notif->completed_at)
                                            <p class="text-xs text-green-600 mt-1">
                                                <iconify-icon icon="mdi:check" class="text-xs"></iconify-icon>
                                                Selesai pada {{ $notif->completed_at->format('d M Y H:i') }}
                                            </p>
                                        @endif
                                    </div>
                                </div>
                                <span class="text-xs text-gray-400 ml-8">{{ $notif->tanggal_pesan->diffForHumans() }}</span>
                            </div>
                            
                            {{-- Action buttons --}}
                            <div class="mt-3 sm:mt-0 flex flex-wrap gap-2">
                                @if($notif->is_completed)
                                    <button onclick="markAsIncomplete({{ $notif->id }})" 
                                            class="bg-yellow-500 hover:bg-yellow-600 text-white text-xs px-3 py-1 rounded-full whitespace-nowrap transition-colors">
                                        <iconify-icon icon="mdi:undo" class="text-xs mr-1"></iconify-icon>
                                        Batal Selesai
                                    </button>
                                @else
                                    <button onclick="markAsCompleted({{ $notif->id }})" 
                                            class="bg-green-500 hover:bg-green-600 text-white text-xs px-3 py-1 rounded-full whitespace-nowrap transition-colors">
                                        <iconify-icon icon="mdi:check" class="text-xs mr-1"></iconify-icon>
                                        Tandai Selesai
                                    </button>
                                @endif
                                
                                {{-- Tombol hapus --}}
                                <button onclick="deleteNotification({{ $notif->id }})" 
                                        class="bg-red-500 hover:bg-red-600 text-white text-xs px-3 py-1 rounded-full whitespace-nowrap transition-colors">
                                    <iconify-icon icon="mdi:delete" class="text-xs mr-1"></iconify-icon>
                                    Hapus
                                </button>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endforeach
    </div>

    {{-- Loading overlay --}}
    <div id="loadingOverlay" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
        <div class="bg-white p-4 rounded-lg flex items-center space-x-3">
            <div class="animate-spin rounded-full h-6 w-6 border-b-2 border-pink-600"></div>
            <span>Memproses...</span>
        </div>
    </div>
</x-pegawai-layout>

<script>
    function showAlert(message, type = 'success') {
        const alertContainer = document.getElementById('alertContainer');
        const alertMessage = document.getElementById('alertMessage');
        
        alertMessage.className = `p-4 rounded-lg text-sm ${
            type === 'success' ? 'bg-green-100 text-green-800 border border-green-200' :
            type === 'error' ? 'bg-red-100 text-red-800 border border-red-200' :
            'bg-blue-100 text-blue-800 border border-blue-200'
        }`;
        
        alertMessage.textContent = message;
        alertContainer.classList.remove('hidden');
        
        setTimeout(() => {
            alertContainer.classList.add('hidden');
        }, 5000);
    }

    function showLoading() {
        document.getElementById('loadingOverlay').classList.remove('hidden');
    }

    function hideLoading() {
        document.getElementById('loadingOverlay').classList.add('hidden');
    }

    // Nandai notifikasi sebagai selesai
    function markAsCompleted(notificationId) {
        if (!confirm('Apakah Anda yakin ingin menandai notifikasi ini sebagai selesai?')) {
            return;
        }

        showLoading();

        fetch(`/pegawai/dtphp/notifications/${notificationId}/complete`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        })
        .then(response => response.json())
        .then(data => {
            hideLoading();
            
            if (data.success) {
                showAlert(data.message, 'success');
                setTimeout(() => {
                    window.location.reload();
                }, 1000);
            } else {
                showAlert(data.message, 'error');
            }
        })
        .catch(error => {
            hideLoading();
            console.error('Error:', error);
            showAlert('Terjadi kesalahan saat memproses permintaan', 'error');
        });
    }

    // Nandai notifikasi sebagai belum selesai
    function markAsIncomplete(notificationId) {
        if (!confirm('Apakah Anda yakin ingin menandai notifikasi ini sebagai belum selesai?')) {
            return;
        }

        showLoading();

        fetch(`/pegawai/dtphp/notifications/${notificationId}/incomplete`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        })
        .then(response => response.json())
        .then(data => {
            hideLoading();
            
            if (data.success) {
                showAlert(data.message, 'success');
                setTimeout(() => {
                    window.location.reload();
                }, 1000);
            } else {
                showAlert(data.message, 'error');
            }
        })
        .catch(error => {
            hideLoading();
            console.error('Error:', error);
            showAlert('Terjadi kesalahan saat memproses permintaan', 'error');
        });
    }

    // Hapus notifikasi
    function deleteNotification(notificationId) {
        if (!confirm('Apakah Anda yakin ingin menghapus notifikasi ini? Tindakan ini tidak dapat dibatalkan.')) {
            return;
        }

        showLoading();

        fetch(`/pegawai/dtphp/notifications/${notificationId}`, {
            method: 'DELETE',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        })
        .then(response => response.json())
        .then(data => {
            hideLoading();
            
            if (data.success) {
                showAlert(data.message, 'success');
                const notifItem = document.querySelector(`[data-notif-id="${notificationId}"]`);
                if (notifItem) {
                    notifItem.style.transition = 'opacity 0.3s ease';
                    notifItem.style.opacity = '0';
                    setTimeout(() => {
                        notifItem.remove();
                    }, 300);
                }
            } else {
                showAlert(data.message, 'error');
            }
        })
        .catch(error => {
            hideLoading();
            console.error('Error:', error);
            showAlert('Terjadi kesalahan saat menghapus notifikasi', 'error');
        });
    }

    document.addEventListener('click', function(e) {
        if (e.target.closest('#alertContainer')) {
            document.getElementById('alertContainer').classList.add('hidden');
        }
    });
</script>