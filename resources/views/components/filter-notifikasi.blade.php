{{-- <div class="w-full flex justify-end mb-4 relative">
    <!-- Tombol toggle -->
    <button id="dropdownToggle" class="bg-pink-600 rounded-[10px] text-white flex items-center justify-center w-28 h-10 gap-2 hover:bg-pink-500">
      Semua
      <i class="bi bi-chevron-down"></i>
    </button>
  
    <!-- Dropdown menu -->
    <div id="dropdownMenu" class="hidden absolute right-0 mt-12 w-40 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 z-10">
      <div class="py-1 text-sm text-gray-700">
        <a href="#" class="block px-4 py-2 hover:bg-gray-100 dropdown-item">Semua</a>
        <a href="#" class="block px-4 py-2 hover:bg-gray-100 dropdown-item">Selesai</a>
        <a href="#" class="block px-4 py-2 hover:bg-gray-100 dropdown-item">Belum Selesai</a>
      </div>
    </div>
  </div> --}}
  
  <div class="relative">
    <button id="filterToggle" class="bg-pink-600 rounded-[10px] text-white flex items-center justify-center w-28 h-10 gap-2 hover:bg-pink-500">
        <iconify-icon icon="mdi:filter-variant" class="text-lg text-white"></iconify-icon>
        <span class="text-sm font-medium text-white">Filter</span>
        <iconify-icon icon="mdi:chevron-down" class="text-sm text-white transition-transform" id="filterChevron"></iconify-icon>
    </button>

    <!-- Filter Dropdown -->
    <div id="filterDropdown" class="hidden absolute right-0 top-full mt-2 w-80 bg-white border border-white rounded-lg shadow-lg z-10">
        <form class="p-4 space-y-4" action="{{ route('admin.notifikasi.filter') }}" method="GET">
            @csrf
            <!-- Status Filter -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Status</label>
                <select id="statusFilter" name="status" class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-pink-500 focus:border-transparent">
                    <option value="">Semua Status</option>
                    <option value="completed">Selesai</option>
                    <option value="pending">Belum Selesai</option>
                </select>
            </div>

            <!-- Message Filter -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Role</label>
                <select id="messageFilter" name="role_id" class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-pink-500 focus:border-transparent">
                    <option value="">Semua Role</option>
                    <option value="2">DISPERINDAG</option>
                    <option value="3">DKPP</option>
                    <option value="4">DTPHP</option>
                    <option value="5">PERIKANAN</option>
                </select>
            </div>

            <!-- Date Range Filter -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Periode</label>
                <select id="dateFilter" name="tanggal_pesan" class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-pink-500 focus:border-transparent">
                    <option value="">Semua Waktu</option>
                    <option value="today">Hari Ini</option>
                    <option value="yesterday">Kemarin</option>
                    <option value="week">Minggu Ini</option>
                    <option value="month">Bulan Ini</option>
                </select>
            </div>

            <!-- Action Buttons -->
            <div class="flex gap-2 pt-2 border-t border-gray-200">
                <button type="submit" id="applyFilter" class="flex-1 bg-pink-600 text-white text-sm px-4 py-2 rounded-md hover:bg-pink-700">
                    Terapkan Filter
                </button>
            </div>
        </form>
    </div>
</div>
  
<script>
  document.addEventListener('DOMContentLoaded', function() {
      const filterToggle = document.getElementById('filterToggle');
      const filterDropdown = document.getElementById('filterDropdown');
      const filterChevron = document.getElementById('filterChevron');
      const applyFilterBtn = document.getElementById('applyFilter');

      // Toggle dropdown
      filterToggle.addEventListener('click', function(e) {
          e.stopPropagation();
          const isHidden = filterDropdown.classList.contains('hidden');
          
          if (isHidden) {
              filterDropdown.classList.remove('hidden');
              filterChevron.style.transform = 'rotate(180deg)';
          } else {
              filterDropdown.classList.add('hidden');
              filterChevron.style.transform = 'rotate(0deg)';
          }
      });

      document.addEventListener('click', function(e) {
          if (!filterToggle.contains(e.target) && !filterDropdown.contains(e.target)) {
              filterDropdown.classList.add('hidden');
              filterChevron.style.transform = 'rotate(0deg)';
          }
      });

      function checkEmptySections() {
          const sections = document.querySelectorAll('h3');
          sections.forEach(sectionTitle => {
              const sectionDiv = sectionTitle.parentElement;
              const visibleNotifs = sectionDiv.querySelectorAll('.notif-item[style*="flex"], .notif-item:not([style*="none"])');
              
              if (visibleNotifs.length === 0) {
                  sectionDiv.style.display = 'none';
              } else {
                  sectionDiv.style.display = 'block';
              }
          });
      }
  });
</script>
  