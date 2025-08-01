{{-- Public Language Selector Component for Homepage Header --}}
<div x-data="{ open: false }" class="relative">
    <button @click="open = !open" 
            @keydown.escape="open = false"
            @click.away="open = false"
            class="inline-flex items-center px-3 py-2 text-sm font-medium text-gray-700 dark:text-gray-300 hover:text-gray-900 dark:hover:text-gray-100 focus:outline-none transition-colors duration-200"
            aria-expanded="false"
            aria-haspopup="true"
            aria-label="{{ __('Language') }}">
        
        {{-- Globe icon --}}
        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 21a9.004 9.004 0 008.716-6.747M12 21a9.004 9.004 0 01-8.716-6.747M12 21c2.485 0 4.5-4.03 4.5-9S14.485 3 12 3m0 18c-2.485 0-4.5-4.03-4.5-9S9.515 3 12 3m0 0a8.997 8.997 0 017.843 4.582M12 3a8.997 8.997 0 00-7.843 4.582m15.686 0A11.953 11.953 0 0112 10.5c-2.998 0-5.74-1.1-7.843-2.918m15.686 0A8.959 8.959 0 0121 12.75c0 .526-.043 1.042-.127 1.545M3.127 14.295A8.959 8.959 0 003 12.75c0-.526.043-1.042.127-1.545m0 0A11.953 11.953 0 0112 10.5c2.998 0 5.74-1.1 7.843-2.918"/>
        </svg>
        
        {{-- Current language code --}}
        <span class="text-xs font-semibold uppercase tracking-wide">
            {{ app()->getLocale() }}
        </span>
        
        {{-- Chevron down --}}
        <svg class="w-4 h-4 ml-1 transition-transform duration-200" 
             :class="{ 'rotate-180': open }"
             fill="currentColor" viewBox="0 0 20 20" aria-hidden="true">
            <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
        </svg>
    </button>

    {{-- Dropdown menu --}}
    <div x-show="open"
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="transform opacity-0 scale-95"
         x-transition:enter-end="transform opacity-100 scale-100"
         x-transition:leave="transition ease-in duration-150"
         x-transition:leave-start="transform opacity-100 scale-100"
         x-transition:leave-end="transform opacity-0 scale-95"
         class="absolute right-0 mt-2 w-48 bg-white dark:bg-gray-800 rounded-lg shadow-lg border border-gray-200 dark:border-gray-700 py-1 z-50"
         role="menu"
         aria-orientation="vertical"
         aria-labelledby="language-menu">
        
        {{-- Italian --}}
        <a href="{{ route('locale.change', 'it') }}" 
           class="flex items-center px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 hover:text-gray-900 dark:hover:text-gray-100 transition-colors duration-200 {{ app()->getLocale() === 'it' ? 'bg-orange-50 dark:bg-orange-900/30 text-orange-700 dark:text-orange-300' : '' }}"
           role="menuitem">
            <span class="mr-3 text-lg">🇮🇹</span>
            <span class="font-medium">{{ __('italiano') }}</span>
            @if(app()->getLocale() === 'it')
                <svg class="w-4 h-4 ml-auto text-orange-600 dark:text-orange-400" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                </svg>
            @endif
        </a>
        
        {{-- English --}}
        <a href="{{ route('locale.change', 'en') }}" 
           class="flex items-center px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 hover:text-gray-900 dark:hover:text-gray-100 transition-colors duration-200 {{ app()->getLocale() === 'en' ? 'bg-orange-50 dark:bg-orange-900/30 text-orange-700 dark:text-orange-300' : '' }}"
           role="menuitem">
            <span class="mr-3 text-lg">🇬🇧</span>
            <span class="font-medium">{{ __('inglese') }}</span>
            @if(app()->getLocale() === 'en')
                <svg class="w-4 h-4 ml-auto text-orange-600 dark:text-orange-400" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                </svg>
            @endif
        </a>
        
        {{-- French --}}
        <a href="{{ route('locale.change', 'fr') }}" 
           class="flex items-center px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 hover:text-gray-900 dark:hover:text-gray-100 transition-colors duration-200 {{ app()->getLocale() === 'fr' ? 'bg-orange-50 dark:bg-orange-900/30 text-orange-700 dark:text-orange-300' : '' }}"
           role="menuitem">
            <span class="mr-3 text-lg">🇫🇷</span>
            <span class="font-medium">{{ __('francese') }}</span>
            @if(app()->getLocale() === 'fr')
                <svg class="w-4 h-4 ml-auto text-orange-600 dark:text-orange-400" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                </svg>
            @endif
        </a>
        
        {{-- German --}}
        <a href="{{ route('locale.change', 'de') }}" 
           class="flex items-center px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 hover:text-gray-900 dark:hover:text-gray-100 transition-colors duration-200 {{ app()->getLocale() === 'de' ? 'bg-orange-50 dark:bg-orange-900/30 text-orange-700 dark:text-orange-300' : '' }}"
           role="menuitem">
            <span class="mr-3 text-lg">🇩🇪</span>
            <span class="font-medium">{{ __('tedesco') }}</span>
            @if(app()->getLocale() === 'de')
                <svg class="w-4 h-4 ml-auto text-orange-600 dark:text-orange-400" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                </svg>
            @endif
        </a>
        
        {{-- Spanish --}}
        <a href="{{ route('locale.change', 'es') }}" 
           class="flex items-center px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 hover:text-gray-900 dark:hover:text-gray-100 transition-colors duration-200 {{ app()->getLocale() === 'es' ? 'bg-orange-50 dark:bg-orange-900/30 text-orange-700 dark:text-orange-300' : '' }}"
           role="menuitem">
            <span class="mr-3 text-lg">🇪🇸</span>
            <span class="font-medium">{{ __('spagnolo') }}</span>
            @if(app()->getLocale() === 'es')
                <svg class="w-4 h-4 ml-auto text-orange-600 dark:text-orange-400" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                </svg>
            @endif
        </a>
    </div>
</div>