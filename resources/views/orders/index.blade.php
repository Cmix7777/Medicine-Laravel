@extends('layouts.app')

@section('title', 'Мои заказы - PHARMA')

@section('content')
    <div class="catalog-header">
        <h2>Мои заказы</h2>
    </div>

    @if($orders->count() > 0)
        <div class="orders-list">
            @foreach($orders as $order)
                <div class="order-card">
                    <div class="order-header">
                        <div>
                            <h3>Заказ #{{ $order->id }}</h3>
                            <div class="order-meta">
                                <span>{{ $order->created_at->format('d.m.Y H:i') }}</span>
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
                        <div class="order-total">
                            {{ number_format($order->total_amount, 0) }} ₽
                        </div>
                    </div>
                    <div class="order-items">
                        @foreach($order->items as $item)
                            <div class="order-item">
                                <span>{{ $item->medicine->name }}</span>
                                <span>{{ $item->quantity }} × {{ number_format($item->price, 0) }} ₽ = {{ number_format($item->quantity * $item->price, 0) }} ₽</span>
                            </div>
                        @endforeach
                    </div>
                    <div class="order-footer">
                        <a href="{{ route('orders.show', $order) }}" class="btn btn-secondary">Подробнее</a>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="pagination-wrapper">
            {{ $orders->links('vendor.pagination.default') }}
        </div>
    @else
        <div class="empty-state">
            <div class="empty-icon">
                <svg width="80" height="80" viewBox="0 0 80 80" fill="none">
                    <circle cx="40" cy="40" r="30" stroke="currentColor" stroke-width="2" opacity="0.3"/>
                    <path d="M40 20V40M40 40L50 50" stroke="currentColor" stroke-width="2" stroke-linecap="round" opacity="0.3"/>
                </svg>
            </div>
            <h3>У вас пока нет заказов</h3>
            <p>Оформите заказ из корзины</p>
            <a href="{{ route('cart.index') }}" class="btn" style="margin-top: 20px;">Перейти в корзину</a>
        </div>
    @endif
@endsection

<style>
    .orders-list {
        display: flex;
        flex-direction: column;
        gap: 20px;
    }

    .order-card {
        background: var(--gray);
        border: 1px solid rgba(255, 215, 0, 0.2);
        border-radius: 16px;
        padding: 25px;
    }

    .order-header {
        display: flex;
        justify-content: space-between;
        align-items: start;
        margin-bottom: 20px;
        padding-bottom: 20px;
        border-bottom: 1px solid rgba(255, 215, 0, 0.2);
    }

    .order-header h3 {
        font-size: 1.5em;
        margin-bottom: 10px;
    }

    .order-meta {
        display: flex;
        gap: 10px;
        color: rgba(255, 255, 255, 0.6);
        font-size: 0.9em;
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

    .order-total {
        font-size: 2em;
        font-weight: 700;
        color: var(--gold);
        font-family: 'JetBrains Mono', monospace;
    }

    .order-items {
        margin-bottom: 20px;
    }

    .order-item {
        display: flex;
        justify-content: space-between;
        padding: 10px 0;
        border-bottom: 1px solid rgba(255, 215, 0, 0.1);
    }

    .order-item:last-child {
        border-bottom: none;
    }

    .order-footer {
        padding-top: 20px;
        border-top: 1px solid rgba(255, 215, 0, 0.2);
    }
</style>

