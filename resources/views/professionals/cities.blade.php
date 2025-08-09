<x-main-layout>
    <div class="py-12 bg-gray-50 dark:bg-gray-900 min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="mb-8 text-center">
                <h1 class="text-3xl font-bold text-gray-900 dark:text-white">Professionisti per Città</h1>
                <p class="text-gray-600 dark:text-gray-400 mt-2">Seleziona una città per vedere veterinari e toelettatori</p>
            </div>

            @if(($professionalCityCounts ?? collect())->count())
                <div class="flex flex-wrap gap-3 justify-center">
                    @foreach($professionalCityCounts as $city => $count)
                        @php $slug = \Illuminate\Support\Str::of($city)->slug('-'); @endphp
                        <a href="{{ route('professionals.city', ['citySlug' => $slug]) }}" class="inline-flex items-center px-4 py-2 rounded-full border border-purple-200 dark:border-purple-800 bg-white dark:bg-gray-800 text-sm font-medium text-gray-700 dark:text-gray-200 hover:border-purple-400 dark:hover:border-purple-500 hover:shadow-sm transition-all">
                            <span class="mr-2">🏥</span>
                            <span>{{ $city }}</span>
                            <span class="ml-2 text-purple-600 dark:text-purple-400 font-semibold">{{ $count }}</span>
                        </a>
                    @endforeach
                </div>
            @else
                <div class="text-center text-gray-500 dark:text-gray-400">Nessuna città disponibile al momento.</div>
            @endif
        </div>
    </div>
</x-main-layout> 