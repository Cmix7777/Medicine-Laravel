@extends('layouts.app')

@section('title', 'Вход - PHARMA')

@section('content')
    <div class="auth-container">
        <div class="auth-card">
            <div class="auth-header">
                <div class="auth-icon">
                    <svg width="48" height="48" viewBox="0 0 48 48" fill="none">
                        <rect width="48" height="48" rx="12" fill="var(--gold)" opacity="0.1"/>
                        <path d="M24 16C26.2091 16 28 17.7909 28 20C28 22.2091 26.2091 24 24 24C21.7909 24 20 22.2091 20 20C20 17.7909 21.7909 16 24 16Z" fill="var(--gold)"/>
                        <path d="M24 26C28.4183 26 32 27.5817 32 30V32H16V30C16 27.5817 19.5817 26 24 26Z" fill="var(--gold)"/>
                    </svg>
                </div>
                <h2>Вход</h2>
                <p class="auth-subtitle">Войдите в свой аккаунт</p>
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

            <form action="{{ route('login') }}" method="POST" class="auth-form">
                @csrf

                <div class="form-group">
                    <label for="email">
                        <svg width="18" height="18" viewBox="0 0 18 18" fill="none">
                            <path d="M3 3H15C15.5523 3 16 3.44772 16 4V14C16 14.5523 15.5523 15 15 15H3C2.44772 15 2 14.5523 2 14V4C2 3.44772 2.44772 3 3 3Z" stroke="var(--gold)" stroke-width="1.5"/>
                            <path d="M2 4L9 9.5L16 4" stroke="var(--gold)" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                        Email
                    </label>
                    <input type="email" id="email" name="email" value="{{ old('email') }}" required autofocus>
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
                    <input type="password" id="password" name="password" required>
                </div>

                <div class="form-actions">
                    <button type="submit" class="btn btn-full">Войти</button>
                    <a href="{{ route('home') }}" class="btn btn-secondary btn-full">Отмена</a>
                </div>
            </form>

            <div class="auth-footer">
                <span>Нет аккаунта?</span>
                <a href="{{ route('register') }}">Зарегистрироваться</a>
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
