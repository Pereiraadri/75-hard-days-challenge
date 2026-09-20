@props(['label', 'completed', 'total', 'caption' => null, 'large' => false])

@php($percentage = $total > 0 ? round(($completed / $total) * 100) : 0)

<div @class(['score-card', 'score-card--large' => $large])>
    <div>
        <p class="score-card__label">{{ $label }}</p>
        <p @class(['score-card__value', 'score-card__value--large' => $large])>
            <span data-score-completed>{{ $completed }}</span>
            <span @class(['score-card__total', 'score-card__total--large' => $large])>/ {{ $total }}</span>
        </p>
        @if ($caption)
            <p class="score-card__caption">{{ $caption }}</p>
        @endif
    </div>

    <x-score-ring
        :percentage="$percentage"
        :size="$large ? 80 : 64"
        :radius="$large ? 34 : 26"
        :stroke-width="$large ? 5 : 4"
    />
</div>
