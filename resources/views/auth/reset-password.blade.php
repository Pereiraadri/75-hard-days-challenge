<x-guest-layout>
    <div class="auth-wrap">
        <h1 class="auth-title gradient-text">75 Hard</h1>
        <p class="auth-subtitle">{{ __('Choose a new password') }}</p>

        <div class="auth-card">
            <form method="POST" action="{{ route('password.store') }}">
                @csrf

                <input type="hidden" name="token" value="{{ $request->route('token') }}">

                <div class="form-field">
                    <x-input-label for="email" :value="__('Email')"/>
                    <x-text-input id="email" name="email" type="email" :value="old('email', $request->email)" required autofocus autocomplete="username"/>
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

                <x-primary-button>{{ __('Reset my password') }}</x-primary-button>
            </form>
        </div>
    </div>
</x-guest-layout>
