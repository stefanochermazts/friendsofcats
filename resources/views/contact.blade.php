<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>{{ __('contact.title') }} - {{ __('friends_of_cats') }}</title>
        <meta name="description" content="{{ __('contact.subtitle') }}">

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

        <!-- Styles / Scripts -->
        @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
            @vite(['resources/css/app.css', 'resources/js/app.js'])
        @else
            <style>/*! tailwindcss v4.0.7 | MIT License | https://tailwindcss.com */
            </style>
        @endif
    </head>
    <body class="font-['Inter'] bg-white dark:bg-gray-950 text-gray-900 dark:text-gray-100 antialiased">
        {{-- Header --}}
        <header class="border-b border-gray-100 dark:border-gray-800">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between items-center h-16">
                    {{-- Logo --}}
                    <div class="flex items-center">
                        <x-cat-logo class="w-10 h-10">
                            <span class="text-xl font-bold text-gray-900 dark:text-white">
                                {{ __('friends_of_cats') }}
                            </span>
                        </x-cat-logo>
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
                            @if (Route::has('login'))
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
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </header>
        
        {{-- Main Content --}}
        <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <!-- Header -->
            <div class="text-center mb-12">
                <h1 class="text-4xl font-bold text-gray-900 dark:text-white mb-4">
                    {{ __('contact.title') }}
                </h1>
                <p class="text-lg text-gray-600 dark:text-gray-400 max-w-2xl mx-auto">
                    {{ __('contact.subtitle') }}
                </p>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12">
                <!-- Informazioni di Contatto -->
                <div class="space-y-8">
                    <div>
                        <h2 class="text-2xl font-semibold text-gray-900 dark:text-white mb-6">
                            {{ __('contact.contact_info') }}
                        </h2>
                        
                        <div class="space-y-6">
                            <!-- Email -->
                            <div class="flex items-start space-x-4">
                                <div class="flex-shrink-0">
                                    <svg class="w-6 h-6 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                    </svg>
                                </div>
                                <div>
                                    <h3 class="text-lg font-medium text-gray-900 dark:text-white">{{ __('contact.email') }}</h3>
                                    <p class="text-gray-600 dark:text-gray-400">info@friendsofcats.com</p>
                                </div>
                            </div>

                            <!-- Telefono -->
                            <div class="flex items-start space-x-4">
                                <div class="flex-shrink-0">
                                    <svg class="w-6 h-6 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                                    </svg>
                                </div>
                                <div>
                                    <h3 class="text-lg font-medium text-gray-900 dark:text-white">{{ __('contact.phone') }}</h3>
                                    <p class="text-gray-600 dark:text-gray-400">+39 123 456 7890</p>
                                </div>
                            </div>

                            <!-- Orari -->
                            <div class="flex items-start space-x-4">
                                <div class="flex-shrink-0">
                                    <svg class="w-6 h-6 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                </div>
                                <div>
                                    <h3 class="text-lg font-medium text-gray-900 dark:text-white">{{ __('contact.hours') }}</h3>
                                    <p class="text-gray-600 dark:text-gray-400">{{ __('contact.hours_text') }}</p>
                                </div>
                            </div>

                            <!-- Indirizzo -->
                            <div class="flex items-start space-x-4">
                                <div class="flex-shrink-0">
                                    <svg class="w-6 h-6 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    </svg>
                                </div>
                                <div>
                                    <h3 class="text-lg font-medium text-gray-900 dark:text-white">{{ __('contact.address') }}</h3>
                                    <p class="text-gray-600 dark:text-gray-400">{{ __('contact.address_text') }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Social Media -->
                    <div>
                        <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-4">
                            {{ __('contact.follow_us') }}
                        </h3>
                        <div class="flex space-x-4">
                            <a href="#" class="text-gray-400 hover:text-orange-500 transition-colors duration-200">
                                <span class="sr-only">Facebook</span>
                                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                                </svg>
                            </a>
                            <a href="#" class="text-gray-400 hover:text-orange-500 transition-colors duration-200">
                                <span class="sr-only">Instagram</span>
                                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M12.017 0C5.396 0 .029 5.367.029 11.987c0 6.62 5.367 11.987 11.988 11.987 6.62 0 11.987-5.367 11.987-11.987C24.014 5.367 18.637.001 12.017.001zM8.449 16.988c-1.297 0-2.448-.49-3.323-1.297C4.198 14.895 3.708 13.744 3.708 12.447s.49-2.448 1.297-3.323c.875-.807 2.026-1.297 3.323-1.297s2.448.49 3.323 1.297c.807.875 1.297 2.026 1.297 3.323s-.49 2.448-1.297 3.323c-.875.807-2.026 1.297-3.323 1.297zm7.718-1.297c-.875.807-2.026 1.297-3.323 1.297s-2.448-.49-3.323-1.297c-.807-.875-1.297-2.026-1.297-3.323s.49-2.448 1.297-3.323c.875-.807 2.026-1.297 3.323-1.297s2.448.49 3.323 1.297c.807.875 1.297 2.026 1.297 3.323s-.49 2.448-1.297 3.323z"/>
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Form di Contatto -->
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg p-8 border border-gray-200 dark:border-gray-700">
                    <h2 class="text-2xl font-semibold text-gray-900 dark:text-white mb-6">
                        {{ __('contact.send_message') }}
                    </h2>

                    @if(session('success'))
                        <div class="mb-6 p-4 bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 text-green-800 dark:text-green-200 rounded-lg">
                            <div class="flex items-center">
                                <svg class="w-5 h-5 mr-2 text-green-600 dark:text-green-400" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                </svg>
                                <span class="font-medium">{{ session('success') }}</span>
                            </div>
                        </div>
                    @endif

                    @if($errors->has('error'))
                        <div class="mb-6 p-4 bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 text-red-800 dark:text-red-200 rounded-lg">
                            <div class="flex items-center">
                                <svg class="w-5 h-5 mr-2 text-red-600 dark:text-red-400" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path>
                                </svg>
                                <span class="font-medium">{{ $errors->first('error') }}</span>
                            </div>
                        </div>
                    @endif

                    <form action="{{ route('contact.store') }}" method="POST" class="space-y-6">
                        @csrf
                        
                        <!-- Parametri contestuali -->
                        @if(request('gatto'))
                            <input type="hidden" name="gatto" value="{{ request('gatto') }}">
                        @endif
                        @if(request('associazione'))
                            <input type="hidden" name="associazione" value="{{ request('associazione') }}">
                        @endif
                        @if(request('professional_id'))
                            <input type="hidden" name="professional_id" value="{{ request('professional_id') }}">
                        @endif
                        
                        <!-- Nome -->
                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                {{ __('contact.name') }} *
                            </label>
                            <input type="text" 
                                   id="name" 
                                   name="name" 
                                   value="{{ old('name') }}"
                                   class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-orange-500 dark:bg-gray-700 dark:text-white"
                                   required>
                            @error('name')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Email -->
                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                {{ __('contact.email') }} *
                            </label>
                            <input type="email" 
                                   id="email" 
                                   name="email" 
                                   value="{{ old('email') }}"
                                   class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-orange-500 dark:bg-gray-700 dark:text-white"
                                   required>
                            @error('email')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Oggetto -->
                        <div>
                            <label for="subject" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                {{ __('contact.subject') }} *
                            </label>
                            <input type="text" 
                                   id="subject" 
                                   name="subject" 
                                   value="{{ old('subject', request('professional_name') ? __('contact.subject_professional', ['name' => request('professional_name')]) : (request('gatto') ? 'Richiesta adozione per ' . request('gatto') : '')) }}"
                                   class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-orange-500 dark:bg-gray-700 dark:text-white"
                                   required>
                            @error('subject')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Messaggio -->
                        <div>
                            <label for="message" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                {{ __('contact.message') }} *
                            </label>
                            <textarea id="message" 
                                      name="message" 
                                      rows="5"
                                      class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-orange-500 dark:bg-gray-700 dark:text-white"
                                      required>{{ old('message', request('professional_name') ? __('contact.message_professional_prefill', ['professional' => request('professional_name'), 'platform' => __('friends_of_cats')]) : (request('gatto') && request('associazione') ? 'Ciao ' . request('associazione') . ',

Sono interessato/a all\'adozione di ' . request('gatto') . ', il gatto che ho visto sul vostro profilo su FriendsOfCats.

Potreste fornirmi maggiori informazioni sul processo di adozione e su come procedere?

Grazie per il vostro lavoro con i gatti!

Cordiali saluti' : '')) }}</textarea>
                            @error('message')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Pulsante Invia -->
                        <div>
                            <button type="submit" 
                                    class="w-full bg-orange-500 hover:bg-orange-600 text-white font-medium py-2 px-4 rounded-md transition-colors duration-200">
                                {{ __('contact.send') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </main>
    </body>
</html> 