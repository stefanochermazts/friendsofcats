@props(['id' => 'password'])

<div x-data="passwordValidator()" class="space-y-4">

    <!-- Password Strength Indicator -->
    <div class="space-y-2">
        <div class="flex items-center justify-between">
            <span class="text-sm font-medium text-gray-700 dark:text-gray-300">{{ __('password_strength') }}</span>
            <span class="text-sm font-semibold" :class="strengthColor" x-text="strengthText"></span>
        </div>
        <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-2">
            <div class="h-2 rounded-full transition-all duration-300" :class="strengthColor" :style="`width: ${strengthPercentage}%`"></div>
        </div>
    </div>

    <!-- Password Requirements -->
    <div class="space-y-2">
        <h4 class="text-sm font-medium text-gray-700 dark:text-gray-300">{{ __('password_requirements') }}</h4>
        <div class="space-y-1">
            <div class="flex items-center space-x-2">
                <svg class="w-4 h-4" :class="requirements.minLength ? 'text-green-500' : 'text-red-500'" fill="currentColor" viewBox="0 0 20 20">
                    <path x-show="requirements.minLength" fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                    <path x-show="!requirements.minLength" fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"/>
                </svg>
                <span class="text-sm" :class="requirements.minLength ? 'text-green-600 dark:text-green-400' : 'text-red-600 dark:text-red-400'">
                    {{ __('password_min_length') }}
                </span>
            </div>
            <div class="flex items-center space-x-2">
                <svg class="w-4 h-4" :class="requirements.uppercase ? 'text-green-500' : 'text-red-500'" fill="currentColor" viewBox="0 0 20 20">
                    <path x-show="requirements.uppercase" fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                    <path x-show="!requirements.uppercase" fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"/>
                </svg>
                <span class="text-sm" :class="requirements.uppercase ? 'text-green-600 dark:text-green-400' : 'text-red-600 dark:text-red-400'">
                    {{ __('password_uppercase') }}
                </span>
            </div>
            <div class="flex items-center space-x-2">
                <svg class="w-4 h-4" :class="requirements.lowercase ? 'text-green-500' : 'text-red-500'" fill="currentColor" viewBox="0 0 20 20">
                    <path x-show="requirements.lowercase" fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                    <path x-show="!requirements.lowercase" fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"/>
                </svg>
                <span class="text-sm" :class="requirements.lowercase ? 'text-green-600 dark:text-green-400' : 'text-red-600 dark:text-red-400'">
                    {{ __('password_lowercase') }}
                </span>
            </div>
            <div class="flex items-center space-x-2">
                <svg class="w-4 h-4" :class="requirements.number ? 'text-green-500' : 'text-red-500'" fill="currentColor" viewBox="0 0 20 20">
                    <path x-show="requirements.number" fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                    <path x-show="!requirements.number" fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"/>
                </svg>
                <span class="text-sm" :class="requirements.number ? 'text-green-600 dark:text-green-400' : 'text-red-600 dark:text-red-400'">
                    {{ __('password_number') }}
                </span>
            </div>
            <div class="flex items-center space-x-2">
                <svg class="w-4 h-4" :class="requirements.special ? 'text-green-500' : 'text-red-500'" fill="currentColor" viewBox="0 0 20 20">
                    <path x-show="requirements.special" fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                    <path x-show="!requirements.special" fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"/>
                </svg>
                <span class="text-sm" :class="requirements.special ? 'text-green-600 dark:text-green-400' : 'text-red-600 dark:text-red-400'">
                    {{ __('password_special') }}
                </span>
            </div>
        </div>
    </div>
</div>

<script>
function passwordValidator() {
    return {
        password: '',
        requirements: {
            minLength: false,
            uppercase: false,
            lowercase: false,
            number: false,
            special: false
        },
        strength: 0,
        strengthText: '',
        strengthColor: 'text-gray-500',
        strengthPercentage: 0,

        validatePassword(password = null) {
            const pwd = password || this.password;
            
            // Check requirements
            this.requirements.minLength = pwd.length >= 10;
            this.requirements.uppercase = /[A-Z]/.test(pwd);
            this.requirements.lowercase = /[a-z]/.test(pwd);
            this.requirements.number = /[0-9]/.test(pwd);
            this.requirements.special = /[!@#$%^&*()_+\-=\[\]{};':"\\|,.<>\/?]/.test(pwd);
            
            // Calculate strength
            let score = 0;
            if (this.requirements.minLength) score += 20;
            if (this.requirements.uppercase) score += 20;
            if (this.requirements.lowercase) score += 20;
            if (this.requirements.number) score += 20;
            if (this.requirements.special) score += 20;
            
            this.strength = score;
            this.strengthPercentage = score;
            
            // Set strength text and color
            if (score === 0) {
                this.strengthText = '';
                this.strengthColor = 'text-gray-500';
            } else if (score <= 40) {
                this.strengthText = '{{ __("password_weak") }}';
                this.strengthColor = 'text-red-500';
            } else if (score <= 60) {
                this.strengthText = '{{ __("password_medium") }}';
                this.strengthColor = 'text-yellow-500';
            } else if (score <= 80) {
                this.strengthText = '{{ __("password_strong") }}';
                this.strengthColor = 'text-blue-500';
            } else {
                this.strengthText = '{{ __("password_very_strong") }}';
                this.strengthColor = 'text-green-500';
            }
        }
    }
}
</script> 