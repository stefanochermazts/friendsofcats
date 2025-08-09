<x-main-layout>
    <div class="py-12 bg-gray-50 dark:bg-gray-900 min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="mb-8 text-center">
                <h1 class="text-3xl font-bold text-gray-900 dark:text-white">Adozioni per Città</h1>
                <p class="text-gray-600 dark:text-gray-400 mt-2">Seleziona una città per vedere i gatti adottabili</p>
            </div>

            @if(($adoptionCityCounts ?? collect())->count())
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($adoptionCityCounts as $city => $count)
                        @php $slug = \Illuminate\Support\Str::of($city)->slug('-'); @endphp
                        <a href="{{ route('public.adoptions.city', ['citySlug' => $slug]) }}" class="group block bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-2xl p-6 hover:shadow-xl transition-all duration-300 hover:-translate-y-1">
                            <div class="flex items-center justify-between">
                                <div>
                                    <div class="text-lg font-semibold text-gray-900 dark:text-white group-hover:text-orange-600 dark:group-hover:text-orange-400">{{ $city }}</div>
                                    <div class="text-sm text-gray-500 dark:text-gray-400">{{ $count }} gatti adottabili</div>
                                </div>
                                <div class="w-12 h-12 rounded-xl bg-orange-500/10 flex items-center justify-center text-2xl">🐾</div>
                            </div>
                        </a>
                    @endforeach
                </div>
            @else
                <div class="text-center text-gray-500 dark:text-gray-400">Nessuna città disponibile al momento.</div>
            @endif
        </div>
    </div>
</x-main-layout> 