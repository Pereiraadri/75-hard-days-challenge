<x-app-layout>
    <div class="page">

        <a href="{{ route('days.calendar') }}" class="back-link">← {{ __('Calendar') }}</a>

        <div class="page-header">
            <div>
                <h1 class="day-headline">
                    {{ __('Day') }} <span class="gradient-text">{{ $challenge->dayNumberFor($day->date) }}</span>
                </h1>
                <p class="day-date">{{ $day->date->locale(app()->getLocale())->isoFormat('dddd D MMMM YYYY') }}</p>

                <p @class(['status-badge', 'status-badge--validated' => $day->is_validated, 'status-badge--pending' => ! $day->is_validated])>
                    <span class="status-badge__dot"></span>
                    {{ $day->is_validated ? __('Day validated') : __('In progress') }}
                </p>
            </div>
        </div>

        <div
            data-day-tracker
            data-validate-url="{{ route('days.validate', $day) }}"
            data-unvalidate-url="{{ route('days.unvalidate', $day) }}"
        >
            <div class="goal-list">
                @foreach ($day->goals as $goal)
                    <x-goal-card :day="$day" :goal="$goal" :locked="$day->is_validated" :index="$loop->index"/>
                @endforeach
            </div>

            <x-score-card
                :label="__('Score of the day')"
                :completed="$day->completedGoalsCount()"
                :total="$day->goals->count()"
            />

            <div class="button-stack">
                @if ($day->is_validated)
                    <button type="button" class="button button--done button--large" disabled>
                        {{ __('Day validated') }}
                    </button>

                    <button type="button" class="button button--secondary button--large" data-day-unvalidate>
                        ✏️ {{ __('Edit') }}
                    </button>
                @else
                    <button
                        type="button"
                        class="button button--primary button--large"
                        data-day-validate
                        data-pending-label="{{ __('Validating…') }}"
                        data-done-label="{{ __('Day validated') }}"
                    >
                        {{ __('Validate my day') }}
                    </button>
                @endif
            </div>
        </div>

    </div>
</x-app-layout>
