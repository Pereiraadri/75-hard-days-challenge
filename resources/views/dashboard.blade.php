<x-app-layout>
    <div class="page">

        <div class="page-header">
            <div>
                <p class="eyebrow">{{ __('Hello, :name', ['name' => auth()->user()->first_name]) }} 👋</p>
                <h1 class="page-title">75 <span class="gradient-text">Hard</span></h1>
            </div>

            <div class="day-counter">
                @if ($challenge->hasStarted())
                    <p class="day-counter__value gradient-text">{{ $challenge->currentDayNumber() }}</p>
                    <p class="day-counter__label">{{ __('of :total days', ['total' => $challenge->durationInDays()]) }}</p>
                @else
                    <p class="day-counter__value gradient-text">
                        {{ trans_choice('Starts in :count day|Starts in :count days', $challenge->daysUntilStart(), ['count' => $challenge->daysUntilStart()]) }}
                    </p>
                @endif
            </div>
        </div>

        @if ($challenge->hasStarted())
            <x-progress-bar :percentage="$challenge->progressPercentage()" :label="__('Progress')"/>
        @endif

        <p class="date-chip">
            <span class="date-chip__dot"></span>
            {{ today()->locale(app()->getLocale())->isoFormat('dddd D MMMM') }}
        </p>

        <div>
            <a href="{{ route('days.calendar') }}" class="pill-link">📅 {{ __('My days') }}</a>
            <a href="{{ route('days.stats') }}" class="pill-link">📊 {{ __('My stats') }}</a>
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
                :label="__('Today')"
                :completed="$day->completedGoalsCount()"
                :total="$day->goals->count()"
            />

            <div class="button-stack">
                @if ($day->is_validated)
                    <button type="button" class="button button--done button--large" disabled>
                        {{ __('Day validated') }}
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
