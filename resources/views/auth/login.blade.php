<x-guest-layout>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Bebas+Neue&family=DM+Sans:wght@300;400;500&display=swap');

        body {
            font-family: 'DM Sans', sans-serif;
            background: #0e0e0e;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 24px 16px;
        }

        .auth-wrap {
            width: 100%;
            max-width: 460px !important; /* Aligné sur la page register */
            transition: max-width 0.2s;
        }

        .auth-title {
            font-family: 'Bebas Neue', sans-serif;
            font-size: 64px;
            line-height: 1;
            color: #fff;
            text-align: center;
            margin-bottom: 4px;
        }

        .auth-title span {
            background: linear-gradient(135deg, #ff6b35, #f7c948);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .auth-sub {
            text-align: center;
            color: #555;
            font-size: 13px;
            margin-bottom: 36px;
            letter-spacing: .05em;
        }

        .auth-card {
            background: #141414;
            border: 1px solid #1e1e1e;
            border-radius: 20px;
            padding: 32px 32px; /* Plus d'espace interne pour l'harmonie */
        }

        label {
            display: block;
            font-size: 12px;
            color: #666;
            text-transform: uppercase;
            letter-spacing: .08em;
            margin-bottom: 8px;
        }

        input[type="text"],
        input[type="email"],
        input[type="password"] {
            width: 100%;
            background: #0e0e0e;
            border: 1px solid #2a2a2a;
            border-radius: 12px;
            padding: 12px 16px;
            color: #fff;
            font-size: 14px;
            font-family: 'DM Sans', sans-serif;
            transition: border-color .2s;
            outline: none;
            box-sizing: border-box;
        }

        input:focus {
            border-color: #ff6b35;
            box-shadow: 0 0 0 3px rgba(255,107,53,.1);
        }

        .field { margin-bottom: 20px; } /* Légèrement plus espacé pour le grand format */

        .remember {
            display: flex;
            align-items: center;
            gap: 8px;
            margin-bottom: 24px;
            margin-top: 4px;
        }

        .remember input[type="checkbox"] {
            appearance: auto;
            -webkit-appearance: auto;
            width: 16px;
            height: 16px;
            cursor: pointer;
            margin: 0;
        }

        .remember label {
            font-size: 13px;
            color: #555;
            text-transform: none;
            letter-spacing: normal;
            margin-bottom: 0;
            cursor: pointer;
        }

        .btn-primary {
            width: 100%;
            padding: 14px;
            border-radius: 12px;
            border: none;
            background: linear-gradient(135deg, #ff6b35, #f7c948);
            color: #0e0e0e;
            font-family: 'DM Sans', sans-serif;
            font-size: 15px;
            font-weight: 500;
            cursor: pointer;
            transition: all .2s;
            display: block;
            text-align: center;
            text-decoration: none;
            box-sizing: border-box;
        }

        .btn-primary:hover {
            transform: translateY(-1px);
            box-shadow: 0 8px 24px rgba(255,107,53,.3);
        }

        .divider {
            text-align: center;
            color: #333;
            font-size: 12px;
            margin: 24px 0;
            position: relative;
        }

        .divider::before, .divider::after {
            content: '';
            position: absolute;
            top: 50%;
            width: 42%;
            height: 1px;
            background: #1e1e1e;
        }

        .divider::before { left: 0; }
        .divider::after { right: 0; }

        .btn-secondary {
            width: 100%;
            padding: 14px;
            border-radius: 12px;
            border: 1px solid #2a2a2a;
            background: transparent;
            color: #888;
            font-family: 'DM Sans', sans-serif;
            font-size: 15px;
            cursor: pointer;
            transition: all .2s;
            text-align: center;
            display: block;
            text-decoration: none;
            box-sizing: border-box;
        }

        .btn-secondary:hover {
            border-color: #ff6b35;
            color: #fff;
        }

        .forgot {
            display: block;
            text-align: center;
            font-size: 12px;
            color: #444;
            margin-top: 16px;
            text-decoration: none;
            transition: color .2s;
        }

        .forgot:hover { color: #ff6b35; }

        .text-red-600, .error-msg {
            font-size: 11px !important;
            color: #f87171 !important;
            margin-top: 4px !important;
            list-style: none;
            padding: 0;
        }
    </style>

    <div class="auth-wrap">
        <h1 class="auth-title"><span>75 Hard</span></h1>
        <p class="auth-sub">Connecte-toi pour continuer</p>

        <x-auth-session-status class="mb-4" :status="session('status')" />

        <div class="auth-card">
            <form method="POST" action="{{ route('login') }}">
                @csrf

                <div class="field">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username"/>
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>

                <div class="field">
                    <label for="password">Mot de passe</label>
                    <input type="password" id="password" name="password" required autocomplete="current-password"/>
                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                </div>

                <div class="remember">
                    <input id="remember_me" type="checkbox" name="remember">
                    <label for="remember_me">Se souvenir de moi</label>
                </div>

                <button type="submit" class="btn-primary">Se connecter</button>
            </form>

            <div class="divider">ou</div>

            <a href="{{ route('register') }}" class="btn-secondary">Créer un compte</a>

            @if (Route::has('password.request'))
                <a href="{{ route('password.request') }}" class="forgot">Mot de passe oublié ?</a>
            @endif
        </div>
    </div>
</x-guest-layout>
