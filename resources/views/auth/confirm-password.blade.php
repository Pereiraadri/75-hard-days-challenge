<x-guest-layout>
    <div class="auth-wrap">
        <h1 class="auth-title gradient-text">75 Hard</h1>
        <p class="auth-subtitle">{{ __('Confirm your password') }}</p>

        <div class="auth-card">
            <p class="auth-intro">
                {{ __('This is a secure area of the application. Please confirm your password before continuing.') }}
            </p>

            <form method="POST" action="{{ route('password.confirm') }}">
                @csrf

                <div class="form-field">
                    <x-input-label for="password" :value="__('Password')"/>
                    <x-text-input id="password" name="password" type="password" required autocomplete="current-password"/>
                    <x-input-error :messages="$errors->get('password')"/>
                </div>

                <x-primary-button>{{ __('Confirm') }}</x-primary-button>
            </form>
        </div>
    </div>
</x-guest-layout>
