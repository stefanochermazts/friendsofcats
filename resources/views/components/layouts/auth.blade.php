@props(['title' => ''])

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'CatFriends Club') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700&display=swap" rel="stylesheet" />

        <!-- Theme Script (prevents flash) -->
        <script>
            (function() {
                const theme = localStorage.getItem('theme') || 
                    (window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light');
                
                if (theme === 'dark') {
                    document.documentElement.classList.add('dark');
                    document.documentElement.style.colorScheme = 'dark';
                } else {
                    document.documentElement.classList.remove('dark');
                    document.documentElement.style.colorScheme = 'light';
                }
            })();
        </script>

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-['Inter'] bg-white dark:bg-gray-950 text-gray-900 dark:text-gray-100 antialiased">
        {{-- Header --}}
        <header class="border-b border-gray-100 dark:border-gray-800">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between items-center h-16">
                    {{-- Logo --}}
                    <div class="flex items-center">
                        <a href="{{ route('welcome') }}" class="flex items-center space-x-3">
                            <x-cat-logo class="w-10 h-10">
                                <span class="text-xl font-bold text-gray-900 dark:text-white">
                                    {{ __('friends_of_cats') }}
                                </span>
                            </x-cat-logo>
                        </a>
                    </div>
                    
                    {{-- Navigation --}}
                    <div class="flex items-center space-x-4">
                        {{-- Main Navigation Menu --}}
                        <x-main-navigation />
                        
                        {{-- Theme Toggle --}}
                        <x-public-theme-toggle />
                        
                        {{-- Language Selector --}}
                        <x-public-language-selector />
                        
                        {{-- Auth Links --}}
                        <div class="flex items-center space-x-3">
                            @auth
                                @if(auth()->user()->role === 'admin')
                                    <a href="{{ url('/admin') }}" 
                                       class="inline-flex items-center px-4 py-2 bg-orange-500 hover:bg-orange-600 text-white font-medium rounded-lg transition-colors duration-200">
                                        Admin
                                    </a>
                                @else
                                    <a href="{{ url('/dashboard') }}" 
                                       class="inline-flex items-center px-4 py-2 bg-orange-500 hover:bg-orange-600 text-white font-medium rounded-lg transition-colors duration-200">
                                        Dashboard
                                    </a>
                                @endif
                            @else
                                <a href="{{ route('login') }}" 
                                   class="inline-flex items-center px-4 py-2 text-gray-700 dark:text-gray-300 hover:text-gray-900 dark:hover:text-white font-medium transition-colors duration-200">
                                    {{ __('login') }}
                                </a>
                                
                                @if (Route::has('register'))
                                    <a href="{{ route('register') }}" 
                                       class="inline-flex items-center px-4 py-2 bg-orange-500 hover:bg-orange-600 text-white font-medium rounded-lg transition-colors duration-200">
                                        {{ __('register') }}
                                    </a>
                                @endif
                            @endauth
                        </div>
                    </div>
                </div>
            </div>
        </header>

        {{-- Main Content --}}
        <main class="min-h-screen flex flex-col justify-center py-12 sm:px-6 lg:px-8">
            <div class="sm:mx-auto sm:w-full sm:max-w-md">
                <div class="bg-white dark:bg-gray-800 py-8 px-4 shadow sm:rounded-lg sm:px-10">
                    @if($title)
                        <div class="text-center mb-8">
                            <h2 class="text-3xl font-bold text-gray-900 dark:text-white">
                                {{ $title }}
                            </h2>
                            <p class="mt-2 text-sm text-gray-600 dark:text-gray-400">
                                {{ __('auth_subtitle') }}
                            </p>
                        </div>
                    @endif
                    
                    {{ $slot }}
                </div>
            </div>
        </main>

        {{-- Footer --}}
        <footer class="bg-gray-50 dark:bg-gray-900 border-t border-gray-100 dark:border-gray-800">
            <div class="max-w-7xl mx-auto py-12 px-4 sm:px-6 lg:px-8">
                <div class="text-center">
                    <p class="text-gray-600 dark:text-gray-400">
                        © {{ date('Y') }} {{ __('friends_of_cats') }}. {{ __('all_rights_reserved') }}.
                    </p>
                    <p class="mt-2 text-sm text-gray-500 dark:text-gray-500">
                        {{ __('platform_description') }}
                    </p>
                </div>
            </div>
        </footer>
    </body>
</html> 