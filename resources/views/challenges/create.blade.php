<x-app-layout>
    <div class="page">

        <div class="hero fade-up">
            <p class="hero__eyebrow">{{ __('Are you ready') }}</p>
            <h1 class="hero__title">75 <span class="gradient-text">HARD</span></h1>
            <p class="hero__subtitle">{{ __('75 days. No excuses. No compromises.') }}</p>
        </div>

        <div class="card-stack">
            <div class="card fade-up" style="--stagger-index: 1">
                <p class="section-title">{{ __('Your daily goals') }}</p>

                <ul class="rule-list">
                    @foreach ($goals as $goal)
                        <li class="rule-list__item">
                            <span class="rule-list__icon">{{ $goal->icon ?? config('challenge.default_goal_icon') }}</span>
                            <span>{{ __($goal->body) }}</span>
                        </li>
                    @endforeach
                </ul>
            </div>

            <div class="card card--highlighted fade-up" style="--stagger-index: 2">
                <h2 class="card__title">{{ __('Start the challenge') }}</h2>
                <p class="card__description">{{ __('Pick your start date and go.') }}</p>

                <form method="POST" action="{{ route('challenges.store') }}">
                    @csrf

                    <div class="form-field">
                        <x-input-label for="start_date" :value="__('Start date')"/>
                        <x-text-input
                            id="start_date"
                            name="start_date"
                            type="date"
                            :value="old('start_date', today()->toDateString())"
                            required
                        />
                        <x-input-error :messages="$errors->get('start_date')"/>
                    </div>

                    <x-primary-button>{{ __('Start the challenge') }} →</x-primary-button>
                </form>
            </div>
        </div>

        <p class="page-subtitle text-center">
            {{ __('If you miss a day the challenge goes on, but be honest with yourself.') }}
        </p>

    </div>
</x-app-layout>
