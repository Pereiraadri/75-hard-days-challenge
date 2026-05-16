{{-- resources/views/stats.blade.php --}}
<x-app-layout>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Bebas+Neue&family=DM+Sans:wght@300;400;500&display=swap');

        .page {
            font-family: 'DM Sans', sans-serif;
            background: #0e0e0e;
            min-height: 100vh;
            padding: 24px 16px 60px;
            color: #fff;
        }

        .back-link {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            font-size: 13px;
            color: #555;
            text-decoration: none;
            margin-bottom: 20px;
            transition: color .2s;
        }

        .back-link:hover { color: #ff6b35; }

        /* ── Header ── */
        .page-title {
            font-family: 'Bebas Neue', sans-serif;
            font-size: 52px;
            line-height: 1;
            color: #fff;
            margin-bottom: 4px;
        }

        .page-title span {
            background: linear-gradient(135deg, #ff6b35, #f7c948);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .page-sub { font-size: 13px; color: #444; margin-bottom: 28px; }

        /* ── Score global ── */
        .global-card {
            background: #141414;
            border: 1px solid #1e1e1e;
            border-radius: 20px;
            padding: 24px;
            margin-bottom: 16px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 16px;
        }

        .global-label {
            font-size: 11px;
            color: #444;
            text-transform: uppercase;
            letter-spacing: .1em;
            margin-bottom: 8px;
        }

        .global-score {
            font-family: 'Bebas Neue', sans-serif;
            font-size: 56px;
            line-height: 1;
            color: #fff;
        }

        .global-score span { font-size: 24px; color: #333; }

        .global-pct {
            font-size: 13px;
            color: #555;
            margin-top: 4px;
        }

        .global-pct strong {
            background: linear-gradient(135deg, #ff6b35, #f7c948);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        /* Ring */
        .ring-wrap { flex-shrink: 0; }

        .score-ring { width: 80px; height: 80px; transform: rotate(-90deg); }

        /* ── Progress bar global ── */
        .progress-card {
            background: #141414;
            border: 1px solid #1e1e1e;
            border-radius: 20px;
            padding: 20px;
            margin-bottom: 24px;
        }

        .progress-meta {
            display: flex;
            justify-content: space-between;
            font-size: 12px;
            color: #444;
            margin-bottom: 10px;
        }

        .progress-track {
            height: 6px;
            background: #1e1e1e;
            border-radius: 99px;
            overflow: hidden;
        }

        .progress-fill {
            height: 100%;
            background: linear-gradient(90deg, #ff6b35, #f7c948);
            border-radius: 99px;
            transition: width .8s cubic-bezier(.16,1,.3,1);
        }

        /* ── Section title ── */
        .section-title {
            font-size: 11px;
            color: #444;
            text-transform: uppercase;
            letter-spacing: .1em;
            margin-bottom: 12px;
        }

        /* ── Goal stats ── */
        .goal-stat {
            background: #141414;
            border: 1px solid #1e1e1e;
            border-radius: 16px;
            padding: 16px 20px;
            margin-bottom: 10px;
            display: flex;
            align-items: center;
            gap: 14px;
        }

        .goal-emoji {
            font-size: 22px;
            width: 40px;
            height: 40px;
            background: #1a1a1a;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .goal-info { flex: 1; min-width: 0; }

        .goal-name {
            font-size: 14px;
            font-weight: 500;
            color: #e5e5e5;
            margin-bottom: 8px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .goal-bar-track {
            height: 4px;
            background: #1e1e1e;
            border-radius: 99px;
            overflow: hidden;
        }

        .goal-bar-fill {
            height: 100%;
            border-radius: 99px;
            background: linear-gradient(90deg, #ff6b35, #f7c948);
            transition: width .8s cubic-bezier(.16,1,.3,1);
        }

        .goal-score {
            font-family: 'Bebas Neue', sans-serif;
            font-size: 26px;
            color: #fff;
            flex-shrink: 0;
            text-align: right;
            line-height: 1;
        }

        .goal-score small { font-size: 13px; color: #333; font-family: 'DM Sans', sans-serif; }

        /* ── Animations ── */
        @keyframes fadeUp {
            from { opacity: 0; transform: translateY(16px); }
            to   { opacity: 1; transform: translateY(0); }
        }

        .global-card { animation: fadeUp .4s ease both .05s; }
        .progress-card { animation: fadeUp .4s ease both .1s; }
        .goal-stat:nth-child(1) { animation: fadeUp .4s ease both .15s; }
        .goal-stat:nth-child(2) { animation: fadeUp .4s ease both .20s; }
        .goal-stat:nth-child(3) { animation: fadeUp .4s ease both .25s; }
        .goal-stat:nth-child(4) { animation: fadeUp .4s ease both .30s; }
        .goal-stat:nth-child(5) { animation: fadeUp .4s ease both .35s; }
    </style>

    <div class="page">

        <a href="{{ route('dashboard') }}" class="back-link">← Dashboard</a>

        <h1 class="page-title">Mes <span>Stats</span></h1>
        <p class="page-sub">Depuis le début du challenge</p>

        @php
            $pct = $totalPossible > 0 ? round(($totalCompleted / $totalPossible) * 100) : 0;
            $circumference = 2 * pi() * 34;
            $offset = $circumference - ($pct / 100) * $circumference;
            $emojis = ['🥗', '🚫', '🏃', '🏠', '💧'];
        @endphp

        {{-- Score global --}}
        <div class="global-card">
            <div>
                <div class="global-label">Score global</div>
                <div class="global-score">
                    {{ $totalCompleted }} <span>/ {{ $totalPossible }}</span>
                </div>
                <div class="global-pct">
                    <strong>{{ $pct }}%</strong> de réussite
                </div>
            </div>
            <div class="ring-wrap">
                <svg class="score-ring" width="80" height="80" viewBox="0 0 80 80">
                    <circle cx="40" cy="40" r="34" fill="none" stroke="#1e1e1e" stroke-width="5"/>
                    <circle
                        cx="40" cy="40" r="34"
                        fill="none"
                        stroke="url(#grad-stats)"
                        stroke-width="5"
                        stroke-linecap="round"
                        stroke-dasharray="{{ $circumference }}"
                        stroke-dashoffset="{{ $offset }}"
                    />
                    <defs>
                        <linearGradient id="grad-stats" x1="0%" y1="0%" x2="100%" y2="0%">
                            <stop offset="0%" stop-color="#ff6b35"/>
                            <stop offset="100%" stop-color="#f7c948"/>
                        </linearGradient>
                    </defs>
                </svg>
            </div>
        </div>

        {{-- Barre de progression --}}
        <div class="progress-card">
            <div class="progress-meta">
                <span>Objectifs complétés</span>
                <span>{{ $pct }}%</span>
            </div>
            <div class="progress-track">
                <div class="progress-fill" style="width: {{ $pct }}%"></div>
            </div>
        </div>

        {{-- Par catégorie --}}
        <p class="section-title">Par objectif</p>

        @foreach($byGoal as $i => $goal)
            @php
                $goalPct = $goal->total > 0 ? round(($goal->completed / $goal->total) * 100) : 0;
            @endphp
            <div class="goal-stat">
                <div class="goal-emoji">{{ $emojis[$i] ?? '🎯' }}</div>
                <div class="goal-info">
                    <div class="goal-name">{{ $goal->title }}</div>
                    <div class="goal-bar-track">
                        <div class="goal-bar-fill" style="width: {{ $goalPct }}%"></div>
                    </div>
                </div>
                <div class="goal-score">
                    {{ $goal->completed }}<br>
                    <small>/ {{ $goal->total }}</small>
                </div>
            </div>
        @endforeach
    </div>
</x-app-layout>
