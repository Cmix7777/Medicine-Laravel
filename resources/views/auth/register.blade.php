@extends('layouts.app')

@section('title', 'Регистрация - PHARMA')

@section('content')
    <div class="auth-container">
        <div class="auth-card">
            <div class="auth-header">
                <div class="auth-icon">
                    <svg width="48" height="48" viewBox="0 0 48 48" fill="none">
                        <rect width="48" height="48" rx="12" fill="var(--gold)" opacity="0.1"/>
                        <path d="M24 14C27.3137 14 30 16.6863 30 20C30 23.3137 27.3137 26 24 26C20.6863 26 18 23.3137 18 20C18 16.6863 20.6863 14 24 14Z" fill="var(--gold)"/>
                        <path d="M24 28C30.6274 28 36 30.3726 36 33V34H12V33C12 30.3726 17.3726 28 24 28Z" fill="var(--gold)"/>
                        <path d="M32 14C32 11.7909 30.2091 10 28 10C25.7909 10 24 11.7909 24 14" stroke="var(--gold)" stroke-width="2" stroke-linecap="round"/>
                    </svg>
                </div>
                <h2>Регистрация</h2>
                <p class="auth-subtitle">Создайте новый аккаунт</p>
            </div>

            @if($errors->any())
                <div class="alert alert-error">
                    <svg width="20" height="20" viewBox="0 0 20 20" fill="none" style="margin-right: 10px;">
                        <circle cx="10" cy="10" r="9" stroke="currentColor" stroke-width="2"/>
                        <path d="M10 6V10M10 14H10.01" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                    </svg>
                    <ul style="margin: 0; padding-left: 20px; list-style: none;">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('register') }}" method="POST" class="auth-form">
                @csrf

                <div class="form-group">
                    <label for="name">
                        <svg width="18" height="18" viewBox="0 0 18 18" fill="none">
                            <circle cx="9" cy="6" r="3" stroke="var(--gold)" stroke-width="1.5"/>
                            <path d="M3 15C3 12.2386 5.23858 10 8 10H10C12.7614 10 15 12.2386 15 15" stroke="var(--gold)" stroke-width="1.5" stroke-linecap="round"/>
                        </svg>
                        Имя
                    </label>
                    <input type="text" id="name" name="name" value="{{ old('name') }}" required autofocus>
                </div>

                <div class="form-group">
                    <label for="email">
                        <svg width="18" height="18" viewBox="0 0 18 18" fill="none">
                            <path d="M3 3H15C15.5523 3 16 3.44772 16 4V14C16 14.5523 15.5523 15 15 15H3C2.44772 15 2 14.5523 2 14V4C2 3.44772 2.44772 3 3 3Z" stroke="var(--gold)" stroke-width="1.5"/>
                            <path d="M2 4L9 9.5L16 4" stroke="var(--gold)" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                        Email
                    </label>
                    <input type="email" id="email" name="email" value="{{ old('email') }}" required>
                </div>

                <div class="form-group">
                    <label for="password">
                        <svg width="18" height="18" viewBox="0 0 18 18" fill="none">
                            <rect x="3" y="8" width="12" height="7" rx="1" stroke="var(--gold)" stroke-width="1.5"/>
                            <path d="M6 8V5C6 3.34315 7.34315 2 9 2C10.6569 2 12 3.34315 12 5V8" stroke="var(--gold)" stroke-width="1.5" stroke-linecap="round"/>
                            <circle cx="9" cy="11.5" r="1" fill="var(--gold)"/>
                        </svg>
                        Пароль
                    </label>
                    <input type="password" id="password" name="password" required minlength="8">
                    <small>Минимум 8 символов</small>
                </div>

                <div class="form-group">
                    <label for="password_confirmation">
                        <svg width="18" height="18" viewBox="0 0 18 18" fill="none">
                            <rect x="3" y="8" width="12" height="7" rx="1" stroke="var(--gold)" stroke-width="1.5"/>
                            <path d="M6 8V5C6 3.34315 7.34315 2 9 2C10.6569 2 12 3.34315 12 5V8" stroke="var(--gold)" stroke-width="1.5" stroke-linecap="round"/>
                            <path d="M7 11.5L8.5 13L11 10.5" stroke="var(--gold)" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                        Подтвердите пароль
                    </label>
                    <input type="password" id="password_confirmation" name="password_confirmation" required>
                </div>

                <div class="form-actions">
                    <button type="submit" class="btn btn-full">Зарегистрироваться</button>
                    <a href="{{ route('home') }}" class="btn btn-secondary btn-full">Отмена</a>
                </div>
            </form>

            <div class="auth-footer">
                <span>Уже есть аккаунт?</span>
                <a href="{{ route('login') }}">Войти</a>
            </div>
        </div>
    </div>
@endsection

<style>
    .auth-container {
        display: flex;
        justify-content: center;
        align-items: center;
        min-height: calc(100vh - 200px);
        padding: 40px 20px;
    }

    .auth-card {
        width: 100%;
        max-width: 480px;
        background: var(--gray);
        border: 1px solid rgba(255, 215, 0, 0.2);
        border-radius: 24px;
        padding: 50px 40px;
    }

    .auth-header {
        text-align: center;
        margin-bottom: 40px;
    }

    .auth-icon {
        display: inline-flex;
        margin-bottom: 20px;
    }

    .auth-header h2 {
        font-size: 2.5em;
        margin-bottom: 10px;
    }

    .auth-subtitle {
        color: rgba(255, 255, 255, 0.5);
        font-size: 1em;
    }

    .auth-form {
        margin-bottom: 30px;
    }

    .form-group label {
        display: flex;
        align-items: center;
        gap: 8px;
        margin-bottom: 10px;
    }

    .form-group small {
        display: block;
        margin-top: 8px;
        color: rgba(255, 255, 255, 0.4);
        font-size: 0.85em;
        font-family: 'JetBrains Mono', monospace;
    }

    .form-actions {
        display: flex;
        flex-direction: column;
        gap: 15px;
    }

    .btn-full {
        width: 100%;
        justify-content: center;
    }

    .auth-footer {
        text-align: center;
        padding-top: 30px;
        border-top: 1px solid rgba(255, 215, 0, 0.2);
        color: rgba(255, 255, 255, 0.5);
    }

    .auth-footer a {
        margin-left: 8px;
        font-weight: 600;
    }
</style>
