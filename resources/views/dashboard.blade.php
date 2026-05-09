{{-- resources/views/dashboard.blade.php --}}
<x-app-layout>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Bebas+Neue&family=DM+Sans:ital,wght@0,300;0,400;0,500;1,300&display=swap');

        * { box-sizing: border-box; }

        .page {
            font-family: 'DM Sans', sans-serif;
            background: #0e0e0e;
            min-height: 100vh;
            padding: 24px 16px 48px;
            color: #fff;
        }

        /* ── Header ── */
        .header {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            margin-bottom: 28px;
        }

        .greeting {
            font-size: 13px;
            color: #555;
            letter-spacing: .08em;
            text-transform: uppercase;
            margin-bottom: 4px;
        }

        .title {
            font-family: 'Bebas Neue', sans-serif;
            font-size: 52px;
            line-height: 1;
            color: #fff;
            letter-spacing: .02em;
        }

        .title span {
            background: linear-gradient(135deg, #ff6b35, #f7c948);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .day-counter {
            text-align: right;
        }

        .day-number {
            font-family: 'Bebas Neue', sans-serif;
            font-size: 48px;
            line-height: 1;
            background: linear-gradient(135deg, #ff6b35, #f7c948);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .day-label {
            font-size: 11px;
            color: #444;
            text-transform: uppercase;
            letter-spacing: .1em;
        }

        /* ── Progress ── */
        .progress-wrap {
            margin-bottom: 28px;
        }

        .progress-meta {
            display: flex;
            justify-content: space-between;
            font-size: 12px;
            color: #444;
            margin-bottom: 8px;
        }

        .progress-track {
            height: 3px;
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

        /* ── Date chip ── */
        .date-chip {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            background: #1a1a1a;
            border: 1px solid #222;
            border-radius: 99px;
            padding: 6px 14px;
            font-size: 12px;
            color: #666;
            margin-bottom: 24px;
        }

        .date-chip .dot {
            width: 6px;
            height: 6px;
            border-radius: 50%;
            background: #ff6b35;
            animation: pulse 2s infinite;
        }

        @keyframes pulse {
            0%, 100% { opacity: 1; }
            50% { opacity: .3; }
        }

        /* ── Goal Cards ── */
        .goals-list {
            display: flex;
            flex-direction: column;
            gap: 10px;
            margin-bottom: 32px;
        }

        .goal-card {
            background: #141414;
            border: 1px solid #1e1e1e;
            border-radius: 16px;
            padding: 18px 20px;
            display: flex;
            align-items: center;
            gap: 16px;
            cursor: pointer;
            transition: border-color .2s, background .2s, transform .15s;
            position: relative;
            overflow: hidden;
        }

        .goal-card:active { transform: scale(.98); }

        .goal-card.done {
            background: #111a13;
            border-color: #1e3320;
        }

        .goal-card.done::after {
            content: '';
            position: absolute;
            inset: 0;
            background: linear-gradient(135deg, rgba(74,222,128,.03), transparent);
            pointer-events: none;
        }

        .goal-emoji {
            font-size: 28px;
            flex-shrink: 0;
            width: 44px;
            height: 44px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: #1a1a1a;
            border-radius: 12px;
        }

        .goal-card.done .goal-emoji {
            background: #162519;
        }

        .goal-info {
            flex: 1;
            min-width: 0;
        }

        .goal-title {
            font-size: 15px;
            font-weight: 500;
            color: #e5e5e5;
            margin-bottom: 2px;
        }

        .goal-card.done .goal-title {
            color: #4ade80;
        }

        .goal-body {
            font-size: 12px;
            color: #444;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .goal-check {
            width: 26px;
            height: 26px;
            border-radius: 50%;
            border: 2px solid #2a2a2a;
            flex-shrink: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all .2s;
        }

        .goal-card.done .goal-check {
            background: #4ade80;
            border-color: #4ade80;
        }

        .check-icon {
            opacity: 0;
            transform: scale(0);
            transition: all .2s cubic-bezier(.34,1.56,.64,1);
        }

        .goal-card.done .check-icon {
            opacity: 1;
            transform: scale(1);
        }

        /* ── Score Card ── */
        .score-card {
            background: #141414;
            border: 1px solid #1e1e1e;
            border-radius: 20px;
            padding: 20px;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .score-label {
            font-size: 12px;
            color: #444;
            text-transform: uppercase;
            letter-spacing: .1em;
            margin-bottom: 4px;
        }

        .score-value {
            font-family: 'Bebas Neue', sans-serif;
            font-size: 40px;
            line-height: 1;
            color: #fff;
        }

        .score-max {
            font-size: 16px;
            color: #333;
        }

        .score-ring {
            width: 64px;
            height: 64px;
            transform: rotate(-90deg);
        }

        /* ── Animations ── */
        @keyframes fadeUp {
            from { opacity: 0; transform: translateY(16px); }
            to   { opacity: 1; transform: translateY(0); }
        }

        .goal-card {
            animation: fadeUp .4s ease both;
        }

        .goal-card:nth-child(1) { animation-delay: .05s; }
        .goal-card:nth-child(2) { animation-delay: .10s; }
        .goal-card:nth-child(3) { animation-delay: .15s; }
        .goal-card:nth-child(4) { animation-delay: .20s; }
        .goal-card:nth-child(5) { animation-delay: .25s; }

        /* ── Validate button ── */
        .validate-btn {
            width: 100%;
            margin-top: 16px;
            padding: 16px;
            border-radius: 16px;
            border: none;
            font-family: 'DM Sans', sans-serif;
            font-size: 15px;
            font-weight: 500;
            cursor: pointer;
            transition: all .2s ease;
            background: linear-gradient(135deg, #ff6b35, #f7c948);
            color: #0e0e0e;
        }

        .validate-btn:hover { transform: translateY(-2px); box-shadow: 0 8px 24px rgba(255,107,53,.3); }
        .validate-btn:active { transform: scale(.98); }

        .validate-btn.validated {
            background: #1a1a1a;
            border: 1px solid #2a2a2a;
            color: #4ade80;
            cursor: default;
            transform: none;
            box-shadow: none;
        }

        .goal-card.locked { pointer-events: none; opacity: .7; }
    </style>

    <div class="page">

        {{-- Header --}}
        <div class="header">
            <div>
                <p class="greeting">Bonjour, {{ auth()->user()->first_name }} 👋</p>
                <h1 class="title">75 <span>Hard</span></h1>
            </div>
            <div class="day-counter">
                @php
                    $dayNumber = \Carbon\Carbon::parse(auth()->user()->challenge->start_date)->diffInDays(today()) + 1;
                @endphp
                <div class="day-number">{{ $dayNumber }}</div>
                <div class="day-label">/ 75 jours</div>
            </div>
        </div>

        {{-- Progress bar --}}
        @php $pct = round(($dayNumber / 75) * 100); @endphp
        <div class="progress-wrap">
            <div class="progress-meta">
                <span>Progression</span>
                <span>{{ $pct }}%</span>
            </div>
            <div class="progress-track">
                <div class="progress-fill" style="width: {{ $pct }}%"></div>
            </div>
        </div>

        {{-- Date chip --}}
        <div class="date-chip">
            <span class="dot"></span>
            {{ \Carbon\Carbon::today()->locale('fr')->isoFormat('dddd D MMMM') }}
        </div>

        {{-- Goals --}}
        <div class="goals-list">
            @php
                $emojis = ['🥗', '🚫', '🏃', '🏠', '💧'];
                $i = 0;
            @endphp

            @foreach($dayGoals as $goal)
                @php $completed = $goal->pivot->completed; @endphp
                <div
                    class="goal-card {{ $completed ? 'done' : '' }} {{ $day->is_validated ? 'locked' : '' }}"
                    onclick="{{ $day->is_validated ? '' : "toggleGoal('{$goal->pivot->day_id}', '{$goal->id}', this)" }}"
                >
                    <div class="goal-emoji">{{ $emojis[$i++] }}</div>
                    <div class="goal-info">
                        <div class="goal-title">{{ $goal->title }}</div>
                        <div class="goal-body">{{ $goal->body }}</div>
                    </div>
                    <div class="goal-check">
                        <svg class="check-icon" width="13" height="10" viewBox="0 0 13 10" fill="none">
                            <path d="M1 5L5 9L12 1" stroke="#0e0e0e" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </div>
                </div>
            @endforeach
        </div>

        {{-- Score card --}}
        @php
            $completed = $dayGoals->filter(fn($g) => $g->pivot->completed)->count();
            $total = $dayGoals->count();
            $ringPct = $total > 0 ? round(($completed / $total) * 100) : 0;
            $circumference = 2 * pi() * 26;
            $offset = $circumference - ($ringPct / 100) * $circumference;
        @endphp

        <div class="score-card">
            <div>
                <div class="score-label">Aujourd'hui</div>
                <div class="score-value" id="score-value">
                    {{ $completed }} <span class="score-max">/ {{ $total }}</span>
                </div>
            </div>
            <svg class="score-ring" width="64" height="64" viewBox="0 0 64 64">
                <circle cx="32" cy="32" r="26" fill="none" stroke="#1e1e1e" stroke-width="4"/>
                <circle
                    id="progress-circle"
                    cx="32" cy="32" r="26"
                    fill="none"
                    stroke="url(#grad)"
                    stroke-width="4"
                    stroke-linecap="round"
                    stroke-dasharray="{{ $circumference }}"
                    stroke-dashoffset="{{ $offset }}"
                    style="transition: stroke-dashoffset .6s cubic-bezier(.16,1,.3,1)"
                />
                <defs>
                    <linearGradient id="grad" x1="0%" y1="0%" x2="100%" y2="0%">
                        <stop offset="0%" stop-color="#ff6b35"/>
                        <stop offset="100%" stop-color="#f7c948"/>
                    </linearGradient>
                </defs>
            </svg>
        </div>

        {{-- Validate button --}}
        @if($day->is_validated)
            <button class="validate-btn validated" disabled>✓ Journée validée</button>
        @else
            <button class="validate-btn" onclick="validateDay('{{ $day->id }}', this)">
                Valider ma journée →
            </button>
        @endif

    </div>

    <script>
        const CIRCUMFERENCE = 2 * Math.PI * 26;

        async function toggleGoal(dayId, goalId, el) {
            const response = await fetch(`/days/${dayId}/goals/${goalId}/toggle`, {
                method: 'PATCH',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Content-Type': 'application/json',
                }
            });

            const data = await response.json();
            el.classList.toggle('done', data.completed);
            updateScore();
        }

        function updateScore() {
            const total = document.querySelectorAll('.goal-card').length;
            const completed = document.querySelectorAll('.goal-card.done').length;

            document.querySelector('#score-value').innerHTML =
                `${completed} <span class="score-max">/ ${total}</span>`;

            const pct = total > 0 ? completed / total : 0;
            const offset = CIRCUMFERENCE - (pct * CIRCUMFERENCE);
            document.querySelector('#progress-circle').style.strokeDashoffset = offset;
        }

        async function validateDay(dayId, btn) {
            btn.disabled = true;
            btn.textContent = 'Validation...';

            await fetch(`/days/${dayId}/validate`, {
                method: 'PATCH',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Content-Type': 'application/json',
                }
            });

            btn.classList.add('validated');
            btn.textContent = '✓ Journée validée';
            document.querySelectorAll('.goal-card').forEach(c => c.classList.add('locked'));
        }
    </script>
</x-app-layout>
