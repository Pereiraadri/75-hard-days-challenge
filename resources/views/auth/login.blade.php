<x-guest-layout>
    <div class="auth-wrap">
        <h1 class="auth-title gradient-text">75 Hard</h1>
        <p class="auth-subtitle">{{ __('Sign in to continue') }}</p>

        <x-auth-session-status :status="session('status')" class="mb-4"/>

        <div class="auth-card">
            <form method="POST" action="{{ route('login') }}">
                @csrf

                <div class="form-field">
                    <x-input-label for="email" :value="__('Email')"/>
                    <x-text-input id="email" name="email" type="email" :value="old('email')" required autofocus autocomplete="username"/>
                    <x-input-error :messages="$errors->get('email')"/>
                </div>

                <div class="form-field">
                    <x-input-label for="password" :value="__('Password')"/>
                    <x-text-input id="password" name="password" type="password" required autocomplete="current-password"/>
                    <x-input-error :messages="$errors->get('password')"/>
                </div>

                <div class="form-checkbox">
                    <input id="remember_me" name="remember" type="checkbox">
                    <label for="remember_me">{{ __('Remember me') }}</label>
                </div>

                <x-primary-button>{{ __('Sign in') }}</x-primary-button>
            </form>

            <p class="divider">{{ __('or') }}</p>

            <a href="{{ route('register') }}" class="button button--secondary">{{ __('Create an account') }}</a>

            @if (Route::has('password.request'))
                <a href="{{ route('password.request') }}" class="text-link">{{ __('Forgot your password?') }}</a>
            @endif
        </div>
    </div>
</x-guest-layout>
