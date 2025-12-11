@extends('layouts.app')

@section('title', 'Добавить лекарство - PHARMA')

@section('content')
    <div class="form-header">
        <a href="{{ route('medicines.index') }}" class="back-link">
            <svg width="20" height="20" viewBox="0 0 20 20" fill="none">
                <path d="M12.5 15L7.5 10L12.5 5" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
            Назад
        </a>
        <h2>Добавить лекарство</h2>
    </div>

    <div class="form-card">
        <form action="{{ route('medicines.store') }}" method="POST" class="medicine-form">
            @csrf

            <div class="form-row">
                <div class="form-group">
                    <label for="name">
                        <svg width="18" height="18" viewBox="0 0 18 18" fill="none">
                            <path d="M3 3H15C15.5523 3 16 3.44772 16 4V14C16 14.5523 15.5523 15 15 15H3C2.44772 15 2 14.5523 2 14V4C2 3.44772 2.44772 3 3 3Z" stroke="var(--gold)" stroke-width="1.5"/>
                            <path d="M6 7H12M6 10H10" stroke="var(--gold)" stroke-width="1.5" stroke-linecap="round"/>
                        </svg>
                        Название *
                    </label>
                    <input type="text" id="name" name="name" value="{{ old('name') }}" required>
                    @error('name')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="category">
                        <svg width="18" height="18" viewBox="0 0 18 18" fill="none">
                            <rect x="3" y="3" width="6" height="6" rx="1" stroke="var(--gold)" stroke-width="1.5"/>
                            <rect x="9" y="3" width="6" height="6" rx="1" stroke="var(--gold)" stroke-width="1.5"/>
                            <rect x="3" y="9" width="6" height="6" rx="1" stroke="var(--gold)" stroke-width="1.5"/>
                            <rect x="9" y="9" width="6" height="6" rx="1" stroke="var(--gold)" stroke-width="1.5"/>
                        </svg>
                        Категория
                    </label>
                    <input type="text" id="category" name="category" value="{{ old('category') }}">
                    @error('category')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="form-group">
                <label for="description">
                    <svg width="18" height="18" viewBox="0 0 18 18" fill="none">
                        <path d="M3 3H15C15.5523 3 16 3.44772 16 4V14C16 14.5523 15.5523 15 15 15H3C2.44772 15 2 14.5523 2 14V4C2 3.44772 2.44772 3 3 3Z" stroke="var(--gold)" stroke-width="1.5"/>
                        <path d="M5 7H13M5 10H11" stroke="var(--gold)" stroke-width="1.5" stroke-linecap="round"/>
                    </svg>
                    Описание
                </label>
                <textarea id="description" name="description" rows="4">{{ old('description') }}</textarea>
                @error('description')
                    <div class="error-message">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="price">
                        <svg width="18" height="18" viewBox="0 0 18 18" fill="none">
                            <circle cx="9" cy="9" r="7" stroke="var(--gold)" stroke-width="1.5"/>
                            <path d="M9 5V9L12 12" stroke="var(--gold)" stroke-width="1.5" stroke-linecap="round"/>
                        </svg>
                        Цена *
                    </label>
                    <input type="number" id="price" name="price" step="0.01" min="0" value="{{ old('price') }}" required>
                    @error('price')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="quantity">
                        <svg width="18" height="18" viewBox="0 0 18 18" fill="none">
                            <rect x="2" y="5" width="14" height="11" rx="1" stroke="var(--gold)" stroke-width="1.5"/>
                            <path d="M6 5V3C6 2.44772 6.44772 2 7 2H11C11.5523 2 12 2.44772 12 3V5" stroke="var(--gold)" stroke-width="1.5"/>
                            <path d="M9 8V12M7 10H11" stroke="var(--gold)" stroke-width="1.5" stroke-linecap="round"/>
                        </svg>
                        Количество *
                    </label>
                    <input type="number" id="quantity" name="quantity" min="0" value="{{ old('quantity') }}" required>
                    @error('quantity')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="manufacturer">
                        <svg width="18" height="18" viewBox="0 0 18 18" fill="none">
                            <path d="M9 1L11.5 5.5L16.5 6.5L13 10L13.5 15L9 12.5L4.5 15L5 10L1.5 6.5L6.5 5.5L9 1Z" fill="var(--gold)"/>
                        </svg>
                        Производитель
                    </label>
                    <input type="text" id="manufacturer" name="manufacturer" value="{{ old('manufacturer') }}">
                    @error('manufacturer')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="expiry_date">
                        <svg width="18" height="18" viewBox="0 0 18 18" fill="none">
                            <rect x="3" y="4" width="12" height="12" rx="1" stroke="var(--gold)" stroke-width="1.5"/>
                            <path d="M3 7H15M6 2V4M12 2V4" stroke="var(--gold)" stroke-width="1.5" stroke-linecap="round"/>
                        </svg>
                        Срок годности
                    </label>
                    <input type="date" id="expiry_date" name="expiry_date" value="{{ old('expiry_date') }}">
                    @error('expiry_date')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="form-actions">
                <button type="submit" class="btn">Сохранить</button>
                <a href="{{ route('medicines.index') }}" class="btn btn-secondary">Отмена</a>
            </div>
        </form>
    </div>
@endsection

<style>
    .form-header {
        margin-bottom: 40px;
    }

    .back-link {
        display: inline-flex;
        align-items: center;
        gap: 10px;
        color: rgba(255, 255, 255, 0.6);
        text-decoration: none;
        margin-bottom: 25px;
        font-weight: 500;
        transition: all 0.3s ease;
    }

    .back-link:hover {
        color: var(--gold);
        transform: translateX(-5px);
    }

    .form-header h2 {
        font-size: 3em;
        margin-bottom: 0;
    }

    .form-card {
        background: var(--gray);
        border: 1px solid rgba(255, 215, 0, 0.2);
        border-radius: 24px;
        padding: 50px;
    }

    .medicine-form {
        max-width: 900px;
    }

    .form-row {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 30px;
    }

    .form-group label {
        display: flex;
        align-items: center;
        gap: 10px;
        margin-bottom: 12px;
    }

    .error-message {
        color: #FF4444;
        font-size: 0.85em;
        margin-top: 8px;
        font-family: 'JetBrains Mono', monospace;
    }

    .form-actions {
        display: flex;
        gap: 15px;
        margin-top: 40px;
        padding-top: 30px;
        border-top: 1px solid rgba(255, 215, 0, 0.2);
    }

    @media (max-width: 768px) {
        .form-row {
            grid-template-columns: 1fr;
        }

        .form-card {
            padding: 30px 20px;
        }
    }
</style>
