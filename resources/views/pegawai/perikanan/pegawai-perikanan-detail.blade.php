<x-pegawai-layout>
    <main class="flex-1 p-4 sm:p-6">
        <h2 class="text-2xl font-semibold text-green-900">{{ $title }}</h2>
    
        <div class="bg-white p-4 sm:p-6 rounded-lg shadow-md mt-4">
            <h3 class="text-lg font-semibold text-center mb-4">Data Volume Produksi Ikan Tahun 2025</h3>
            
            <!-- Search dan Dropdown -->
            <div class="flex flex-col lg:flex-row justify-between gap-4 mb-6">
                <!-- Search -->
                <div class="relative w-full lg:w-64">
                    <div class="flex items-center border border-gray-300 bg-white rounded-full w-full h-10 shadow-sm focus-within:ring-2 focus-within:ring-green-500 focus-within:border-green-500 transition-colors">
                        <span class="bi bi-search pl-4 pr-2 text-gray-400"></span>
                        <input type="text" placeholder="Cari..." class="w-full outline-none rounded-full text-sm pr-4 bg-transparent">
                    </div>
                </div>
    
                <!-- Dropdowns -->
                <div class="flex flex-col sm:flex-row gap-4 w-full lg:w-auto">
                    <div class="w-full sm:w-36">
                        <label for="pilih_ikan" class="block text-sm font-medium text-gray-700 mb-1">Pilih Ikan</label>
                        <select class="w-full border border-gray-300 p-2 rounded-full bg-white shadow-sm focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-colors" id="pilih_ikan">
                            <option value="" selected>Teri</option>
                            @foreach ($fishes as $fish)
                                <option value="{{ $fish }}">{{ $fish }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="w-full sm:w-36">
                        <label for="pilih_periode" class="block text-sm font-medium text-gray-700 mb-1">Pilih Periode</label>
                        <select class="w-full border border-gray-300 p-2 rounded-full bg-white shadow-sm focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-colors" id="pilih_periode" disabled>
                            <option value="" disabled selected>April 2025</option>
                            @foreach ($periods as $period)
                                <option value="{{ $period }}">{{ $period }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
    
            <!-- Tabel Responsif -->
            @if (isset($data))
                <div class="overflow-x-auto">
                    <table class="min-w-full border border-gray-300">
                        <thead class="bg-gray-50">
                            <tr>
                                <th rowspan="2" class="border px-4 py-2 whitespace-nowrap">Jenis Ikan</th>
                                <th colspan="12" class="border px-4 py-2 text-center">Produksi</th>
                                <th rowspan="2" class="border px-4 py-2">Aksi</th>
                            </tr>
                            <tr>
                                @php
                                    $namaBulan = [
                                        1 => 'Jan', 2 => 'Feb', 3 => 'Mar', 4 => 'Apr',
                                        5 => 'Mei', 6 => 'Jun', 7 => 'Jul', 8 => 'Agu',
                                        9 => 'Sep', 10 => 'Okt', 11 => 'Nov', 12 => 'Des'
                                    ];
                                @endphp
                                
                                @foreach ($namaBulan as $bulan)
                                    <th class="border px-2 py-2 text-center whitespace-nowrap">{{ $bulan }}</th>
                                @endforeach
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data as $item)
                                <tr class="border hover:bg-gray-50">
                                    <td class="border px-4 py-2">{{ $item['jenis_ikan'] }}</td>
                                    
                                    @for ($bulan = 1; $bulan <= 12; $bulan++)
                                    <td class="border px-2 py-2 text-center whitespace-nowrap">
                                        @if (isset($item['produksi_per_bulan'][$bulan]))
                                            {{ number_format($item['produksi_per_bulan'][$bulan], 0, ',', '.') }}
                                        @else
                                            -
                                        @endif
                                    </td>
                                    @endfor

                                    <td class="border px-4 py-2">
                                        <div class="flex justify-center gap-2">
                                            <button class="editBtn bg-yellow-400 hover:bg-yellow-500 text-white rounded-md w-10 h-10 flex items-center justify-center transition-colors"
                                                data-ikan="{{ $item['jenis_ikan'] }}">
                                                <i class="bi bi-pencil-square"></i>
                                            </button>
                                        
                                            <button class="deleteBtn bg-red-500 hover:bg-red-600 text-white rounded-md w-10 h-10 flex items-center justify-center transition-colors" 
                                                data-ikan="{{ $item['jenis_ikan'] }}">
                                                <i class="bi bi-trash-fill"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach

                            @php
                            $totalPerBulan = [];
                            foreach ($data as $item) {
                                for ($bulan = 1; $bulan <= 12; $bulan++) {
                                    if (isset($item['produksi_per_bulan'][$bulan])) {
                                        if (!isset($totalPerBulan[$bulan])) {
                                            $totalPerBulan[$bulan] = 0;
                                        }
                                        $totalPerBulan[$bulan] += $item['produksi_per_bulan'][$bulan];
                                    }
                                }
                            }
                            @endphp
                            
                            <tr class="border font-bold bg-gray-50">
                                <td class="border px-4 py-2">Jumlah</td>
                                @for ($bulan = 1; $bulan <= 12; $bulan++)
                                    <td class="border px-2 py-2 text-center whitespace-nowrap">
                                        {{ isset($totalPerBulan[$bulan]) ? number_format($totalPerBulan[$bulan], 0, ',', '.') : '-' }}
                                    </td>
                                @endfor
                                <td class="border px-4 py-2"></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            @else
                <div class="flex items-center justify-center h-64">
                    <div class="text-center p-4 border-2 border-dashed border-gray-300 rounded-lg shadow-md bg-gray-50">
                        <h3 class="text-lg font-semibold text-gray-500">Data Tidak Ditemukan</h3>
                        <p class="text-gray-400">Tidak ada data yang sesuai dengan kriteria pencarian.</p>
                    </div>
                </div>
            @endif
        </div>

        <!-- Button Kembali & Tambah Data -->
        <div class="flex flex-col sm:flex-row justify-between gap-4 mt-6">
            <a href="{{ route('pegawai.perikanan.index') }}" class="inline-flex items-center px-6 py-2 bg-green-700 hover:bg-green-800 text-white text-sm rounded-full shadow-sm transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2">
                Kembali
            </a>
            <a href="{{ route('pegawai.perikanan.create') }}" class="inline-flex items-center px-6 py-2 bg-green-700 hover:bg-green-800 text-white text-sm rounded-full shadow-sm transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2">
                Tambah Data
            </a>
        </div>

        <!-- Modal Edit -->
        <div id="editModal" class="fixed inset-0 bg-black bg-opacity-50 hidden justify-center items-center z-40 p-4">
            <div class="bg-white p-6 rounded-lg w-full max-w-2xl shadow-lg relative max-h-[90vh] flex flex-col">
                <h2 class="text-xl font-semibold mb-4">Pilih Data untuk Diedit</h2>
        
                <!-- Data List -->
                <div id="editDataList" class="space-y-4 overflow-y-auto flex-grow mb-4">
                    <!-- Diisi via AJAX -->
                </div>
        
                <!-- Tombol Tutup -->
                <div class="text-right">
                    <button id="closeEditModal" class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded transition-colors">
                        Tutup
                    </button>
                </div>
            </div>
        </div>

        <!-- Modal Delete -->
        <div id="deleteModal" class="fixed inset-0 bg-black bg-opacity-50 hidden justify-center items-center z-40 p-4">
            <div class="bg-white p-6 rounded-lg w-full max-w-md shadow-lg">
                <h2 class="text-xl font-semibold mb-6 text-center">Yakin menghapus data?</h2>
                <div class="flex justify-center gap-4">
                    <button id="closeDeleteModal" class="bg-gray-500 hover:bg-gray-600 text-white px-6 py-2 rounded-full transition-colors">
                        Batal
                    </button>
                    <button id="confirmDeleteBtn" class="bg-green-700 hover:bg-green-800 text-white px-6 py-2 rounded-full transition-colors">
                        Yakin
                    </button>
                </div>
            </div>
        </div>
    </main>

    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Elements
            const pilihIkan = document.getElementById('pilih_ikan');
            const pilihPeriode = document.getElementById('pilih_periode');
            const editModal = document.getElementById('editModal');
            const deleteModal = document.getElementById('deleteModal');
            let deleteId = null;

            // Enable period select when fish is selected
            pilihIkan.addEventListener('change', function() {
                pilihPeriode.disabled = !this.value;
            });

            // Edit button handler
            document.querySelectorAll('.editBtn').forEach(btn => {
                btn.addEventListener('click', function() {
                    const jenisIkan = this.dataset.ikan;
                    fetchEditData(jenisIkan);
                    editModal.classList.remove('hidden');
                    editModal.classList.add('flex');
                });
            });

            // Delete button handler
            document.querySelectorAll('.deleteBtn').forEach(btn => {
                btn.addEventListener('click', function() {
                    deleteId = this.dataset.ikan;
                    deleteModal.classList.remove('hidden');
                    deleteModal.classList.add('flex');
                });
            });

            // Close modals
            document.getElementById('closeEditModal').addEventListener('click', closeEditModal);
            document.getElementById('closeDeleteModal').addEventListener('click', closeDeleteModal);

            // Confirm delete
            document.getElementById('confirmDeleteBtn').addEventListener('click', confirmDelete);

            // Functions
            async function fetchEditData(jenisIkan) {
                try {
                    const response = await fetch(`/api/dp/${jenisIkan}`);
                    const { data } = await response.json();
                    
                    const editDataList = document.getElementById('editDataList');
                    editDataList.innerHTML = '';
                    
                    data.forEach(item => {
                        const card = document.createElement('div');
                        card.className = 'border rounded-md p-4 shadow-sm flex items-center justify-between';
                        card.innerHTML = `
                            <div>
                                <p class="text-sm text-gray-500">Jenis Ikan: <span class="font-medium">${item.jenis_ikan}</span></p>
                                <p class="text-sm text-gray-500">Produksi: <span class="font-medium">${item.ton_produksi}</span></p>
                                <p class="text-sm text-gray-500">Tanggal: <span class="font-medium">${item.tanggal_input}</span></p>
                            </div>
                            <a href="perikanan/${item.id}/edit" class="bg-yellow-500 hover:bg-yellow-600 text-white px-3 py-1 rounded text-sm transition-colors">Ubah</a>
                        `;
                        editDataList.appendChild(card);
                    });
                } catch (error) {
                    console.error('Error:', error);
                }
            }

            async function confirmDelete() {
                if (!deleteId) return;
                
                try {
                    const response = await fetch(`/api/dp/${deleteId}`, {
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                            'Accept': 'application/json',
                            'Content-Type': 'application/json'
                        }
                    });

                    const data = await response.json();

                    if (response.ok) {
                        Swal.fire({
                            title: 'Berhasil!',
                            text: `Data ${data.data.jenis_ikan} telah dihapus.`,
                            icon: 'success',
                            confirmButtonText: 'OK'
                        }).then(() => {
                            location.reload();
                        });
                    } else {
                        throw new Error(data.message || 'Gagal menghapus data');
                    }
                } catch (error) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: error.message
                    });
                } finally {
                    closeDeleteModal();
                }
            }

            function closeEditModal() {
                editModal.classList.add('hidden');
                editModal.classList.remove('flex');
            }

            function closeDeleteModal() {
                deleteModal.classList.add('hidden');
                deleteModal.classList.remove('flex');
                deleteId = null;
            }
        });
    </script>
    @endpush
</x-pegawai-layout>