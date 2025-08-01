@props(['title' => ''])

<x-layouts.auth :title="$title">
    {{ $slot }}
</x-layouts.auth> 