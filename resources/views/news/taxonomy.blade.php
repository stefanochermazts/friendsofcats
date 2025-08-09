<x-main-layout>
    <x-slot name="header">
        <h1 class="text-2xl font-bold">🗂️ {{ __('taxonomy.' . $taxonomy->slug . '.label', [], app()->getLocale()) }}</h1>
    </x-slot>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
        @php($slug = $taxonomy->slug)
        @php($desc = __('taxonomy.' . $slug . '.description'))
        @if($desc && $desc !== 'taxonomy.' . $slug . '.description')
            <p class="mb-6 text-gray-600 dark:text-gray-300">{{ $desc }}</p>
        @endif

        @if($news->count())
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($news as $item)
                    <a href="{{ route('news.show', $item->slug) }}" class="block bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-800 rounded-xl overflow-hidden hover:shadow-lg transition">
                        @if($item->cover_image)
                            <img src="{{ Storage::url($item->cover_image) }}" alt="{{ $item->title }}" class="w-full h-48 object-cover">
                        @endif
                        <div class="p-5">
                            <div class="text-sm text-gray-500 dark:text-gray-400">{{ optional($item->published_at)->format('d/m/Y') }}</div>
                            <h2 class="text-xl font-semibold text-gray-900 dark:text-gray-100 mt-1">{{ $item->title }}</h2>
                            @if($item->excerpt)
                                <p class="mt-2 text-gray-600 dark:text-gray-300">{{ \Illuminate\Support\Str::limit($item->excerpt, 120) }}</p>
                            @endif
                        </div>
                    </a>
                @endforeach
            </div>
        @else
            <div class="text-gray-600 dark:text-gray-300">{{ __('taxonomy.empty') }}</div>
        @endif
    </div>
</x-main-layout>


