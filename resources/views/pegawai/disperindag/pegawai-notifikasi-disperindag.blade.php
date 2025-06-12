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

    <div class="space-y-4 mt-6">
        @foreach ($notifikasis as $label => $items)
            <div>
                <h3 class="text-base font-semibold text-gray-800 mb-2">{{ $label }}</h3>
    
                <div class="space-y-2">
                    @foreach ($items as $notif)
                        <div class="flex items-start justify-between bg-white p-3 rounded-lg shadow notif-item {{ $notif->is_completed ? 'opacity-75 bg-gray-50' : '' }}" 
                             data-notif-id="{{ $notif->id }}">
                            
                            <!-- Kiri: Icon + Text -->
                            <div class="flex items-start space-x-3">
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
                                    class="text-4xl text-pink-600">
                                </iconify-icon>
    
                                <div>
                                    <p class="text-sm leading-snug">
                                        <span class="font-semibold text-yellow-500 uppercase">{{ strtoupper($notif->role->role) }}</span>, 
                                        <span class="text-pink-600 {{ $notif->is_completed ? 'line-through' : '' }}">{{ $notif->pesan }}</span>
                                    </p>
                                    <span class="text-xs text-gray-400">{{ $notif->tanggal_pesan->diffForHumans() }}</span>
                                </div>
                            </div>
    
                            <!-- Kanan: Tombol -->
                            <div class="flex items-center gap-2 ml-4 shrink-0">
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
function showAlert(e,t="success"){const n=document.getElementById("alertContainer"),a=document.getElementById("alertMessage");a.className="p-4 rounded-lg text-sm "+("success"===t?"bg-green-100 text-green-800 border border-green-200":"error"===t?"bg-red-100 text-red-800 border border-red-200":"bg-blue-100 text-blue-800 border border-blue-200"),a.textContent=e,n.classList.remove("hidden"),setTimeout((()=>{n.classList.add("hidden")}),5e3)}function showLoading(){document.getElementById("loadingOverlay").classList.remove("hidden")}function hideLoading(){document.getElementById("loadingOverlay").classList.add("hidden")}function markAsCompleted(e){confirm("Apakah Anda yakin ingin menandai notifikasi ini sebagai selesai?")&&(showLoading(),fetch(`/pegawai/disperindag/notifications/${e}/complete`,{method:"POST",headers:{"Content-Type":"application/json","X-CSRF-TOKEN":document.querySelector('meta[name="csrf-token"]').getAttribute("content")}}).then((e=>e.json())).then((e=>{hideLoading(),e.success?(showAlert(e.message,"success"),setTimeout((()=>{window.location.reload()}),1e3)):showAlert(e.message,"error")})).catch((e=>{hideLoading(),console.error("Error:",e),showAlert("Terjadi kesalahan saat memproses permintaan","error")})))}function markAsIncomplete(e){confirm("Apakah Anda yakin ingin menandai notifikasi ini sebagai belum selesai?")&&(showLoading(),fetch(`/pegawai/disperindag/notifications/${e}/incomplete`,{method:"POST",headers:{"Content-Type":"application/json","X-CSRF-TOKEN":document.querySelector('meta[name="csrf-token"]').getAttribute("content")}}).then((e=>e.json())).then((e=>{hideLoading(),e.success?(showAlert(e.message,"success"),setTimeout((()=>{window.location.reload()}),1e3)):showAlert(e.message,"error")})).catch((e=>{hideLoading(),console.error("Error:",e),showAlert("Terjadi kesalahan saat memproses permintaan","error")})))}function deleteNotification(e){confirm("Apakah Anda yakin ingin menghapus notifikasi ini? Tindakan ini tidak dapat dibatalkan.")&&(showLoading(),fetch(`/pegawai/disperindag/notifications/${e}`,{method:"DELETE",headers:{"Content-Type":"application/json","X-CSRF-TOKEN":document.querySelector('meta[name="csrf-token"]').getAttribute("content")}}).then((e=>e.json())).then((t=>{if(hideLoading(),t.success){showAlert(t.message,"success");const n=document.querySelector(`[data-notif-id="${e}"]`);n&&(n.style.transition="opacity 0.3s ease",n.style.opacity="0",setTimeout((()=>{n.remove()}),300))}else showAlert(t.message,"error")})).catch((e=>{hideLoading(),console.error("Error:",e),showAlert("Terjadi kesalahan saat menghapus notifikasi","error")})))}document.addEventListener("click",(function(e){e.target.closest("#alertContainer")&&document.getElementById("alertContainer").classList.add("hidden")}));
</script>