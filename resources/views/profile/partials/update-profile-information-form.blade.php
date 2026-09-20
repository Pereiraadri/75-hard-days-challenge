<h2 class="card__title">{{ __('Profile information') }}</h2>
<p class="card__description">{{ __("Update your account's name and email address.") }}</p>

<form method="POST" action="{{ route('profile.update') }}">
    @csrf
    @method('patch')

    <div class="form-row">
        <div>
            <x-input-label for="first_name" :value="__('First name')"/>
            <x-text-input id="first_name" name="first_name" type="text" :value="old('first_name', $user->first_name)" required autocomplete="given-name"/>
            <x-input-error :messages="$errors->get('first_name')"/>
        </div>

        <div>
            <x-input-label for="last_name" :value="__('Last name')"/>
            <x-text-input id="last_name" name="last_name" type="text" :value="old('last_name', $user->last_name)" required autocomplete="family-name"/>
            <x-input-error :messages="$errors->get('last_name')"/>
        </div>
    </div>

    <div class="form-field">
        <x-input-label for="email" :value="__('Email')"/>
        <x-text-input id="email" name="email" type="email" :value="old('email', $user->email)" required autocomplete="username"/>
        <x-input-error :messages="$errors->get('email')"/>
    </div>

    <div class="form-actions">
        <x-primary-button class="button--inline">{{ __('Save') }}</x-primary-button>

        @if (session('status') === 'profile-updated')
            <p class="form-status">{{ __('Saved.') }}</p>
        @endif
    </div>
</form>
