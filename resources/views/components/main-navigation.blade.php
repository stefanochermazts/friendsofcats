{{-- Main Navigation Component --}}
<nav class="hidden md:flex items-center space-x-6">
    {{-- Home --}}
    <a href="{{ route('welcome') }}" 
       class="text-gray-700 dark:text-gray-300 hover:text-orange-500 dark:hover:text-orange-400 transition-colors duration-200">
        {{ __('home') }}
    </a>
    
    {{-- Adoptions --}}
    <a href="{{ route('public.adoptions.index') }}" 
       class="text-gray-700 dark:text-gray-300 hover:text-orange-500 dark:hover:text-orange-400 transition-colors duration-200 font-medium">
        {{ __('adoptions.title') }}
    </a>
    
    {{-- Contact --}}
    <a href="{{ route('contact') }}" 
       class="text-gray-700 dark:text-gray-300 hover:text-orange-500 dark:hover:text-orange-400 transition-colors duration-200">
        {{ __('contact.title') }}
    </a>
    
    {{-- CatBook (only for authenticated users) --}}
    @auth
        <a href="{{ route('catbook.index') }}" 
           class="text-gray-700 dark:text-gray-300 hover:text-orange-500 dark:hover:text-orange-400 transition-colors duration-200 font-medium">
            🐾 CatBook
        </a>
    @endauth
    
    {{-- Future menu items can be added here --}}
    {{-- 
    <a href="#" class="text-gray-700 dark:text-gray-300 hover:text-orange-500 dark:hover:text-orange-400 transition-colors duration-200">
        Menu Item
    </a>
    --}}
</nav> 
    {{-- 
    <a href="#" class="text-gray-700 dark:text-gray-300 hover:text-orange-500 dark:hover:text-orange-400 transition-colors duration-200">
        Menu Item
    </a>
    --}}
</nav> 