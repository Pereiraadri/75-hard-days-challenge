{{-- resources/views/days/calendar.blade.php --}}
<x-app-layout>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Bebas+Neue&family=DM+Sans:wght@300;400;500&display=swap');

        .cal-page {
            font-family: 'DM Sans', sans-serif;
            background: #0e0e0e;
            min-height: 100vh;
            padding: 24px 16px 60px;
            color: #fff;
        }

        /* ── Header ── */
        .cal-header {
            margin-bottom: 28px;
        }

        .cal-back {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            font-size: 13px;
            color: #555;
            text-decoration: none;
            margin-bottom: 16px;
            transition: color .2s;
        }

        .cal-back:hover { color: #ff6b35; }

        .cal-title {
            font-family: 'Bebas Neue', sans-serif;
            font-size: 44px;
            line-height: 1;
            color: #fff;
        }

        .cal-title span {
            background: linear-gradient(135deg, #ff6b35, #f7c948);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .cal-sub {
            font-size: 13px;
            color: #444;
            margin-top: 4px;
        }

        /* ── Legend ── */
        .legend {
            display: flex;
            gap: 16px;
            margin-bottom: 24px;
            flex-wrap: wrap;
        }

        .legend-item {
            display: flex;
            align-items: center;
            gap: 6px;
            font-size: 12px;
            color: #555;
        }

        .legend-dot {
            width: 10px;
            height: 10px;
            border-radius: 50%;
        }

        /* ── Stats bar ── */
        .stats-row {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 10px;
            margin-bottom: 28px;
        }

        .stat-card {
            background: #141414;
            border: 1px solid #1e1e1e;
            border-radius: 14px;
            padding: 14px 12px;
            text-align: center;
        }

        .stat-value {
            font-family: 'Bebas Neue', sans-serif;
            font-size: 32px;
            line-height: 1;
            background: linear-gradient(135deg, #ff6b35, #f7c948);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .stat-label {
            font-size: 11px;
            color: #444;
            text-transform: uppercase;
            letter-spacing: .08em;
            margin-top: 4px;
        }

        /* ── Grid ── */
        .days-grid {
            display: grid;
            grid-template-columns: repeat(7, 1fr);
            gap: 8px;
        }

        .day-cell {
            aspect-ratio: 1;
            border-radius: 50%;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            font-size: 12px;
            font-weight: 500;
            cursor: pointer;
            transition: transform .15s, box-shadow .15s;
            text-decoration: none;
            position: relative;
        }

        .day-cell:active { transform: scale(.92); }

        .day-cell .day-num {
            font-size: 14px;
            font-weight: 500;
            line-height: 1;
        }

        .day-cell .day-date {
            font-size: 9px;
            opacity: .6;
            margin-top: 2px;
        }

        /* States */
        .day-validated {
            background: #162519;
            border: 1.5px solid #2d5a38;
            color: #4ade80;
        }

        .day-validated:hover {
            box-shadow: 0 0 16px rgba(74,222,128,.2);
            transform: scale(1.05);
        }

        .day-missed {
            background: #1a1010;
            border: 1.5px solid #4a2020;
            color: #f87171;
        }

        .day-missed:hover {
            box-shadow: 0 0 16px rgba(248,113,113,.2);
            transform: scale(1.05);
        }

        .day-future {
            background: #111;
            border: 1.5px solid #1e1e1e;
            color: #333;
            cursor: default;
            pointer-events: none;
        }

        .day-today {
            background: #1a1610;
            border: 1.5px solid #ff6b35;
            color: #ff6b35;
        }

        .day-today:hover {
            box-shadow: 0 0 16px rgba(255,107,53,.25);
            transform: scale(1.05);
        }

        /* Pulse sur today */
        .day-today::after {
            content: '';
            position: absolute;
            inset: -4px;
            border-radius: 50%;
            border: 1px solid rgba(255,107,53,.3);
            animation: ring-pulse 2s infinite;
        }

        @keyframes ring-pulse {
            0%, 100% { opacity: 1; transform: scale(1); }
            50% { opacity: 0; transform: scale(1.2); }
        }

        /* ── Animations ── */
        @keyframes fadeIn {
            from { opacity: 0; transform: scale(.85); }
            to   { opacity: 1; transform: scale(1); }
        }

        .day-cell {
            animation: fadeIn .3s ease both;
        }
    </style>

    <div class="cal-page">

        {{-- Header --}}
        <div class="cal-header">
            <a href="{{ route('dashboard') }}" class="cal-back">
                ← Retour
            </a>
            <h1 class="cal-title">Mon <span>Challenge</span></h1>
            <p class="cal-sub">Depuis
                le {{ \Carbon\Carbon::parse($startDate)->locale('fr')->isoFormat('D MMMM YYYY') }}</p>
        </div>

        {{-- Stats --}}
        @php
            $total = count($dates);
            $validated = collect($userDays)->filter(fn($v) => $v['is_validated'] ?? false)->count();
            $daysPassed = collect($dates)->filter(fn($d) => $d->isPast() && !$d->isToday())->count() + 1;
            $missed = $daysPassed - $validated;
        @endphp

        <div class="stats-row">
            <div class="stat-card">
                <div class="stat-value">{{ $validated }}</div>
                <div class="stat-label">Validés</div>
            </div>
            <div class="stat-card">
                <div class="stat-value">{{ $missed }}</div>
                <div class="stat-label">Manqués</div>
            </div>
            <div class="stat-card">
                <div class="stat-value">{{ 75 - $total }}</div>
                <div class="stat-label">Restants</div>
            </div>
        </div>

        {{-- Legend --}}
        <div class="legend">
            <div class="legend-item">
                <div class="legend-dot" style="background:#4ade80;"></div>
                <span>Validé</span>
            </div>
            <div class="legend-item">
                <div class="legend-dot" style="background:#f87171;"></div>
                <span>Non validé</span>
            </div>
            <div class="legend-item">
                <div class="legend-dot" style="background:#ff6b35;"></div>
                <span>Aujourd'hui</span>
            </div>
            <div class="legend-item">
                <div class="legend-dot" style="background:#222;"></div>
                <span>À venir</span>
            </div>
        </div>

        {{-- Grid --}}
        <div class="days-grid">
            @foreach($dates as $i => $date)
                @php
                    $dateStr = $date->format('Y-m-d');
                    $isToday = $date->isToday();
                    $isFuture = $date->isFuture();
                    $dayNum = $i + 1;
                    $dayData = $userDays[$dateStr] ?? null;

                    if ($isToday) {
                        $class = 'day-today';
                    } elseif ($isFuture) {
                        $class = 'day-future';
                    } elseif ($dayData && $dayData['is_validated']) {
                        $class = 'day-validated';
                    } elseif ($dayData) {
                        $class = 'day-missed';
                    } else {
                        $class = 'day-missed';
                    }

                    $delay = ($i % 21) * 20;
                    $href = $dayData
                        ? route('days.show', $dayData['id'])
                        : route('days.show', ['date' => $dateStr]);
                @endphp

                @if(!$isFuture)
                    <a
                        href="{{ $href }}"
                        class="day-cell {{ $class }}"
                        style="animation-delay: {{ $delay }}ms"
                    >
                        <span class="day-num">{{ $dayNum }}</span>
                        <span class="day-date">{{ $date->format('d/m') }}</span>
                    </a>
                @else
                    <div class="day-cell {{ $class }}" style="animation-delay: {{ $delay }}ms">
                        <span class="day-num">{{ $dayNum }}</span>
                        <span class="day-date">{{ $date->format('d/m') }}</span>
                    </div>
                @endif
            @endforeach
        </div>

    </div>
</x-app-layout>
