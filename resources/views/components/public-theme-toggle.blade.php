{{-- Public Theme Toggle Component for Homepage Header --}}
<div x-data="themeToggle()" 
     x-init="init()" 
     class="theme-toggle-wrapper">
    
    <button @click="toggle()" 
            class="inline-flex items-center justify-center p-2 rounded-lg text-gray-400 dark:text-gray-500 hover:text-gray-500 dark:hover:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-800 focus:outline-none focus:ring-2 focus:ring-orange-500 focus:ring-offset-2 transition-all duration-200"
            :aria-label="theme === 'light' ? '{{ __('dark_mode') }}' : '{{ __('light_mode') }}'"
            :title="theme === 'light' ? '{{ __('dark_mode') }}' : '{{ __('light_mode') }}'">
        
        {{-- Sun icon for light mode --}}
        <svg x-show="theme === 'light'" 
             class="w-5 h-5" 
             fill="currentColor" 
             viewBox="0 0 24 24" 
             aria-hidden="true">
            <path d="M12 2.25a.75.75 0 01.75.75v2.25a.75.75 0 01-1.5 0V3a.75.75 0 01.75-.75zM7.5 12a4.5 4.5 0 119 0 4.5 4.5 0 01-9 0zM18.894 6.166a.75.75 0 00-1.06-1.06l-1.591 1.59a.75.75 0 101.06 1.061l1.591-1.59zM21.75 12a.75.75 0 01-.75.75h-2.25a.75.75 0 010-1.5H21a.75.75 0 01.75.75zM17.834 18.894a.75.75 0 001.06-1.06l-1.59-1.591a.75.75 0 10-1.061 1.06l1.59 1.591zM12 18a.75.75 0 01.75.75V21a.75.75 0 01-1.5 0v-2.25A.75.75 0 0112 18zM7.758 17.303a.75.75 0 00-1.061-1.06l-1.591 1.59a.75.75 0 001.06 1.061l1.591-1.59zM6 12a.75.75 0 01-.75.75H3a.75.75 0 010-1.5h2.25A.75.75 0 016 12zM6.697 7.757a.75.75 0 001.06-1.06l-1.59-1.591a.75.75 0 00-1.061 1.06l1.59 1.591z"/>
        </svg>
        
        {{-- Moon icon for dark mode --}}
        <svg x-show="theme === 'dark'" 
             class="w-5 h-5" 
             fill="currentColor" 
             viewBox="0 0 20 20" 
             aria-hidden="true">
            <path d="M17.293 13.293A8 8 0 016.707 2.707a8.001 8.001 0 1010.586 10.586z" />
        </svg>
    </button>
</div>

<script>
function themeToggle() {
    return {
        theme: 'light',
        
        init() {
            // Recupera il tema dal localStorage o usa il default del sistema
            this.theme = localStorage.getItem('theme') || this.getSystemTheme();
            this.applyTheme();
            
            // Ascolta i cambiamenti del sistema
            if (window.matchMedia) {
                window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', e => {
                    if (!localStorage.getItem('theme')) {
                        this.theme = e.matches ? 'dark' : 'light';
                        this.applyTheme();
                    }
                });
            }
        },
        
        getSystemTheme() {
            return window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light';
        },
        
        toggle() {
            this.theme = this.theme === 'light' ? 'dark' : 'light';
            this.applyTheme();
            localStorage.setItem('theme', this.theme);
        },
        
        applyTheme() {
            if (this.theme === 'dark') {
                document.documentElement.classList.add('dark');
                document.documentElement.style.colorScheme = 'dark';
            } else {
                document.documentElement.classList.remove('dark');
                document.documentElement.style.colorScheme = 'light';
            }
        }
    }
}
</script>