<div class="flex items-center border bg-gray-10 rounded-[10px] w-full lg:w-64 h-9 px-5">
    <input id="searchNotifikasi" type="text" class="flex-grow outline-none bg-transparent" placeholder="Cari dinas...">
    <span class="bi bi-search text-gray-700"></span>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const searchInput = document.getElementById('searchNotifikasi');
        let searchTimeout;

        searchInput.addEventListener('input', function() {
            const searchTerm = this.value.toLowerCase().trim();
            
            clearTimeout(searchTimeout);
            searchTimeout = setTimeout(() => {
                performSearch(searchTerm);
            }, 300);
        });

        function performSearch(searchTerm) {
            const allNotifs = document.querySelectorAll('.notif-item');
            let hasResults = false;
            
            allNotifs.forEach(notif => {
                const message = notif.querySelector('.text-gray-600');
                const role = notif.querySelector('.text-yellow-500');
                
                const messageText = message ? message.textContent.toLowerCase() : '';
                const roleText = role ? role.textContent.toLowerCase() : '';
                
                const shouldShow = searchTerm === '' || 
                                    messageText.includes(searchTerm) || 
                                    roleText.includes(searchTerm);
                
                if (shouldShow) {
                    notif.style.display = 'flex';
                    hasResults = true;
                } else {
                    notif.style.display = 'none';
                }
            });
        }
    });
</script>