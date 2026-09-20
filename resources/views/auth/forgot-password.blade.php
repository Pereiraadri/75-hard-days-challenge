<x-guest-layout>
    <div class="auth-wrap">
        <h1 class="auth-title gradient-text">75 Hard</h1>
        <p class="auth-subtitle">{{ __('Reset your password') }}</p>

        <x-auth-session-status :status="session('status')" class="mb-4"/>

        <div class="auth-card">
            <p class="auth-intro">
                {{ __('Forgot your password? Tell us your email address and we will send you a reset link.') }}
            </p>

            <form method="POST" action="{{ route('password.email') }}">
                @csrf

                <div class="form-field">
                    <x-input-label for="email" :value="__('Email')"/>
                    <x-text-input id="email" name="email" type="email" :value="old('email')" required autofocus autocomplete="username"/>
                    <x-input-error :messages="$errors->get('email')"/>
                </div>

                <x-primary-button>{{ __('Send the reset link') }}</x-primary-button>
            </form>

            <a href="{{ route('login') }}" class="text-link">{{ __('Back to sign in') }}</a>
        </div>
    </div>
</x-guest-layout>
