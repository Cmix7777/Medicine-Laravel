@extends('layouts.app')

@section('title', 'Заказ #' . $order->id . ' - PHARMA')

@section('content')
    <a href="{{ route('orders.index') }}" class="back-button">
        <svg width="20" height="20" viewBox="0 0 20 20" fill="none">
            <path d="M12.5 15L7.5 10L12.5 5" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
        </svg>
        Назад к заказам
    </a>

    <div class="order-detail">
        <div class="order-detail-header">
            <div>
                <h1>Заказ #{{ $order->id }}</h1>
                <div class="order-detail-meta">
                    <span>Дата: {{ $order->created_at->format('d.m.Y H:i') }}</span>
                    <span>•</span>
                    <span class="order-status order-status-{{ $order->status }}">
                        @if($order->status == 'pending')
                            В обработке
                        @elseif($order->status == 'completed')
                            Выполнен
                        @else
                            Отменен
                        @endif
                    </span>
                </div>
            </div>
            <div class="order-detail-total">
                <div class="total-label">Итого</div>
                <div class="total-amount">{{ number_format($order->total_amount, 0) }} ₽</div>
            </div>
        </div>

        <div class="order-detail-items">
            <h2>Товары в заказе</h2>
            @foreach($order->items as $item)
                <div class="order-detail-item">
                    <div class="item-info">
                        <h3><a href="{{ route('medicines.show', $item->medicine) }}">{{ $item->medicine->name }}</a></h3>
                        <div class="item-meta">
                            <span>{{ $item->medicine->manufacturer ?? 'Производитель не указан' }}</span>
                        </div>
                    </div>
                    <div class="item-quantity">
                        {{ $item->quantity }} шт.
                    </div>
                    <div class="item-price">
                        {{ number_format($item->price, 0) }} ₽
                    </div>
                    <div class="item-subtotal">
                        {{ number_format($item->quantity * $item->price, 0) }} ₽
                    </div>
                </div>
            @endforeach
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

    .order-detail {
        background: var(--gray);
        border: 1px solid rgba(255, 215, 0, 0.2);
        border-radius: 20px;
        padding: 40px;
    }

    .order-detail-header {
        display: flex;
        justify-content: space-between;
        align-items: start;
        margin-bottom: 40px;
        padding-bottom: 30px;
        border-bottom: 1px solid rgba(255, 215, 0, 0.2);
    }

    .order-detail-header h1 {
        font-size: 3em;
        margin-bottom: 15px;
    }

    .order-detail-meta {
        display: flex;
        gap: 10px;
        color: rgba(255, 255, 255, 0.6);
        font-size: 0.95em;
    }

    .order-status {
        font-weight: 600;
        padding: 4px 12px;
        border-radius: 12px;
        font-size: 0.85em;
    }

    .order-status-pending {
        background: rgba(251, 191, 36, 0.2);
        color: #fbbf24;
    }

    .order-status-completed {
        background: rgba(34, 197, 94, 0.2);
        color: #22c55e;
    }

    .order-status-cancelled {
        background: rgba(239, 68, 68, 0.2);
        color: #ef4444;
    }

    .order-detail-total {
        text-align: right;
    }

    .total-label {
        font-size: 0.9em;
        color: rgba(255, 255, 255, 0.6);
        margin-bottom: 10px;
    }

    .total-amount {
        font-size: 3em;
        font-weight: 700;
        color: var(--gold);
        font-family: 'JetBrains Mono', monospace;
    }

    .order-detail-items h2 {
        font-size: 2em;
        margin-bottom: 30px;
    }

    .order-detail-item {
        display: grid;
        grid-template-columns: 2fr 1fr 1fr 1fr;
        gap: 20px;
        padding: 25px;
        background: var(--black);
        border: 1px solid rgba(255, 215, 0, 0.1);
        border-radius: 12px;
        margin-bottom: 15px;
        align-items: center;
    }

    .order-detail-item h3 {
        font-size: 1.3em;
        margin-bottom: 8px;
    }

    .order-detail-item h3 a {
        color: inherit;
        text-decoration: none;
    }

    .order-detail-item h3 a:hover {
        color: var(--gold);
    }

    .item-meta {
        font-size: 0.85em;
        color: rgba(255, 255, 255, 0.5);
    }

    .item-quantity,
    .item-price,
    .item-subtotal {
        text-align: center;
        font-size: 1.1em;
        font-weight: 600;
    }

    .item-subtotal {
        color: var(--gold);
        font-family: 'JetBrains Mono', monospace;
    }

    @media (max-width: 968px) {
        .order-detail-header {
            flex-direction: column;
            gap: 20px;
        }

        .order-detail-item {
            grid-template-columns: 1fr;
            gap: 15px;
        }

        .item-quantity,
        .item-price,
        .item-subtotal {
            text-align: left;
        }
    }
</style>

