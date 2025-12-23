@extends('layouts.app')

@section('title', $medicine->name . ' - PHARMA')

@section('content')
    <a href="{{ route('medicines.index') }}" class="back-button">
        <svg width="20" height="20" viewBox="0 0 20 20" fill="none">
            <path d="M12.5 15L7.5 10L12.5 5" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
        </svg>
        Назад
    </a>

    <div class="detail-layout">
        <div class="detail-visual">
            <div class="visual-box">
                <img src="{{ $medicine->image_url ?? 'https://via.placeholder.com/400x400/1a1a1a/FFD700?text=Medicine' }}" 
                     alt="{{ $medicine->name }}" 
                     onerror="this.onerror=null; this.src='https://via.placeholder.com/400x400/1a1a1a/FFD700?text=Medicine';">
            </div>
            <div class="visual-badge">В наличии</div>
        </div>

        <div class="detail-content">
            <div class="detail-header">
                <div class="detail-category">{{ $medicine->category ?? 'Без категории' }}</div>
                <h1>{{ $medicine->name }}</h1>
                @if($medicine->manufacturer)
                    <div class="detail-manufacturer">{{ $medicine->manufacturer }}</div>
                @endif
            </div>

            <div class="detail-price-section">
                <div class="price-main">{{ number_format($medicine->price, 0) }} ₽</div>
                <div class="price-label">за единицу</div>
            </div>

            @if($medicine->description)
            <div class="detail-section">
                <h3>Описание</h3>
                <p>{{ $medicine->description }}</p>
            </div>
            @endif

            <div class="detail-specs">
                <div class="spec-card">
                    <div class="spec-icon-wrapper">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none">
                            <rect x="3" y="7" width="18" height="14" rx="1" stroke="var(--gold)" stroke-width="2"/>
                            <path d="M8 7V5C8 4.44772 8.44772 4 9 4H15C15.5523 4 16 4.44772 16 5V7" stroke="var(--gold)" stroke-width="2"/>
                            <path d="M12 11V15M10 13H14" stroke="var(--gold)" stroke-width="2" stroke-linecap="round"/>
                        </svg>
                    </div>
                    <div class="spec-content-wrapper">
                        <div class="spec-label">Количество</div>
                        <div class="spec-value">{{ $medicine->quantity }} шт.</div>
                    </div>
                </div>
                @if($medicine->expiry_date)
                <div class="spec-card">
                    <div class="spec-icon-wrapper">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none">
                            <rect x="4" y="5" width="16" height="16" rx="1" stroke="var(--gold)" stroke-width="2"/>
                            <path d="M4 9H20M8 3V5M16 3V5" stroke="var(--gold)" stroke-width="2" stroke-linecap="round"/>
                        </svg>
                    </div>
                    <div class="spec-content-wrapper">
                        <div class="spec-label">Срок годности</div>
                        <div class="spec-value">{{ $medicine->expiry_date->format('d.m.Y') }}</div>
                    </div>
                </div>
                @endif
            </div>

            <div class="detail-actions">
                @if($isExpired)
                    <div class="expired-warning">
                        <span>⚠ Срок годности истек</span>
                    </div>
                @elseif($medicine->quantity <= 0)
                    <div class="expired-warning">
                        <span>⚠ Нет в наличии</span>
                    </div>
                @else
                    <form action="{{ route('cart.add', $medicine) }}" method="POST" style="width: 100%;">
                        @csrf
                        <div style="display: flex; gap: 10px; align-items: center; margin-bottom: 15px;">
                            <label for="quantity" style="color: rgba(255, 255, 255, 0.7);">Количество:</label>
                            <input type="number" id="quantity" name="quantity" value="1" min="1" max="{{ $medicine->quantity }}" 
                                style="width: 80px; padding: 8px; background: var(--gray); border: 1px solid rgba(255, 215, 0, 0.3); border-radius: 8px; color: var(--white);">
                        </div>
                        <button type="submit" class="btn" style="width: 100%;">Добавить в корзину</button>
                    </form>
                @endif

                @auth
                    @if(Auth::user()->isAdmin())
                    <div style="display: flex; gap: 10px; width: 100%; margin-top: 15px;">
                        <a href="{{ route('medicines.edit', $medicine) }}" class="btn btn-secondary" style="flex: 1;">Редактировать</a>
                        <form action="{{ route('medicines.destroy', $medicine) }}" method="POST" style="flex: 1;" onsubmit="return confirm('Вы уверены, что хотите удалить это лекарство?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn" style="width: 100%; background: #ef4444; border-color: #ef4444;">Удалить</button>
                        </form>
                    </div>
                    @endif
                @endauth
            </div>
        </div>
    </div>
@endsection

