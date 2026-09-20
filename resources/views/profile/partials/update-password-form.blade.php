<h2 class="card__title">{{ __('Update password') }}</h2>
<p class="card__description">{{ __('Use a long, random password to keep your account secure.') }}</p>

<form method="POST" action="{{ route('password.update') }}">
    @csrf
    @method('put')

    <div class="form-field">
        <x-input-label for="current_password" :value="__('Current password')"/>
        <x-text-input id="current_password" name="current_password" type="password" autocomplete="current-password"/>
        <x-input-error :messages="$errors->updatePassword->get('current_password')"/>
    </div>

    <div class="form-field">
        <x-input-label for="password" :value="__('New password')"/>
        <x-text-input id="password" name="password" type="password" autocomplete="new-password"/>
        <x-input-error :messages="$errors->updatePassword->get('password')"/>
    </div>

    <div class="form-field">
        <x-input-label for="password_confirmation" :value="__('Confirm password')"/>
        <x-text-input id="password_confirmation" name="password_confirmation" type="password" autocomplete="new-password"/>
        <x-input-error :messages="$errors->updatePassword->get('password_confirmation')"/>
    </div>

    <div class="form-actions">
        <x-primary-button class="button--inline">{{ __('Save') }}</x-primary-button>

        @if (session('status') === 'password-updated')
            <p class="form-status">{{ __('Saved.') }}</p>
        @endif
    </div>
</form>
