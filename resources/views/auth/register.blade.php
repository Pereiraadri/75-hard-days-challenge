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

        .register-wrap {
            width: 100%;
            max-width: 400px;
        }

        .register-title {
            font-family: 'Bebas Neue', sans-serif;
            font-size: 64px;
            line-height: 1;
            color: #fff;
            text-align: center;
            margin-bottom: 4px;
        }

        .register-title span {
            background: linear-gradient(135deg, #ff6b35, #f7c948);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .register-sub {
            text-align: center;
            color: #555;
            font-size: 13px;
            margin-bottom: 36px;
            letter-spacing: .05em;
        }

        .register-card {
            background: #141414;
            border: 1px solid #1e1e1e;
            border-radius: 20px;
            padding: 28px 24px;
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
        }

        input[type="text"]:focus,
        input[type="email"]:focus,
        input[type="password"]:focus {
            border-color: #ff6b35;
            box-shadow: 0 0 0 3px rgba(255,107,53,.1);
        }

        .field { margin-bottom: 16px; }

        .field-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 12px;
            margin-bottom: 16px;
        }

        .btn-register {
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
            margin-top: 8px;
        }

        .btn-register:hover {
            transform: translateY(-1px);
            box-shadow: 0 8px 24px rgba(255,107,53,.3);
        }

        .divider {
            text-align: center;
            color: #333;
            font-size: 12px;
            margin: 20px 0;
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

        .btn-login {
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
        }

        .btn-login:hover {
            border-color: #ff6b35;
            color: #fff;
        }

        .error-msg {
            font-size: 11px;
            color: #f87171;
            margin-top: 4px;
        }
    </style>

    <div class="register-wrap">
        <h1 class="register-title">75 <span>Hard</span></h1>
        <p class="register-sub">Crée ton compte pour commencer</p>

        <div class="register-card">
            <form method="POST" action="{{ route('register') }}" onsubmit="this.querySelector('button[type=submit]').disabled = true;">
                @csrf

                <div class="field-row">
                    <div>
                        <label for="first_name">Prénom</label>
                        <input type="text" id="first_name" name="first_name" value="{{ old('first_name') }}" required autofocus/>
                        @error('first_name')<p class="error-msg">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label for="last_name">Nom</label>
                        <input type="text" id="last_name" name="last_name" value="{{ old('last_name') }}" required/>
                        @error('last_name')<p class="error-msg">{{ $message }}</p>@enderror
                    </div>
                </div>

                <div class="field">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" value="{{ old('email') }}" required"/>
                    @error('email')<p class="error-msg">{{ $message }}</p>@enderror
                </div>

                <div class="field">
                    <label for="password">Mot de passe</label>
                    <input type="password" id="password" name="password" required"/>
                    @error('password')<p class="error-msg">{{ $message }}</p>@enderror
                </div>

                <div class="field">
                    <label for="password_confirmation">Confirmer le mot de passe</label>
                    <input type="password" id="password_confirmation" name="password_confirmation" required"/>
                </div>

                <button type="submit" class="btn-register">Créer mon compte →</button>
            </form>

            <div class="divider">ou</div>

            <a href="{{ route('login') }}" class="btn-login">J'ai déjà un compte</a>
        </div>
    </div>
</x-guest-layout>
