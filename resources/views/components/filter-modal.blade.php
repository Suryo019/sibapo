<div id="filterModal" class="mt-10 absolute hidden items-center justify-center z-50">
    <!-- Modal Content -->
    <div class="bg-white w-96 max-md:w-80 rounded-lg shadow-black-custom p-6 relative">
        <!-- Close Button -->
        <button onclick="toggleModal()" class="absolute top-2 right-2 text-gray-500 hover:text-gray-700">
            <i class="bi bi-x text-4xl"></i> 
        </button>
        
        <h2 class="text-center text-pink-500 font-semibold text-lg mb-4">
            Filter
        </h2>

        {{ $slot }}
    </div>
</div>