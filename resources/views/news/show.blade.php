<x-main-layout>
    <x-slot name="header">
        <h1 class="text-2xl font-bold">{{ $item->meta_title ?: $item->title }}</h1>
    </x-slot>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
    <article class="max-w-5xl">
        <header class="mb-6">
            <div class="text-sm text-gray-500 dark:text-gray-400">{{ optional($item->published_at)->format('d/m/Y') }}</div>
            <h1 class="text-3xl font-bold text-gray-900 dark:text-gray-100">{{ $item->title }}</h1>
            @if($item->relationLoaded('taxonomies') && $item->taxonomies->count())
                <div class="mt-3 flex flex-wrap gap-2">
                    @foreach($item->taxonomies as $tx)
                        @php($slug = $tx->slug)
                        <a href="{{ route('news.taxonomy', ['taxonomySlug' => $slug]) }}"
                           class="inline-flex items-center px-2.5 py-1.5 rounded-full text-xs font-medium bg-orange-50 text-orange-700 dark:bg-orange-900/20 dark:text-orange-300 border border-orange-200 dark:border-orange-800 hover:bg-orange-100 dark:hover:bg-orange-900/30 transition">
                            {{ __('taxonomy.' . $slug . '.label') }}
                        </a>
                    @endforeach
                </div>
            @endif
            @if($item->excerpt)
                <p class="mt-2 text-gray-600 dark:text-gray-300">{{ $item->excerpt }}</p>
            @endif
        </header>

        <div class="prose dark:prose-invert max-w-none">
            @if($item->cover_image)
                <img src="{{ Storage::url($item->cover_image) }}" alt="{{ $item->title }}" class="float-left w-80 h-auto rounded-xl object-cover max-h-96 mr-6 mb-4 shadow-lg">
            @endif
            {!! $item->body !!}
        </div>
    </article>
    </div>
</x-main-layout>
