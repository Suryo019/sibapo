<div class="w-full flex justify-end mb-4 relative">
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
  </div>
  
  <script>
    const toggleBtn = document.getElementById('dropdownToggle');
    const dropdown = document.getElementById('dropdownMenu');
    const items = document.querySelectorAll('.dropdown-item');
  
    toggleBtn.addEventListener('click', () => {
      dropdown.classList.toggle('hidden');
    });
  
    items.forEach(item => {
      item.addEventListener('click', () => {
        dropdown.classList.add('hidden');
      });
    });
  
    // Optional: Tutup dropdown jika klik di luar
    document.addEventListener('click', (e) => {
      if (!toggleBtn.contains(e.target) && !dropdown.contains(e.target)) {
        dropdown.classList.add('hidden');
      }
    });
  </script>
  