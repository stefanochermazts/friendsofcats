{{-- Main Navigation Component --}}
<nav class="hidden md:flex items-center space-x-6" role="navigation" aria-label="{{ __('Primary') }}">
    {{-- Home --}}
    <a href="{{ route('welcome') }}" 
       class="text-gray-700 dark:text-gray-300 hover:text-orange-500 dark:hover:text-orange-400 transition-colors duration-200 focus:outline-none focus-visible:ring-2 focus-visible:ring-orange-500 focus-visible:ring-offset-2 focus-visible:ring-offset-white dark:focus-visible:ring-offset-gray-900">
        {{ __('home') }}
    </a>
    
    {{-- Adoptions --}}
    <a href="{{ route('public.adoptions.index') }}" 
       class="text-gray-700 dark:text-gray-300 hover:text-orange-500 dark:hover:text-orange-400 transition-colors duration-200 font-medium focus:outline-none focus-visible:ring-2 focus-visible:ring-orange-500 focus-visible:ring-offset-2 focus-visible:ring-offset-white dark:focus-visible:ring-offset-gray-900">
        {{ __('adoptions.title') }}
    </a>
    
    {{-- Professionals --}}
    <a href="{{ route('professionals.index') }}" 
       class="text-gray-700 dark:text-gray-300 hover:text-orange-500 dark:hover:text-orange-400 transition-colors duration-200 font-medium focus:outline-none focus-visible:ring-2 focus-visible:ring-orange-500 focus-visible:ring-offset-2 focus-visible:ring-offset-white dark:focus-visible:ring-offset-gray-900">
        {{ __('professionals.directory_title') }}
    </a>
    
    {{-- CatBook (only for authenticated users) --}}
    @auth
        <a href="{{ route('catbook.index') }}" 
           class="text-gray-700 dark:text-gray-300 hover:text-orange-500 dark:hover:text-orange-400 transition-colors duration-200 font-medium focus:outline-none focus-visible:ring-2 focus-visible:ring-orange-500 focus-visible:ring-offset-2 focus-visible:ring-offset-white dark:focus-visible:ring-offset-gray-900">
            🐾 CatBook
        </a>
    @endauth
    
    {{-- Contact --}}
    <a href="{{ route('contact') }}" 
       class="text-gray-700 dark:text-gray-300 hover:text-orange-500 dark:hover:text-orange-400 transition-colors duration-200 focus:outline-none focus-visible:ring-2 focus-visible:ring-orange-500 focus-visible:ring-offset-2 focus-visible:ring-offset-white dark:focus-visible:ring-offset-gray-900">
        {{ __('contact.title') }}
    </a>
    
    {{-- Future menu items can be added here --}}
    {{-- 
    <a href="#" class="text-gray-700 dark:text-gray-300 hover:text-orange-500 dark:hover:text-orange-400 transition-colors duration-200">
        Menu Item
    </a>
    --}}
</nav>