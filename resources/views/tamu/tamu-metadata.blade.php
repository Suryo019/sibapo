<x-tamu-layout>
  <div class="px-4 sm:px-6 lg:px-8 py-10">
    <h1 class="text-center text-4xl md:text-5xl lg:text-6xl font-extrabold text-pink-600 mb-8">
      Metadata
    </h1>
    
    <div class="w-full max-w-4xl mx-auto bg-gray-10 border-gray-20 border-[3px] rounded-[20px] p-6 sm:p-8">
      <h2 class="text-xl sm:text-2xl font-bold text-gray-800 mb-6">Komoditas</h2>
      
      <ol class="list-decimal list-inside space-y-2 text-gray-800 text-sm sm:text-base font-bold">
        @foreach ($bahanPokok as $item)
          <li>{{ $item }}</li>
        @endforeach
      </ol>
    </div>
  </div>
</x-tamu-layout>
