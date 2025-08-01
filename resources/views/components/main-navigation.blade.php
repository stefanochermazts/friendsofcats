{{-- Main Navigation Component --}}
<nav class="hidden md:flex items-center space-x-6">
    {{-- Home --}}
    <a href="{{ route('welcome') }}" 
       class="text-gray-700 dark:text-gray-300 hover:text-orange-500 dark:hover:text-orange-400 transition-colors duration-200">
        {{ __('home') }}
    </a>
    
    {{-- Contact --}}
    <a href="{{ route('contact') }}" 
       class="text-gray-700 dark:text-gray-300 hover:text-orange-500 dark:hover:text-orange-400 transition-colors duration-200">
        {{ __('contact') }}
    </a>
    
    {{-- Future menu items can be added here --}}
    {{-- 
    <a href="#" class="text-gray-700 dark:text-gray-300 hover:text-orange-500 dark:hover:text-orange-400 transition-colors duration-200">
        Menu Item
    </a>
    --}}
</nav> 