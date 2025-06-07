  <div class="relative">
    <button id="filterToggle" class="bg-pink-600 rounded-[10px] text-white flex items-center justify-center w-28 h-10 gap-2 hover:bg-pink-500">
        <iconify-icon icon="mdi:filter-variant" class="text-lg text-white"></iconify-icon>
        <span class="text-sm font-medium text-white">Filter</span>
        <iconify-icon icon="mdi:chevron-down" class="text-sm text-white transition-transform" id="filterChevron"></iconify-icon>
    </button>

    <!-- Filter Dropdown -->
    <div id="filterDropdown" class="hidden absolute right-0 top-full mt-2 w-80 bg-white border border-white rounded-lg shadow-lg z-10">
        <div class="p-4 space-y-4">
            <!-- Status Filter -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Status</label>
                <select id="statusFilter" class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-pink-500 focus:border-transparent">
                    <option value="">Semua Status</option>
                    <option value="completed">Selesai</option>
                    <option value="pending">Belum Selesai</option>
                </select>
            </div>

            <!-- Date Range Filter -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Periode</label>
                <select id="dateFilter" class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-pink-500 focus:border-transparent">
                    <option value="">Semua Waktu</option>
                    <option value="today">Hari Ini</option>
                    <option value="yesterday">Kemarin</option>
                    <option value="week">Minggu Ini</option>
                    <option value="month">Bulan Ini</option>
                </select>
            </div>

            <!-- Action Buttons -->
            <div class="flex gap-2 pt-2 border-t border-gray-200">
                <button id="applyFilter" class="flex-1 bg-pink-600 text-white text-sm px-4 py-2 rounded-md hover:bg-pink-700 transition-colors">
                    Terapkan Filter
                </button>
            </div>
        </div>
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

      // Apply filter
      applyFilterBtn.addEventListener('click', function() {
          const status = document.getElementById('statusFilter').value;
          const dateRange = document.getElementById('dateFilter').value;
          
          applyFilters(status, message, dateRange);
          filterDropdown.classList.add('hidden');
          filterChevron.style.transform = 'rotate(0deg)';
          
          updateFilterButtonState();
      });

      function applyFilters(status, dateRange) {
          const allNotifs = document.querySelectorAll('.notif-item');
          
          allNotifs.forEach(notif => {
              let shouldShow = true;
              
              if (status) {
                  const isCompleted = notif.classList.contains('opacity-75');
                  if (status === 'completed' && !isCompleted) shouldShow = false;
                  if (status === 'pending' && isCompleted) shouldShow = false;
              }
              
              if (dateRange) {
                  const timeText = notif.querySelector('.text-gray-400');
                  const timeStr = timeText ? timeText.textContent.toLowerCase() : '';
                  
                  switch(dateRange) {
                      case 'today':
                          if (!timeStr.includes('jam') && !timeStr.includes('menit') && !timeStr.includes('detik')) {
                              shouldShow = false;
                          }
                          break;
                      case 'yesterday':
                          if (!timeStr.includes('1 hari') && !timeStr.includes('kemarin')) {
                              shouldShow = false;
                          }
                          break;
                      case 'week':
                          if (timeStr.includes('minggu') || timeStr.includes('bulan') || timeStr.includes('tahun')) {
                              shouldShow = false;
                          }
                          break;
                      case 'month':
                          if (timeStr.includes('bulan') || timeStr.includes('tahun')) {
                              shouldShow = false;
                          }
                          break;
                  }
              }
              
              notif.style.display = shouldShow ? 'flex' : 'none';
          });
          
          checkEmptySections();
      }
      
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
      
      function updateFilterButtonState() {
          const hasActiveFilter = document.getElementById('statusFilter').value || 
                                document.getElementById('dateFilter').value;
          
          if (hasActiveFilter) {
              filterToggle.classList.remove('bg-white', 'border-gray-300');
              filterToggle.classList.add('bg-pink-50', 'border-pink-300');
          } else {
              filterToggle.classList.remove('bg-pink-50', 'border-pink-300');
              filterToggle.classList.add('bg-white', 'border-gray-300');
          }
      }
  });
</script>
  