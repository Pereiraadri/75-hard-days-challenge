<x-app-layout>
    <div class="page">

        <a href="{{ route('dashboard') }}" class="back-link">← {{ __('Dashboard') }}</a>

        <h1 class="page-title gradient-text">{{ __('My stats') }}</h1>
        <p class="page-subtitle">{{ __('Since the beginning of the challenge') }}</p>

        <x-score-card
            large
            :label="__('Overall score')"
            :completed="$completedGoalsCount"
            :total="$trackedGoalsCount"
            :caption="__(':percentage% completed', ['percentage' => $completionPercentage])"
        />

        <div class="card">
            <x-progress-bar thick :percentage="$completionPercentage" :label="__('Goals completed')"/>
        </div>

        <p class="section-title">{{ __('By goal') }}</p>

        @foreach ($goalCompletionRates as $rate)
            <div class="goal-stat" style="--stagger-index: {{ $loop->index }}">
                <span class="goal-stat__icon">{{ $rate['goal']->icon ?? config('challenge.default_goal_icon') }}</span>

                <div class="goal-stat__body">
                    <p class="goal-stat__name">{{ __(Str::headline($rate['goal']->title)) }}</p>
                    <div class="progress__track">
                        <div class="progress__fill" style="width: {{ $rate['percentage'] }}%"></div>
                    </div>
                </div>

                <p class="goal-stat__score">
                    {{ $rate['completed'] }}
                    <span class="goal-stat__total">/ {{ $rate['tracked'] }}</span>
                </p>
            </div>
        @endforeach

    </div>
</x-app-layout>
