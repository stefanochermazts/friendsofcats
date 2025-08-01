<x-auth-layout title="{{ __('login') }}">
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}" class="space-y-6">
        @csrf

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('email')" class="text-gray-700 dark:text-gray-300" />
            <x-text-input id="email" 
                          class="block mt-1 w-full border-gray-300 dark:border-gray-600 focus:border-orange-500 dark:focus:border-orange-400 focus:ring-orange-500 dark:focus:ring-orange-400" 
                          type="email" 
                          name="email" 
                          :value="old('email')" 
                          required 
                          autofocus 
                          autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div>
            <x-input-label for="password" :value="__('password')" class="text-gray-700 dark:text-gray-300" />
            <x-text-input id="password" 
                          class="block mt-1 w-full border-gray-300 dark:border-gray-600 focus:border-orange-500 dark:focus:border-orange-400 focus:ring-orange-500 dark:focus:ring-orange-400"
                          type="password"
                          name="password"
                          required 
                          autocomplete="current-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Remember Me -->
        <div class="flex items-center justify-between">
            <label for="remember_me" class="inline-flex items-center">
                <input id="remember_me" 
                       type="checkbox" 
                       class="rounded border-gray-300 dark:border-gray-600 text-orange-600 shadow-sm focus:ring-orange-500 dark:focus:ring-orange-400 dark:focus:ring-offset-gray-800" 
                       name="remember">
                <span class="ms-2 text-sm text-gray-600 dark:text-gray-400">{{ __('remember_me') }}</span>
            </label>

            @if (Route::has('password.request'))
                <a class="text-sm text-orange-600 dark:text-orange-400 hover:text-orange-500 dark:hover:text-orange-300 transition-colors duration-200" 
                   href="{{ route('password.request') }}">
                    {{ __('forgot_password') }}
                </a>
            @endif
        </div>

        <div class="flex flex-col space-y-4">
            <x-primary-button class="w-full justify-center bg-orange-500 hover:bg-orange-600 focus:ring-orange-500">
                {{ __('login') }}
            </x-primary-button>

            <div class="text-center">
                <span class="text-sm text-gray-600 dark:text-gray-400">
                    {{ __('dont_have_account') }}
                </span>
                <a href="{{ route('register') }}" 
                   class="text-sm font-medium text-orange-600 dark:text-orange-400 hover:text-orange-500 dark:hover:text-orange-300 transition-colors duration-200">
                    {{ __('register') }}
                </a>
            </div>
        </div>
    </form>
</x-auth-layout>
