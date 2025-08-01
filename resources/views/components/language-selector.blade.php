<div x-data="{ open: false }" class="relative">
    <button @click="open = !open" 
            @keydown.escape="open = false"
            @click.away="open = false"
            class="inline-flex items-center px-3 py-2 border border-neutral-300 dark:border-neutral-600 text-sm leading-4 font-medium rounded-xl text-neutral-700 dark:text-neutral-300 bg-white dark:bg-neutral-800 hover:text-neutral-900 dark:hover:text-neutral-100 hover:bg-neutral-50 dark:hover:bg-neutral-700 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:ring-offset-2 transition-all duration-200"
            aria-expanded="false"
            aria-haspopup="true"
            aria-label="{{ __('Lingua') }}">
        <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20" aria-hidden="true">
            <path fill-rule="evenodd" d="M7 2a1 1 0 011 1v1h3a1 1 0 110 2H9.578a18.87 18.87 0 01-1.724 4.78c.29.354.596.696.914 1.026a1 1 0 11-1.44 1.389c-.34-.354-.66-.714-.96-1.08A18.458 18.458 0 014.5 8.5a1 1 0 110-2H3V3a1 1 0 011-1h2zM14 2a1 1 0 011 1v1h2a1 1 0 110 2h-1.5a18.458 18.458 0 01-1.04 2.72c.3.366.62.726.96 1.08a1 1 0 11-1.44 1.389c-.318-.33-.624-.672-.914-1.026A18.87 18.87 0 0110.422 8H9a1 1 0 110-2h3V3a1 1 0 011-1h1z" clip-rule="evenodd" />
        </svg>
        <span class="hidden sm:block">{{ __('Lingua') }}</span>
        <svg class="fill-current h-4 w-4 ml-1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" aria-hidden="true">
            <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
        </svg>
    </button>

    <div x-show="open"
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="transform opacity-0 scale-95"
         x-transition:enter-end="transform opacity-100 scale-100"
         x-transition:leave="transition ease-in duration-150"
         x-transition:leave-start="transform opacity-100 scale-100"
         x-transition:leave-end="transform opacity-0 scale-95"
         class="absolute right-0 mt-2 w-48 bg-white dark:bg-neutral-800 rounded-2xl shadow-strong border border-neutral-200 dark:border-neutral-700 py-1 z-[9999]"
         role="menu"
         aria-orientation="vertical"
         aria-labelledby="language-menu">
        
        <a href="{{ route('locale.change', 'it') }}" 
           class="block px-4 py-2 text-sm text-neutral-700 dark:text-neutral-300 hover:bg-neutral-100 dark:hover:bg-neutral-700 hover:text-neutral-900 dark:hover:text-neutral-100 transition-colors duration-200 {{ app()->getLocale() === 'it' ? 'bg-primary-50 dark:bg-primary-900/30 text-primary-700 dark:text-primary-300' : '' }}"
           role="menuitem">
            <div class="flex items-center">
                <span class="mr-3 text-lg">🇮🇹</span>
                {{ __('Italiano') }}
                @if(app()->getLocale() === 'it')
                    <svg class="w-4 h-4 ml-auto text-primary-600 dark:text-primary-400" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                    </svg>
                @endif
            </div>
        </a>
        
        <a href="{{ route('locale.change', 'en') }}" 
           class="block px-4 py-2 text-sm text-neutral-700 dark:text-neutral-300 hover:bg-neutral-100 dark:hover:bg-neutral-700 hover:text-neutral-900 dark:hover:text-neutral-100 transition-colors duration-200 {{ app()->getLocale() === 'en' ? 'bg-primary-50 dark:bg-primary-900/30 text-primary-700 dark:text-primary-300' : '' }}"
           role="menuitem">
            <div class="flex items-center">
                <span class="mr-3 text-lg">🇬🇧</span>
                {{ __('Inglese') }}
                @if(app()->getLocale() === 'en')
                    <svg class="w-4 h-4 ml-auto text-primary-600 dark:text-primary-400" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                    </svg>
                @endif
            </div>
        </a>
        
        <a href="{{ route('locale.change', 'fr') }}" 
           class="block px-4 py-2 text-sm text-neutral-700 dark:text-neutral-300 hover:bg-neutral-100 dark:hover:bg-neutral-700 hover:text-neutral-900 dark:hover:text-neutral-100 transition-colors duration-200 {{ app()->getLocale() === 'fr' ? 'bg-primary-50 dark:bg-primary-900/30 text-primary-700 dark:text-primary-300' : '' }}"
           role="menuitem">
            <div class="flex items-center">
                <span class="mr-3 text-lg">🇫🇷</span>
                {{ __('Francese') }}
                @if(app()->getLocale() === 'fr')
                    <svg class="w-4 h-4 ml-auto text-primary-600 dark:text-primary-400" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                    </svg>
                @endif
            </div>
        </a>
        
        <a href="{{ route('locale.change', 'de') }}" 
           class="block px-4 py-2 text-sm text-neutral-700 dark:text-neutral-300 hover:bg-neutral-100 dark:hover:bg-neutral-700 hover:text-neutral-900 dark:hover:text-neutral-100 transition-colors duration-200 {{ app()->getLocale() === 'de' ? 'bg-primary-50 dark:bg-primary-900/30 text-primary-700 dark:text-primary-300' : '' }}"
           role="menuitem">
            <div class="flex items-center">
                <span class="mr-3 text-lg">🇩🇪</span>
                {{ __('Tedesco') }}
                @if(app()->getLocale() === 'de')
                    <svg class="w-4 h-4 ml-auto text-primary-600 dark:text-primary-400" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                    </svg>
                @endif
            </div>
        </a>
    </div>
</div> 