<h2 class="card__title">{{ __('Delete account') }}</h2>
<p class="card__description">
    {{ __('Deleting your account removes your challenge and every day you tracked. Enter your password to confirm.') }}
</p>

<form method="POST" action="{{ route('profile.destroy') }}">
    @csrf
    @method('delete')

    <div class="form-field">
        <x-input-label for="delete_password" :value="__('Password')"/>
        <x-text-input id="delete_password" name="password" type="password" autocomplete="current-password"/>
        <x-input-error :messages="$errors->userDeletion->get('password')"/>
    </div>

    <x-danger-button>{{ __('Delete my account') }}</x-danger-button>
</form>
