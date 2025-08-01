<x-main-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('dashboard.welcome') }} {{ __('friends_of_cats') }}!
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-8 text-gray-900 dark:text-gray-100">
                    <div class="text-center mb-8">
                        <div class="flex justify-center mb-4">
                            <x-cat-logo class="w-16 h-16 text-orange-500">
                                <span class="text-2xl font-bold text-gray-900 dark:text-white">
                                    {{ __('friends_of_cats') }}
                                </span>
                            </x-cat-logo>
                        </div>
                        <h3 class="text-2xl font-bold text-gray-900 dark:text-gray-100 mb-2">
                            {{ __('dashboard.role_selection') }}
                        </h3>
                        <p class="text-gray-600 dark:text-gray-400">
                            {{ __('dashboard.role_selection_subtitle') }}
                        </p>
                    </div>

                    <form method="POST" action="{{ route('role.store') }}" class="space-y-6">
                        @csrf
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                            {{-- Associazione --}}
                            <label class="relative cursor-pointer">
                                <input type="radio" name="role" value="associazione" class="sr-only peer" required>
                                <div class="border-2 border-gray-200 dark:border-gray-700 rounded-lg p-6 hover:border-orange-500 dark:hover:border-orange-500 transition-all duration-200 peer-checked:border-orange-500 dark:peer-checked:border-orange-500 peer-checked:bg-orange-50 dark:peer-checked:bg-orange-900/10">
                                    <div class="flex items-center mb-4">
                                        <div class="w-12 h-12 bg-orange-100 dark:bg-orange-900/20 rounded-lg flex items-center justify-center mr-5">
                                            <svg class="w-6 h-6 text-orange-600 dark:text-orange-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                                            </svg>
                                        </div>
                                        <div>
                                            <h4 class="text-lg font-semibold text-gray-900 dark:text-gray-100">{{ __('dashboard.associazione') }}</h4>
                                            <p class="text-sm text-gray-600 dark:text-gray-400">{{ __('dashboard.associazione_desc') }}</p>
                                        </div>
                                    </div>
                                    <p class="text-sm text-gray-600 dark:text-gray-400">
                                        {{ __('dashboard.associazione_activities') }}
                                    </p>
                                    <div class="mt-4 flex items-center justify-end opacity-0 peer-checked:opacity-100 transition-opacity duration-200">
                                        <svg class="w-5 h-5 text-orange-500" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                        </svg>
                                    </div>
                                </div>
                            </label>

                            {{-- Volontario --}}
                            <label class="relative cursor-pointer">
                                <input type="radio" name="role" value="volontario" class="sr-only peer" required>
                                <div class="border-2 border-gray-200 dark:border-gray-700 rounded-lg p-6 hover:border-orange-500 dark:hover:border-orange-500 transition-all duration-200 peer-checked:border-orange-500 dark:peer-checked:border-orange-500 peer-checked:bg-orange-50 dark:peer-checked:bg-orange-900/10">
                                    <div class="flex items-center mb-4">
                                        <div class="w-12 h-12 bg-orange-100 dark:bg-orange-900/20 rounded-lg flex items-center justify-center mr-5">
                                            <svg class="w-6 h-6 text-orange-600 dark:text-orange-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                            </svg>
                                        </div>
                                        <div>
                                            <h4 class="text-lg font-semibold text-gray-900 dark:text-gray-100">{{ __('dashboard.volontario') }}</h4>
                                            <p class="text-sm text-gray-600 dark:text-gray-400">{{ __('dashboard.volontario_desc') }}</p>
                                        </div>
                                    </div>
                                    <p class="text-sm text-gray-600 dark:text-gray-400">
                                        {{ __('dashboard.volontario_activities') }}
                                    </p>
                                    <div class="mt-4 flex items-center justify-end opacity-0 peer-checked:opacity-100 transition-opacity duration-200">
                                        <svg class="w-5 h-5 text-orange-500" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                        </svg>
                                    </div>
                                </div>
                            </label>

                            {{-- Proprietario --}}
                            <label class="relative cursor-pointer">
                                <input type="radio" name="role" value="proprietario" class="sr-only peer" required>
                                <div class="border-2 border-gray-200 dark:border-gray-700 rounded-lg p-6 hover:border-orange-500 dark:hover:border-orange-500 transition-all duration-200 peer-checked:border-orange-500 dark:peer-checked:border-orange-500 peer-checked:bg-orange-50 dark:peer-checked:bg-orange-900/10">
                                    <div class="flex items-center mb-4">
                                        <div class="w-12 h-12 bg-orange-100 dark:bg-orange-900/20 rounded-lg flex items-center justify-center mr-5">
                                            <svg class="w-6 h-6 text-orange-600 dark:text-orange-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                                            </svg>
                                        </div>
                                        <div>
                                            <h4 class="text-lg font-semibold text-gray-900 dark:text-gray-100">{{ __('dashboard.proprietario') }}</h4>
                                            <p class="text-sm text-gray-600 dark:text-gray-400">{{ __('dashboard.proprietario_desc') }}</p>
                                        </div>
                                    </div>
                                    <p class="text-sm text-gray-600 dark:text-gray-400">
                                        {{ __('dashboard.proprietario_activities') }}
                                    </p>
                                    <div class="mt-4 flex items-center justify-end opacity-0 peer-checked:opacity-100 transition-opacity duration-200">
                                        <svg class="w-5 h-5 text-orange-500" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                        </svg>
                                    </div>
                                </div>
                            </label>

                            {{-- Veterinario --}}
                            <label class="relative cursor-pointer">
                                <input type="radio" name="role" value="veterinario" class="sr-only peer" required>
                                <div class="border-2 border-gray-200 dark:border-gray-700 rounded-lg p-6 hover:border-orange-500 dark:hover:border-orange-500 transition-all duration-200 peer-checked:border-orange-500 dark:peer-checked:border-orange-500 peer-checked:bg-orange-50 dark:peer-checked:bg-orange-900/10">
                                    <div class="flex items-center mb-4">
                                        <div class="w-12 h-12 bg-orange-100 dark:bg-orange-900/20 rounded-lg flex items-center justify-center mr-5">
                                            <svg class="w-6 h-6 text-orange-600 dark:text-orange-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                            </svg>
                                        </div>
                                        <div>
                                            <h4 class="text-lg font-semibold text-gray-900 dark:text-gray-100">{{ __('dashboard.veterinario') }}</h4>
                                            <p class="text-sm text-gray-600 dark:text-gray-400">{{ __('dashboard.veterinario_desc') }}</p>
                                        </div>
                                    </div>
                                    <p class="text-sm text-gray-600 dark:text-gray-400">
                                        {{ __('dashboard.veterinario_activities') }}
                                    </p>
                                    <div class="mt-4 flex items-center justify-end opacity-0 peer-checked:opacity-100 transition-opacity duration-200">
                                        <svg class="w-5 h-5 text-orange-500" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                        </svg>
                                    </div>
                                </div>
                            </label>

                            {{-- Toelettatore --}}
                            <label class="relative cursor-pointer">
                                <input type="radio" name="role" value="toelettatore" class="sr-only peer" required>
                                <div class="border-2 border-gray-200 dark:border-gray-700 rounded-lg p-6 hover:border-orange-500 dark:hover:border-orange-500 transition-all duration-200 peer-checked:border-orange-500 dark:peer-checked:border-orange-500 peer-checked:bg-orange-50 dark:peer-checked:bg-orange-900/10">
                                    <div class="flex items-center mb-4">
                                        <div class="w-12 h-12 bg-orange-100 dark:bg-orange-900/20 rounded-lg flex items-center justify-center mr-5">
                                            <svg class="w-6 h-6 text-orange-600 dark:text-orange-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zM7 3h10M7 3v18h10V3M7 3a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V5a2 2 0 00-2-2"></path>
                                            </svg>
                                        </div>
                                        <div>
                                            <h4 class="text-lg font-semibold text-gray-900 dark:text-gray-100">{{ __('dashboard.toelettatore') }}</h4>
                                            <p class="text-sm text-gray-600 dark:text-gray-400">{{ __('dashboard.toelettatore_desc') }}</p>
                                        </div>
                                    </div>
                                    <p class="text-sm text-gray-600 dark:text-gray-400">
                                        {{ __('dashboard.toelettatore_activities') }}
                                    </p>
                                    <div class="mt-4 flex items-center justify-end opacity-0 peer-checked:opacity-100 transition-opacity duration-200">
                                        <svg class="w-5 h-5 text-orange-500" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                        </svg>
                                    </div>
                                </div>
                            </label>
                        </div>

                        @error('role')
                            <div class="mt-4 p-4 bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 rounded-md">
                                <p class="text-sm text-red-800 dark:text-red-200">
                                    {{ $message }}
                                </p>
                            </div>
                        @enderror

                        <div class="flex justify-center mt-8">
                            <button type="submit" 
                                    class="inline-flex items-center px-6 py-3 bg-orange-500 hover:bg-orange-600 text-white font-semibold rounded-lg transition-colors duration-200">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                                </svg>
                                {{ __('dashboard.continue') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-main-layout> 