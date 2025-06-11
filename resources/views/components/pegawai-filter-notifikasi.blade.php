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
document.addEventListener("DOMContentLoaded",(function(){const e=document.getElementById("filterToggle"),t=document.getElementById("filterDropdown"),n=document.getElementById("filterChevron"),s=document.getElementById("applyFilter");e.addEventListener("click",(function(e){e.stopPropagation();t.classList.contains("hidden")?(t.classList.remove("hidden"),n.style.transform="rotate(180deg)"):(t.classList.add("hidden"),n.style.transform="rotate(0deg)")})),document.addEventListener("click",(function(s){e.contains(s.target)||t.contains(s.target)||(t.classList.add("hidden"),n.style.transform="rotate(0deg)")})),s.addEventListener("click",(function(){const s=document.getElementById("statusFilter").value;document.getElementById("dateFilter").value;!function(e,t){document.querySelectorAll(".notif-item").forEach((n=>{let s=!0;if(e){const t=n.classList.contains("opacity-75");"completed"!==e||t||(s=!1),"pending"===e&&t&&(s=!1)}if(t){const e=n.querySelector(".text-gray-400"),d=e?e.textContent.toLowerCase():"";switch(t){case"today":d.includes("jam")||d.includes("menit")||d.includes("detik")||(s=!1);break;case"yesterday":d.includes("1 hari")||d.includes("kemarin")||(s=!1);break;case"week":(d.includes("minggu")||d.includes("bulan")||d.includes("tahun"))&&(s=!1);break;case"month":(d.includes("bulan")||d.includes("tahun"))&&(s=!1)}}n.style.display=s?"flex":"none"})),document.querySelectorAll("h3").forEach((e=>{const t=e.parentElement;0===t.querySelectorAll('.notif-item[style*="flex"], .notif-item:not([style*="none"])').length?t.style.display="none":t.style.display="block"}))}(s,message),t.classList.add("hidden"),n.style.transform="rotate(0deg)",document.getElementById("statusFilter").value||document.getElementById("dateFilter").value?(e.classList.remove("bg-white","border-gray-300"),e.classList.add("bg-pink-50","border-pink-300")):(e.classList.remove("bg-pink-50","border-pink-300"),e.classList.add("bg-white","border-gray-300"))}))}));
</script>
  