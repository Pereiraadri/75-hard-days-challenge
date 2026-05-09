{{-- resources/views/challenges/create.blade.php --}}
<x-app-layout>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Bebas+Neue&family=DM+Sans:wght@300;400;500&display=swap');

        .challenge-hero {
            font-family: 'Bebas Neue', sans-serif;
        }

        body, .dm-sans {
            font-family: 'DM Sans', sans-serif;
        }

        .day-badge {
            background: linear-gradient(135deg, #ff6b35, #f7c948);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .card-glow {
            box-shadow: 0 0 0 1px rgba(255,107,53,0.15), 0 20px 60px rgba(0,0,0,0.3);
        }

        .start-btn {
            background: linear-gradient(135deg, #ff6b35, #f7c948);
            transition: all 0.3s ease;
        }

        .start-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 30px rgba(255,107,53,0.4);
        }

        .progress-bar {
            background: linear-gradient(90deg, #ff6b35, #f7c948);
        }

        .input-focus:focus {
            border-color: #ff6b35;
            box-shadow: 0 0 0 3px rgba(255,107,53,0.15);
            outline: none;
        }

        .rule-item {
            transition: transform 0.2s ease;
        }

        .rule-item:hover {
            transform: translateX(4px);
        }

        @keyframes fadeUp {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .animate-fade-up {
            animation: fadeUp 0.6s ease forwards;
        }

        .animate-fade-up:nth-child(2) { animation-delay: 0.1s; }
        .animate-fade-up:nth-child(3) { animation-delay: 0.2s; }
        .animate-fade-up:nth-child(4) { animation-delay: 0.3s; }
    </style>

    <div class="min-h-screen bg-zinc-950 dm-sans py-12 px-4">
        <div class="max-w-lg mx-auto">

            {{-- Header --}}
            <div class="text-center mb-10 animate-fade-up">
                <p class="text-zinc-500 text-sm uppercase tracking-widest mb-2">Are you ready</p>
                <h1 class="challenge-hero text-7xl text-white leading-none">
                    75 <span class="day-badge">HARD</span>
                </h1>
                <p class="text-zinc-400 mt-3 text-sm">
                    75 days. No excuses. No compromises.
                </p>
            </div>

            {{-- Rules recap --}}
            <div class="bg-zinc-900 rounded-2xl p-5 mb-6 animate-fade-up">
                <p class="text-zinc-500 text-xs uppercase tracking-widest mb-4">Tes objectifs quotidiens</p>
                <ul class="space-y-3">
                    @foreach([
                        ['🥗', 'Manger sain'],
                        ['🚫', 'Zéro alcool'],
                        ['🏃', 'Séance outdoor (30 min min)'],
                        ['🏠', 'Séance indoor (30 min min)'],
                        ['💧', 'Boire 3 litres d\'eau'],
                    ] as $rule)
                        <li class="rule-item flex items-center gap-3 text-zinc-300 text-sm">
                            <span class="text-lg">{{ $rule[0] }}</span>
                            <span>{{ $rule[1] }}</span>
                        </li>
                    @endforeach
                </ul>
            </div>

            {{-- Form --}}
            <div class="bg-zinc-900 rounded-2xl p-6 card-glow animate-fade-up">
                <h2 class="text-zinc-900 font-medium text-lg mb-1">Lance le challenge</h2>
                <p class="text-zinc-500 text-sm mb-6">Choisis ta date de début et c'est parti.</p>

                <form method="POST" action="{{ route('challenges.store') }}">
                    @csrf

                    <div class="mb-6">
                        <label for="start_date" class="block text-zinc-400 text-sm mb-2">
                            Date de début
                        </label>
                        <input
                            type="date"
                            id="start_date"
                            name="start_date"
                            value="{{ old('start_date', now()->format('Y-m-d')) }}"
                            class="input-focus w-full bg-zinc-800 border border-zinc-700 text-white rounded-xl px-4 py-3 text-sm transition-all"
                            style="color: white;"
                            required
                        />
                        @error('start_date')
                        <p class="text-red-400 text-xs mt-2">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Progress preview --}}
                    <div class="mb-6 bg-zinc-800 rounded-xl p-4">
                        <div class="flex justify-between text-xs text-zinc-500 mb-2">
                            <span>Progression</span>
                            <span>Jour 0 / 75</span>
                        </div>
                        <div class="h-1.5 bg-zinc-700 rounded-full overflow-hidden">
                            <div class="progress-bar h-full rounded-full" style="width: 0%"></div>
                        </div>
                        <p class="text-zinc-600 text-xs mt-2">La barre se remplira au fil des jours ✦</p>
                    </div>

                    <button type="submit" class="start-btn w-full text-white font-medium py-3.5 rounded-xl text-sm tracking-wide">
                        Commencer le challenge →
                    </button>
                </form>
            </div>

            {{-- Footer note --}}
            <p class="text-center text-zinc-700 text-xs mt-6 animate-fade-up">
                Si tu rates un jour, le challenge continue — mais sois honnête avec toi-même.
            </p>

        </div>
    </div>
</x-app-layout>
