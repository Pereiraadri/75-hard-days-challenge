<x-app-layout>
    <div class="page">

        <a href="{{ route('dashboard') }}" class="back-link">← {{ __('Dashboard') }}</a>

        <h1 class="page-title gradient-text">{{ __('My profile') }}</h1>
        <p class="page-subtitle">{{ __('Manage your account and your password') }}</p>

        <div class="card-stack mt-7">
            <div class="card">
                @include('profile.partials.update-profile-information-form')
            </div>

            <div class="card">
                @include('profile.partials.update-password-form')
            </div>

            <div class="card">
                @include('profile.partials.delete-user-form')
            </div>
        </div>

    </div>
</x-app-layout>
