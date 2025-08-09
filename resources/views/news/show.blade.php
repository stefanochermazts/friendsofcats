<x-main-layout>
    <x-slot name="header">
        <h1 class="text-2xl font-bold">{{ $item->meta_title ?: $item->title }}</h1>
    </x-slot>

    <article class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
        <header class="mb-6">
            <div class="text-sm text-gray-500 dark:text-gray-400">{{ optional($item->published_at)->format('d/m/Y') }}</div>
            <h1 class="text-3xl font-bold text-gray-900 dark:text-gray-100">{{ $item->title }}</h1>
            @if($item->excerpt)
                <p class="mt-2 text-gray-600 dark:text-gray-300">{{ $item->excerpt }}</p>
            @endif
        </header>

        @if($item->cover_image)
            <img src="{{ Storage::url($item->cover_image) }}" alt="{{ $item->title }}" class="w-full rounded-xl mb-6">
        @endif

        <div class="prose dark:prose-invert max-w-none">
            {!! $item->body !!}
        </div>
    </article>
</x-main-layout>
