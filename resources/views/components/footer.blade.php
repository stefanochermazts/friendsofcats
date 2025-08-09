<footer class="border-t border-gray-100 dark:border-gray-800 bg-white dark:bg-gray-950" role="contentinfo">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-6">
            <a href="{{ route('welcome') }}" class="flex items-center space-x-3">
                <x-cat-logo class="w-9 h-9">
                    <span class="text-lg font-bold text-gray-900 dark:text-white">{{ __('friends_of_cats') }}</span>
                </x-cat-logo>
            </a>

            <nav aria-label="Footer">
                <ul class="flex flex-wrap gap-x-6 gap-y-3 text-sm text-gray-600 dark:text-gray-300">
                    <li><a class="hover:text-orange-600 dark:hover:text-orange-400" href="{{ route('public.adoptions.index') }}">Adozioni</a></li>
                    <li><a class="hover:text-orange-600 dark:hover:text-orange-400" href="{{ route('professionals.index') }}">Professionisti</a></li>
                    <li><a class="hover:text-orange-600 dark:hover:text-orange-400" href="{{ url('/guide') }}">Guide</a></li>
                    <li><a class="hover:text-orange-600 dark:hover:text-orange-400" href="{{ url('/salute') }}">Salute</a></li>
                    <li><a class="hover:text-orange-600 dark:hover:text-orange-400" href="{{ url('/alimentazione') }}">Alimentazione</a></li>
                    <li><a class="hover:text-orange-600 dark:hover:text-orange-400" href="{{ url('/comportamento') }}">Comportamento</a></li>
                    <li><a class="hover:text-orange-600 dark:hover:text-orange-400" href="{{ url('/cura') }}">Cura</a></li>
                    <li><a class="hover:text-orange-600 dark:hover:text-orange-400" href="{{ url('/razze') }}">Razze</a></li>
                    <li><a class="hover:text-orange-600 dark:hover:text-orange-400" href="{{ url('/curiosita') }}">Curiosità</a></li>
                    <li><a class="hover:text-orange-600 dark:hover:text-orange-400" href="{{ route('news.index') }}">News</a></li>
                    <li><a class="hover:text-orange-600 dark:hover:text-orange-400" href="{{ route('contact') }}">Contatti</a></li>
                </ul>
            </nav>
        </div>

        <div class="mt-6 text-xs text-gray-500 dark:text-gray-400">
            © {{ date('Y') }} catfriends.club — Tutti i diritti riservati
        </div>
    </div>
</footer>


