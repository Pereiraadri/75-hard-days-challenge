<x-guest-layout>
    <div class="auth-wrap">
        <h1 class="auth-title gradient-text">75 Hard</h1>
        <p class="auth-subtitle">{{ __('Create your account to get started') }}</p>

        <div class="auth-card">
            <form method="POST" action="{{ route('register') }}">
                @csrf

                <div class="form-row">
                    <div>
                        <x-input-label for="first_name" :value="__('First name')"/>
                        <x-text-input id="first_name" name="first_name" type="text" :value="old('first_name')" required autofocus autocomplete="given-name"/>
                        <x-input-error :messages="$errors->get('first_name')"/>
                    </div>

                    <div>
                        <x-input-label for="last_name" :value="__('Last name')"/>
                        <x-text-input id="last_name" name="last_name" type="text" :value="old('last_name')" required autocomplete="family-name"/>
                        <x-input-error :messages="$errors->get('last_name')"/>
                    </div>
                </div>

                <div class="form-field">
                    <x-input-label for="email" :value="__('Email')"/>
                    <x-text-input id="email" name="email" type="email" :value="old('email')" required autocomplete="username"/>
                    <x-input-error :messages="$errors->get('email')"/>
                </div>

                <div class="form-field">
                    <x-input-label for="password" :value="__('Password')"/>
                    <x-text-input id="password" name="password" type="password" required autocomplete="new-password"/>
                    <x-input-error :messages="$errors->get('password')"/>
                </div>

                <div class="form-field">
                    <x-input-label for="password_confirmation" :value="__('Confirm password')"/>
                    <x-text-input id="password_confirmation" name="password_confirmation" type="password" required autocomplete="new-password"/>
                    <x-input-error :messages="$errors->get('password_confirmation')"/>
                </div>

                <x-primary-button>{{ __('Create my account') }} →</x-primary-button>
            </form>

            <p class="divider">{{ __('or') }}</p>

            <a href="{{ route('login') }}" class="button button--secondary">{{ __('I already have an account') }}</a>
        </div>
    </div>
</x-guest-layout>
