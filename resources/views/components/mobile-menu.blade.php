{{-- Mobile Menu Component --}}
<div x-data="{ open: false }" x-id="['mobile-menu']" class="md:hidden">
    {{-- Hamburger Button --}}
    <button @click="open = !open"
            :aria-expanded="open.toString()"
            :aria-controls="$id('mobile-menu')"
            aria-label="{{ __('Open main menu') }}"
            x-ref="menuButton"
            class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 dark:text-gray-500 hover:text-gray-500 dark:hover:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-800 focus:outline-none focus-visible:ring-2 focus-visible:ring-orange-500 focus-visible:ring-offset-2 focus-visible:ring-offset-white dark:focus-visible:ring-offset-gray-900 transition duration-150 ease-in-out">
        <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
            <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
            <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
        </svg>
    </button>

    {{-- Mobile Menu Panel --}}
    <div x-show="open" 
         @keydown.escape.prevent.stop="open = false; $nextTick(() => $refs.menuButton && $refs.menuButton.focus())"
         @click.away="open = false"
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="transform opacity-0 scale-95"
         x-transition:enter-end="transform opacity-100 scale-100"
         x-transition:leave="transition ease-in duration-75"
         x-transition:leave-start="transform opacity-100 scale-100"
         x-transition:leave-end="transform opacity-0 scale-95"
         :id="$id('mobile-menu')"
         role="dialog"
         aria-modal="true"
         aria-label="{{ __('Main menu') }}"
         class="absolute top-16 inset-x-0 z-50 bg-white dark:bg-gray-800 shadow-lg border-t border-gray-200 dark:border-gray-700">
        
        <div class="px-4 py-6 space-y-4">
            {{-- Navigation Links --}}
            <div class="space-y-2" role="menu" aria-label="{{ __('Primary') }}">
                <a href="{{ route('welcome') }}" 
                   @click="open = false"
                   role="menuitem"
                   class="block px-3 py-2 text-base font-medium text-gray-700 dark:text-gray-300 hover:text-orange-500 dark:hover:text-orange-400 hover:bg-gray-50 dark:hover:bg-gray-700 rounded-md transition-colors duration-200 focus:outline-none focus-visible:ring-2 focus-visible:ring-orange-500 focus-visible:ring-offset-2 focus-visible:ring-offset-white dark:focus-visible:ring-offset-gray-900">
                    {{ __('home') }}
                </a>
                
                <a href="{{ route('public.adoptions.index') }}" 
                   @click="open = false"
                   role="menuitem"
                   class="block px-3 py-2 text-base font-medium text-gray-700 dark:text-gray-300 hover:text-orange-500 dark:hover:text-orange-400 hover:bg-gray-50 dark:hover:bg-gray-700 rounded-md transition-colors duration-200 focus:outline-none focus-visible:ring-2 focus-visible:ring-orange-500 focus-visible:ring-offset-2 focus-visible:ring-offset-white dark:focus-visible:ring-offset-gray-900">
                    {{ __('adoptions.title') }}
                </a>
                
                <a href="{{ route('professionals.index') }}" 
                   @click="open = false"
                   role="menuitem"
                   class="block px-3 py-2 text-base font-medium text-gray-700 dark:text-gray-300 hover:text-orange-500 dark:hover:text-orange-400 hover:bg-gray-50 dark:hover:bg-gray-700 rounded-md transition-colors duration-200 focus:outline-none focus-visible:ring-2 focus-visible:ring-orange-500 focus-visible:ring-offset-2 focus-visible:ring-offset-white dark:focus-visible:ring-offset-gray-900">
                    {{ __('professionals.directory_title') }}
                </a>
                
                {{-- CatBook (only for authenticated users) --}}
                @auth
                    <a href="{{ route('catbook.index') }}" 
                       @click="open = false"
                       role="menuitem"
                       class="block px-3 py-2 text-base font-medium text-gray-700 dark:text-gray-300 hover:text-orange-500 dark:hover:text-orange-400 hover:bg-gray-50 dark:hover:bg-gray-700 rounded-md transition-colors duration-200 focus:outline-none focus-visible:ring-2 focus-visible:ring-orange-500 focus-visible:ring-offset-2 focus-visible:ring-offset-white dark:focus-visible:ring-offset-gray-900">
                        🐾 CatBook
                    </a>
                @endauth
                
                <a href="{{ route('contact') }}" 
                   @click="open = false"
                   role="menuitem"
                   class="block px-3 py-2 text-base font-medium text-gray-700 dark:text-gray-300 hover:text-orange-500 dark:hover:text-orange-400 hover:bg-gray-50 dark:hover:bg-gray-700 rounded-md transition-colors duration-200 focus:outline-none focus-visible:ring-2 focus-visible:ring-orange-500 focus-visible:ring-offset-2 focus-visible:ring-offset-white dark:focus-visible:ring-offset-gray-900">
                    {{ __('contact.title') }}
                </a>
            </div>

            {{-- Authenticated User Section --}}
            @auth
                <div class="border-t border-gray-200 dark:border-gray-600 pt-4 mt-4">
                    <div class="flex items-center px-3 py-2 mb-3">
                        <div class="flex-shrink-0">
                            <div class="w-8 h-8 bg-orange-500 rounded-full flex items-center justify-center">
                                <span class="text-white font-semibold text-sm">
                                    {{ substr(Auth::user()->name, 0, 1) }}
                                </span>
                            </div>
                        </div>
                        <div class="ml-3">
                            <div class="text-base font-medium text-gray-800 dark:text-gray-200">
                                {{ Auth::user()->name }}
                            </div>
                            <div class="text-sm text-gray-500 dark:text-gray-400">
                                {{ Auth::user()->email }}
                            </div>
                        </div>
                    </div>

                    <div class="space-y-2">
                        @if(auth()->user()->role === 'admin')
                            <a href="{{ url('/admin') }}" 
                               @click="open = false"
                               role="menuitem"
                               class="block px-3 py-2 text-base font-medium text-gray-700 dark:text-gray-300 hover:text-orange-500 dark:hover:text-orange-400 hover:bg-gray-50 dark:hover:bg-gray-700 rounded-md transition-colors duration-200 focus:outline-none focus-visible:ring-2 focus-visible:ring-orange-500 focus-visible:ring-offset-2 focus-visible:ring-offset-white dark:focus-visible:ring-offset-gray-900">
                                🔧 Admin Panel
                            </a>
                        @endif
                        
                        <a href="{{ route('dashboard') }}" 
                           @click="open = false"
                           role="menuitem"
                           class="block px-3 py-2 text-base font-medium text-gray-700 dark:text-gray-300 hover:text-orange-500 dark:hover:text-orange-400 hover:bg-gray-50 dark:hover:bg-gray-700 rounded-md transition-colors duration-200 focus:outline-none focus-visible:ring-2 focus-visible:ring-orange-500 focus-visible:ring-offset-2 focus-visible:ring-offset-white dark:focus-visible:ring-offset-gray-900">
                            📊 Dashboard
                        </a>
                        
                        <a href="{{ route('user.cats') }}" 
                           @click="open = false"
                           role="menuitem"
                           class="block px-3 py-2 text-base font-medium text-gray-700 dark:text-gray-300 hover:text-orange-500 dark:hover:text-orange-400 hover:bg-gray-50 dark:hover:bg-gray-700 rounded-md transition-colors durataction-200">
                            🐱 I miei gatti
                        </a>
                        
                        <a href="{{ route('profile.edit') }}" 
                           @click="open = false"
                           role="menuitem"
                           class="block px-3 py-2 text-base font-medium text-gray-700 dark:text-gray-300 hover:text-orange-500 dark:hover:text-orange-400 hover:bg-gray-50 dark:hover:bg-gray-700 rounded-md transition-colors duration-200">
                            👤 Profilo
                        </a>
                        
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" 
                                    @click="open = false"
                                    role="menuitem"
                                    class="block w-full text-left px-3 py-2 text-base font-medium text-red-600 dark:text-red-400 hover:text-red-700 dark:hover:text-red-300 hover:bg-red-50 dark:hover:bg-red-900/20 rounded-md transition-colors duration-200 focus:outline-none focus-visible:ring-2 focus-visible:ring-orange-500 focus-visible:ring-offset-2 focus-visible:ring-offset-white dark:focus-visible:ring-offset-gray-900">
                                🚪 Logout
                            </button>
                        </form>
                    </div>
                </div>
            @endauth

            {{-- Guest User Section --}}
            @guest
                <div class="border-t border-gray-200 dark:border-gray-600 pt-4 mt-4">
                    <div class="space-y-2">
                        <a href="{{ route('login') }}" 
                           @click="open = false"
                           role="menuitem"
                           class="block px-3 py-2 text-base font-medium text-orange-600 dark:text-orange-400 hover:text-orange-700 dark:hover:text-orange-300 hover:bg-orange-50 dark:hover:bg-orange-900/20 rounded-md transition-colors duration-200 focus:outline-none focus-visible:ring-2 focus-visible:ring-orange-500 focus-visible:ring-offset-2 focus-visible:ring-offset-white dark:focus-visible:ring-offset-gray-900">
                            🔑 Login
                        </a>
                        
                        <a href="{{ route('register') }}" 
                           @click="open = false"
                           role="menuitem"
                           class="block px-3 py-2 text-base font-medium bg-orange-500 text-white hover:bg-orange-600 rounded-md transition-colors duration-200 text-center focus:outline-none focus-visible:ring-2 focus-visible:ring-orange-500 focus-visible:ring-offset-2 focus-visible:ring-offset-white dark:focus-visible:ring-offset-gray-900">
                            ✨ Registrati
                        </a>
                    </div>
                </div>
            @endguest

            {{-- Settings Section --}}
            <div class="border-t border-gray-200 dark:border-gray-600 pt-4 mt-4">
                <div class="flex items-center justify-between px-3 py-2">
                    <span class="text-sm font-medium text-gray-700 dark:text-gray-300">Impostazioni</span>
                </div>
                
                <div class="flex items-center justify-between px-3 py-2">
                    <span class="text-sm text-gray-600 dark:text-gray-400">Tema</span>
                    <x-public-theme-toggle />
                </div>
                
                <div class="flex items-center justify-between px-3 py-2">
                    <span class="text-sm text-gray-600 dark:text-gray-400">Lingua</span>
                    <x-public-language-selector />
                </div>
            </div>
        </div>
    </div>
</div>
