{{-- Public Language Selector (ARIA Menu Button pattern) --}}
<div x-data="{ open: false }" x-id="['lang-btn','lang-menu']" class="relative">
    <button type="button"
            :id="$id('lang-btn')"
            :aria-controls="$id('lang-menu')"
            :aria-expanded="open.toString()"
            aria-haspopup="true"
            aria-label="{{ __('Language') }}"
            @click="open = !open; if(open) $nextTick(() => $refs.firstItem?.focus())"
            @keydown.arrow-down.prevent="open = true; $nextTick(() => $refs.firstItem?.focus())"
            @keydown.arrow-up.prevent="open = true; $nextTick(() => $refs.lastItem?.focus())"
            @keydown.escape.prevent.stop="open = false; $nextTick(() => $el.focus())"
            class="inline-flex items-center px-3 py-2 text-sm font-medium text-gray-700 dark:text-gray-300 hover:text-gray-900 dark:hover:text-gray-100 a11y-focus transition-colors duration-200">
        
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
          :id="$id('lang-menu')"
          role="menu"
          aria-orientation="vertical"
          :aria-labelledby="$id('lang-btn')"
          @keydown.arrow-down.prevent="const next = document.activeElement?.nextElementSibling; if(next) next.focus()"
          @keydown.arrow-up.prevent="const prev = document.activeElement?.previousElementSibling; if(prev) prev.focus()"
          @keydown.home.prevent.stop="$refs.firstItem?.focus()"
          @keydown.end.prevent.stop="$refs.lastItem?.focus()"
          @keydown.escape.prevent.stop="open = false; $nextTick(() => $root.querySelector('[id=\'' + $id('lang-btn') + '\']')?.focus())"
          class="absolute right-0 mt-2 w-56 bg-white dark:bg-gray-800 rounded-lg shadow-lg border border-gray-200 dark:border-gray-700 py-1 z-50">
        
        {{-- Italian --}}
        <a href="{{ route('locale.change', 'it') }}" 
           role="menuitem"
           x-ref="firstItem"
           class="flex items-center px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 hover:text-gray-900 dark:hover:text-gray-100 transition-colors duration-200 a11y-focus {{ app()->getLocale() === 'it' ? 'bg-orange-50 dark:bg-orange-900/30 text-orange-700 dark:text-orange-300' : '' }}">
            <span class="mr-3 text-lg">🇮🇹</span>
            <span class="font-medium">{{ __('messages.italiano') }}</span>
            @if(app()->getLocale() === 'it')
                <svg class="w-4 h-4 ml-auto text-orange-600 dark:text-orange-400" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                </svg>
            @endif
        </a>
        
        {{-- English --}}
        <a href="{{ route('locale.change', 'en') }}" 
           role="menuitem"
           class="flex items-center px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 hover:text-gray-900 dark:hover:text-gray-100 transition-colors duration-200 a11y-focus {{ app()->getLocale() === 'en' ? 'bg-orange-50 dark:bg-orange-900/30 text-orange-700 dark:text-orange-300' : '' }}">
            <span class="mr-3 text-lg">🇬🇧</span>
            <span class="font-medium">{{ __('messages.inglese') }}</span>
            @if(app()->getLocale() === 'en')
                <svg class="w-4 h-4 ml-auto text-orange-600 dark:text-orange-400" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                </svg>
            @endif
        </a>
        
        {{-- French --}}
        <a href="{{ route('locale.change', 'fr') }}" 
           role="menuitem"
           class="flex items-center px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 hover:text-gray-900 dark:hover:text-gray-100 transition-colors duration-200 a11y-focus {{ app()->getLocale() === 'fr' ? 'bg-orange-50 dark:bg-orange-900/30 text-orange-700 dark:text-orange-300' : '' }}">
            <span class="mr-3 text-lg">🇫🇷</span>
            <span class="font-medium">{{ __('messages.francese') }}</span>
            @if(app()->getLocale() === 'fr')
                <svg class="w-4 h-4 ml-auto text-orange-600 dark:text-orange-400" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                </svg>
            @endif
        </a>
        
        {{-- German --}}
        <a href="{{ route('locale.change', 'de') }}" 
           role="menuitem"
           class="flex items-center px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 hover:text-gray-900 dark:hover:text-gray-100 transition-colors duration-200 a11y-focus {{ app()->getLocale() === 'de' ? 'bg-orange-50 dark:bg-orange-900/30 text-orange-700 dark:text-orange-300' : '' }}">
            <span class="mr-3 text-lg">🇩🇪</span>
            <span class="font-medium">{{ __('messages.tedesco') }}</span>
            @if(app()->getLocale() === 'de')
                <svg class="w-4 h-4 ml-auto text-orange-600 dark:text-orange-400" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                </svg>
            @endif
        </a>
        
        {{-- Spanish --}}
        <a href="{{ route('locale.change', 'es') }}" 
           role="menuitem"
           class="flex items-center px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 hover:text-gray-900 dark:hover:text-gray-100 transition-colors duration-200 a11y-focus {{ app()->getLocale() === 'es' ? 'bg-orange-50 dark:bg-orange-900/30 text-orange-700 dark:text-orange-300' : '' }}">
            <span class="mr-3 text-lg">🇪🇸</span>
            <span class="font-medium">{{ __('messages.spagnolo') }}</span>
            @if(app()->getLocale() === 'es')
                <svg class="w-4 h-4 ml-auto text-orange-600 dark:text-orange-400" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                </svg>
            @endif
        </a>
        
        {{-- Slovenian --}}
        <a href="{{ route('locale.change', 'sl') }}" 
           role="menuitem"
           x-ref="lastItem"
           class="flex items-center px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 hover:text-gray-900 dark:hover:text-gray-100 transition-colors duration-200 a11y-focus {{ app()->getLocale() === 'sl' ? 'bg-orange-50 dark:bg-orange-900/30 text-orange-700 dark:text-orange-300' : '' }}">
            <span class="mr-3 text-lg">🇸🇮</span>
            <span class="font-medium">{{ __('messages.sloveno') }}</span>
            @if(app()->getLocale() === 'sl')
                <svg class="w-4 h-4 ml-auto text-orange-600 dark:text-orange-400" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                </svg>
            @endif
        </a>
    </div>
</div>