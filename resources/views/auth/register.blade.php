<x-auth-layout title="{{ __('register') }}">
    <form method="POST" action="{{ route('register') }}" class="space-y-6">
        @csrf

        <!-- Name -->
        <div>
            <x-input-label for="name" :value="__('name')" class="text-gray-700 dark:text-gray-300" />
            <x-text-input id="name" 
                          class="block mt-1 w-full border-gray-300 dark:border-gray-600 focus:border-orange-500 dark:focus:border-orange-400 focus:ring-orange-500 dark:focus:ring-orange-400" 
                          type="text" 
                          name="name" 
                          :value="old('name')" 
                          required 
                          autofocus 
                          autocomplete="name" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('email')" class="text-gray-700 dark:text-gray-300" />
            <x-text-input id="email" 
                          class="block mt-1 w-full border-gray-300 dark:border-gray-600 focus:border-orange-500 dark:focus:border-orange-400 focus:ring-orange-500 dark:focus:ring-orange-400" 
                          type="email" 
                          name="email" 
                          :value="old('email')" 
                          required 
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
                          autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div>
            <x-input-label for="password_confirmation" :value="__('confirm_password')" class="text-gray-700 dark:text-gray-300" />
            <x-text-input id="password_confirmation" 
                          class="block mt-1 w-full border-gray-300 dark:border-gray-600 focus:border-orange-500 dark:focus:border-orange-400 focus:ring-orange-500 dark:focus:ring-orange-400"
                          type="password"
                          name="password_confirmation" 
                          required 
                          autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="flex flex-col space-y-4">
            <x-primary-button class="w-full justify-center bg-orange-500 hover:bg-orange-600 focus:ring-orange-500">
                {{ __('register') }}
            </x-primary-button>

            <div class="text-center">
                <span class="text-sm text-gray-600 dark:text-gray-400">
                    {{ __('already_registered') }}
                </span>
                <a href="{{ route('login') }}" 
                   class="text-sm font-medium text-orange-600 dark:text-orange-400 hover:text-orange-500 dark:hover:text-orange-300 transition-colors duration-200">
                    {{ __('login') }}
                </a>
            </div>
        </div>
    </form>
</x-auth-layout>
