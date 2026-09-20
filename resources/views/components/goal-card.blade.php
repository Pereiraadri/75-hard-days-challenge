@props(['day', 'goal', 'locked' => false, 'index' => 0])

<button
    type="button"
    @class([
        'goal-card',
        'goal-card--interactive',
        'is-done' => $goal->pivot->completed,
        'is-locked' => $locked,
    ])
    style="--stagger-index: {{ $index }}"
    data-goal-toggle
    data-url="{{ route('day-goals.toggle', [$day, $goal]) }}"
    aria-pressed="{{ $goal->pivot->completed ? 'true' : 'false' }}"
    @disabled($locked)
>
    <span class="goal-card__icon">{{ $goal->icon ?? config('challenge.default_goal_icon') }}</span>

    <span class="goal-card__body">
        <span class="goal-card__title">{{ __(Str::headline($goal->title)) }}</span>
        <span class="goal-card__description">{{ __($goal->body) }}</span>
    </span>

    <span class="goal-card__check">
        <svg width="13" height="10" viewBox="0 0 13 10" fill="none" aria-hidden="true">
            <path d="M1 5L5 9L12 1" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"/>
        </svg>
    </span>
</button>