<style>
    .back-button {
        display: inline-flex;
        align-items: center;
        gap: 10px;
        color: rgba(255, 255, 255, 0.6);
        text-decoration: none;
        margin-bottom: 40px;
        font-weight: 500;
        transition: all 0.3s ease;
    }

    .back-button:hover {
        color: var(--gold);
        transform: translateX(-5px);
    }

    .detail-layout {
        display: grid;
        grid-template-columns: 400px 1fr;
        gap: 60px;
        align-items: start;
    }

    .detail-visual {
        position: sticky;
        top: 100px;
    }

    .visual-box {
        width: 100%;
        aspect-ratio: 1;
        background: var(--gray);
        border: 2px solid rgba(255, 215, 0, 0.3);
        border-radius: 24px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 20px;
        overflow: hidden;
        position: relative;
    }

    .visual-box img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        display: block;
    }

    .visual-icon {
        width: 120px;
        height: 120px;
        opacity: 0.5;
    }

    .visual-badge {
        background: var(--gold);
        color: var(--black);
        padding: 12px 24px;
        border-radius: 12px;
        text-align: center;
        font-weight: 700;
        font-family: 'JetBrains Mono', monospace;
    }

    .detail-content {
        padding-top: 20px;
    }

    .detail-header {
        margin-bottom: 40px;
        padding-bottom: 30px;
        border-bottom: 1px solid rgba(255, 215, 0, 0.2);
    }

    .detail-category {
        display: inline-block;
        background: rgba(255, 215, 0, 0.1);
        color: var(--gold);
        padding: 6px 16px;
        border-radius: 20px;
        font-size: 0.8em;
        font-weight: 600;
        margin-bottom: 20px;
        font-family: 'JetBrains Mono', monospace;
    }

    .detail-content h1 {
        font-size: 3.5em;
        font-weight: 700;
        margin-bottom: 20px;
        line-height: 1.1;
    }

    .detail-manufacturer {
        font-size: 1.1em;
        color: rgba(255, 255, 255, 0.5);
        font-family: 'JetBrains Mono', monospace;
    }

    .detail-price-section {
        background: var(--gray);
        border: 2px solid rgba(255, 215, 0, 0.3);
        border-radius: 20px;
        padding: 40px;
        margin-bottom: 40px;
        text-align: center;
    }

    .price-main {
        font-size: 4em;
        font-weight: 700;
        color: var(--gold);
        font-family: 'JetBrains Mono', monospace;
        margin-bottom: 10px;
    }

    .price-label {
        color: rgba(255, 255, 255, 0.5);
        font-size: 0.9em;
    }

    .detail-section {
        margin-bottom: 40px;
    }

    .detail-section h3 {
        font-size: 1.5em;
        font-weight: 600;
        margin-bottom: 20px;
        color: var(--gold);
    }

    .detail-section p {
        color: rgba(255, 255, 255, 0.7);
        font-size: 1.1em;
        line-height: 1.8;
    }

    .detail-specs {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 20px;
        margin-bottom: 40px;
    }

    .spec-card {
        background: var(--gray);
        border: 1px solid rgba(255, 215, 0, 0.2);
        border-radius: 16px;
        padding: 25px;
        display: flex;
        align-items: center;
        gap: 20px;
        transition: all 0.3s ease;
    }

    .spec-card:hover {
        border-color: var(--gold);
        transform: translateY(-3px);
        box-shadow: 0 8px 25px rgba(255, 215, 0, 0.1);
    }

    .spec-icon-wrapper {
        width: 50px;
        height: 50px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: rgba(255, 215, 0, 0.1);
        border-radius: 12px;
        flex-shrink: 0;
    }

    .spec-content-wrapper {
        flex: 1;
    }

    .spec-label {
        font-size: 0.85em;
        color: rgba(255, 255, 255, 0.5);
        margin-bottom: 8px;
        font-family: 'JetBrains Mono', monospace;
    }

    .spec-value {
        font-size: 1.5em;
        font-weight: 700;
        color: var(--gold);
    }

    .detail-actions {
        display: flex;
        gap: 15px;
        flex-wrap: wrap;
        padding-top: 30px;
        border-top: 1px solid rgba(255, 215, 0, 0.2);
    }

    .detail-actions .btn {
        width: 100%;
        justify-content: center;
    }

    .expired-warning {
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 15px 20px;
        background: rgba(239, 68, 68, 0.15);
        border: 1px solid rgba(239, 68, 68, 0.3);
        border-radius: 12px;
        color: #ef4444;
        font-weight: 500;
        width: 100%;
    }

    @media (max-width: 968px) {
        .detail-layout {
            grid-template-columns: 1fr;
        }

        .detail-visual {
            position: static;
        }

        .detail-content h1 {
            font-size: 2.5em;
        }

        .detail-specs {
            grid-template-columns: 1fr;
        }
    }
</style>
