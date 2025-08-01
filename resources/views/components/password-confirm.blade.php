@props(['id' => 'password_confirmation'])

<div x-data="passwordConfirm()" class="space-y-4">
    <!-- Confirm Password Input -->
    <div>
        <x-input-label for="{{ $id }}" :value="__('Confirm Password')" />
        <x-text-input 
            id="{{ $id }}" 
            class="block mt-1 w-full"
            type="password"
            name="password_confirmation"
            required 
            autocomplete="new-password"
            x-model="confirmPassword"
            @input="validateMatch()"
        />
        <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
    </div>

    <!-- Password Match Indicator -->
    <div class="space-y-2" x-show="confirmPassword.length > 0">
        <div class="flex items-center space-x-2">
            <svg class="w-4 h-4" :class="passwordsMatch ? 'text-green-500' : 'text-red-500'" fill="currentColor" viewBox="0 0 20 20">
                <path x-show="passwordsMatch" fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                <path x-show="!passwordsMatch" fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"/>
            </svg>
            <span class="text-sm" :class="passwordsMatch ? 'text-green-600 dark:text-green-400' : 'text-red-600 dark:text-red-400'">
                <span x-text="passwordsMatch ? '{{ __("password_match") }}' : '{{ __("password_not_match") }}'"></span>
            </span>
        </div>
    </div>
</div>

<script>
function passwordConfirm() {
    return {
        confirmPassword: '',
        passwordsMatch: false,

        validateMatch() {
            const password = document.getElementById('password')?.value || '';
            this.passwordsMatch = this.confirmPassword === password && this.confirmPassword.length > 0;
        }
    }
}
</script> 