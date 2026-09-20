<x-app-layout>
    <div class="page">

        <a href="{{ route('dashboard') }}" class="back-link">← {{ __('Back') }}</a>

        <h1 class="page-title gradient-text">{{ __('My challenge') }}</h1>
        <p class="page-subtitle">
            {{ __('Since :date', ['date' => $challenge->start_date->locale(app()->getLocale())->isoFormat('D MMMM YYYY')]) }}
        </p>

        <div class="stat-grid">
            <x-stat-card :value="$validatedDaysCount" :label="__('Validated')"/>
            <x-stat-card :value="$missedDaysCount" :label="__('Missed')"/>
            <x-stat-card :value="$challenge->remainingDays()" :label="__('Remaining')"/>
        </div>

        <div class="legend">
            <span class="legend__item">
                <span class="legend__dot" style="--legend-color: var(--color-success)"></span>{{ __('Validated') }}
            </span>
            <span class="legend__item">
                <span class="legend__dot" style="--legend-color: var(--color-danger)"></span>{{ __('Not validated') }}
            </span>
            <span class="legend__item">
                <span class="legend__dot" style="--legend-color: var(--color-accent)"></span>{{ __('Today') }}
            </span>
            <span class="legend__item">
                <span class="legend__dot"></span>{{ __('Upcoming') }}
            </span>
        </div>

        <div class="day-grid">
            @foreach ($challengeDates as $date)
                @php($day = $daysByDate->get($date->toDateString()))

                @if ($date->isFuture())
                    <div class="day-cell day-cell--upcoming" style="--stagger-index: {{ $loop->index }}">
                        <span class="day-cell__number">{{ $loop->iteration }}</span>
                        <span class="day-cell__date">{{ $date->format('d/m') }}</span>
                    </div>
                @else
                    <a
                        href="{{ $day ? route('days.show', $day) : route('days.show', ['date' => $date->toDateString()]) }}"
                        @class([
                            'day-cell',
                            'day-cell--today' => $date->isToday(),
                            'day-cell--validated' => ! $date->isToday() && $day?->is_validated,
                            'day-cell--missed' => ! $date->isToday() && ! $day?->is_validated,
                        ])
                        style="--stagger-index: {{ $loop->index }}"
                    >
                        <span class="day-cell__number">{{ $loop->iteration }}</span>
                        <span class="day-cell__date">{{ $date->format('d/m') }}</span>
                    </a>
                @endif
            @endforeach
        </div>

    </div>
</x-app-layout>
