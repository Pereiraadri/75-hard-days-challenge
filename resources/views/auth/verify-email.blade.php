<x-guest-layout>
    <div class="auth-wrap">
        <h1 class="auth-title gradient-text">75 Hard</h1>
        <p class="auth-subtitle">{{ __('Verify your email address') }}</p>

        <div class="auth-card">
            <p class="auth-intro">
                {{ __('Thanks for signing up! Click the link we just emailed you to verify your address.') }}
            </p>

            @if (session('status') === 'verification-link-sent')
                <p class="form-status">{{ __('A new verification link has been sent to your email address.') }}</p>
            @endif

            <form method="POST" action="{{ route('verification.send') }}">
                @csrf
                <x-primary-button>{{ __('Resend the verification email') }}</x-primary-button>
            </form>

            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="text-link">{{ __('Log out') }}</button>
            </form>
        </div>
    </div>
</x-guest-layout>
