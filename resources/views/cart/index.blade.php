@extends('layouts.app')

@section('title', 'Корзина - PHARMA')

@section('content')
    <div class="catalog-header">
        <h2>Корзина</h2>
    </div>

    @if(count($items) > 0)
        <div class="cart-items">
            @foreach($items as $item)
                <div class="cart-item">
                    <div class="cart-item-info">
                        <h3><a href="{{ route('medicines.show', $item['medicine']) }}">{{ $item['medicine']->name }}</a></h3>
                        <div class="cart-item-meta">
                            <span>{{ number_format($item['medicine']->price, 0) }} ₽ × {{ $item['quantity'] }}</span>
                            @if($item['isExpired'])
                                <span style="color: #ef4444;">⚠ Истек срок годности</span>
                            @endif
                        </div>
                    </div>
                    <div class="cart-item-actions">
                        <form action="{{ route('cart.update', $item['medicine']) }}" method="POST" style="display: inline-flex; gap: 10px; align-items: center;">
                            @csrf
                            @method('PUT')
                            <input type="number" name="quantity" value="{{ $item['quantity'] }}" min="1" max="{{ $item['medicine']->quantity }}" 
                                style="width: 80px; padding: 8px; background: var(--gray); border: 1px solid rgba(255, 215, 0, 0.3); border-radius: 8px; color: var(--white);">
                            <button type="submit" class="btn btn-secondary" style="padding: 8px 16px;">Обновить</button>
                        </form>
                        <form action="{{ route('cart.remove', $item['medicine']) }}" method="POST" style="display: inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn" style="background: #ef4444; border-color: #ef4444; padding: 8px 16px;">Удалить</button>
                        </form>
                    </div>
                    <div class="cart-item-price">
                        {{ number_format($item['subtotal'], 0) }} ₽
                    </div>
                </div>
            @endforeach
        </div>

        <div class="cart-summary">
            <div class="summary-row">
                <span>Итого:</span>
                <span class="summary-total">{{ number_format($total, 0) }} ₽</span>
            </div>
            @auth
                <form action="{{ route('orders.store') }}" method="POST">
                    @csrf
                    <button type="submit" class="btn" style="width: 100%; margin-top: 20px; padding: 15px;">Оформить заказ</button>
                </form>
            @else
                <p style="text-align: center; margin-top: 20px; color: rgba(255, 255, 255, 0.7);">
                    <a href="{{ route('login') }}" style="color: var(--gold);">Войдите</a> для оформления заказа
                </p>
            @endauth
            <form action="{{ route('cart.clear') }}" method="POST" style="margin-top: 10px;">
                @csrf
                <button type="submit" class="btn btn-secondary" style="width: 100%;" onclick="return confirm('Очистить корзину?');">Очистить корзину</button>
            </form>
        </div>
    @else
        <div class="empty-state">
            <div class="empty-icon">
                <svg width="80" height="80" viewBox="0 0 80 80" fill="none">
                    <circle cx="40" cy="40" r="30" stroke="currentColor" stroke-width="2" opacity="0.3"/>
                    <path d="M40 20V40M40 40L50 50" stroke="currentColor" stroke-width="2" stroke-linecap="round" opacity="0.3"/>
                </svg>
            </div>
            <h3>Корзина пуста</h3>
            <p>Добавьте товары из каталога</p>
            <a href="{{ route('medicines.index') }}" class="btn" style="margin-top: 20px;">Перейти в каталог</a>
        </div>
    @endif
@endsection

<style>
    .cart-items {
        display: flex;
        flex-direction: column;
        gap: 20px;
        margin-bottom: 40px;
    }

    .cart-item {
        background: var(--gray);
        border: 1px solid rgba(255, 215, 0, 0.2);
        border-radius: 16px;
        padding: 25px;
        display: grid;
        grid-template-columns: 1fr auto auto;
        gap: 30px;
        align-items: center;
    }

    .cart-item-info h3 {
        font-size: 1.5em;
        margin-bottom: 10px;
    }

    .cart-item-info h3 a {
        color: inherit;
        text-decoration: none;
    }

    .cart-item-info h3 a:hover {
        color: var(--gold);
    }

    .cart-item-meta {
        display: flex;
        gap: 15px;
        color: rgba(255, 255, 255, 0.6);
        font-size: 0.9em;
    }

    .cart-item-actions {
        display: flex;
        gap: 10px;
        align-items: center;
    }

    .cart-item-price {
        font-size: 2em;
        font-weight: 700;
        color: var(--gold);
        font-family: 'JetBrains Mono', monospace;
    }

    .cart-summary {
        background: var(--gray);
        border: 1px solid rgba(255, 215, 0, 0.3);
        border-radius: 16px;
        padding: 30px;
        max-width: 500px;
        margin-left: auto;
    }

    .summary-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        font-size: 1.5em;
        padding-bottom: 20px;
        border-bottom: 1px solid rgba(255, 215, 0, 0.2);
    }

    .summary-total {
        font-size: 2em;
        font-weight: 700;
        color: var(--gold);
        font-family: 'JetBrains Mono', monospace;
    }

    @media (max-width: 768px) {
        .cart-item {
            grid-template-columns: 1fr;
            gap: 20px;
        }

        .cart-item-actions {
            flex-direction: column;
        }

        .cart-item-price {
            text-align: center;
        }
    }
</style>

