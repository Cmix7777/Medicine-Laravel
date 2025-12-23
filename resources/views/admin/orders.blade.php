@extends('layouts.app')

@section('title', 'Заказы - Админ-панель')

@section('content')
<div class="admin-container">
    <div class="admin-header">
        <h1 class="admin-title">Все заказы</h1>
        <a href="{{ route('admin.dashboard') }}" class="back-link">← Назад к панели</a>
    </div>
    
    @if($orders->count() > 0)
        <div class="orders-table-wrapper">
            <table class="orders-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Пользователь</th>
                        <th>Дата</th>
                        <th>Сумма</th>
                        <th>Статус</th>
                        <th>Действия</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($orders as $order)
                    <tr>
                        <td>#{{ $order->id }}</td>
                        <td>{{ $order->user->name }}<br><small>{{ $order->user->email }}</small></td>
                        <td>{{ $order->created_at->format('d.m.Y H:i') }}</td>
                        <td class="order-amount">{{ number_format($order->total_amount, 0) }} ₽</td>
                        <td>
                            <span class="order-status order-status-{{ $order->status }}">
                                @if($order->status == 'pending')
                                    В обработке
                                @elseif($order->status == 'completed')
                                    Выполнен
                                @else
                                    Отменен
                                @endif
                            </span>
                        </td>
                        <td>
                            <a href="{{ route('orders.show', $order) }}" class="view-link">Просмотр</a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        
        <div class="pagination-wrapper">
            {{ $orders->links() }}
        </div>
    @else
        <div class="empty-state">
            <p>Заказов пока нет</p>
        </div>
    @endif
</div>

<style>
.admin-container {
    max-width: 1400px;
    margin: 0 auto;
    padding: 40px 20px;
}

.admin-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 30px;
}

.admin-title {
    font-size: 2.5em;
    font-weight: 700;
    color: var(--gold);
}

.back-link {
    color: var(--gold);
    text-decoration: none;
    font-weight: 600;
    transition: all 0.3s ease;
}

.back-link:hover {
    opacity: 0.7;
}

.orders-table-wrapper {
    background: var(--gray);
    border: 2px solid rgba(255, 215, 0, 0.2);
    border-radius: 16px;
    overflow: hidden;
    margin-bottom: 30px;
}

.orders-table {
    width: 100%;
    border-collapse: collapse;
}

.orders-table thead {
    background: rgba(255, 215, 0, 0.1);
}

.orders-table th {
    padding: 20px;
    text-align: left;
    font-weight: 600;
    color: var(--gold);
    border-bottom: 2px solid rgba(255, 215, 0, 0.2);
}

.orders-table td {
    padding: 20px;
    border-bottom: 1px solid rgba(255, 215, 0, 0.1);
    color: var(--white);
}

.orders-table tbody tr:hover {
    background: rgba(255, 215, 0, 0.05);
}

.orders-table small {
    color: rgba(255, 255, 255, 0.5);
    font-size: 0.85em;
}

.order-amount {
    font-weight: 600;
    color: var(--gold);
    font-family: 'JetBrains Mono', monospace;
}

.order-status {
    display: inline-block;
    padding: 6px 12px;
    border-radius: 20px;
    font-size: 0.85em;
    font-weight: 600;
    font-family: 'JetBrains Mono', monospace;
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

.view-link {
    color: var(--gold);
    text-decoration: none;
    font-weight: 600;
    transition: all 0.3s ease;
}

.view-link:hover {
    opacity: 0.7;
    text-decoration: underline;
}

.empty-state {
    text-align: center;
    padding: 60px 20px;
    color: rgba(255, 255, 255, 0.6);
}

.pagination-wrapper {
    display: flex;
    justify-content: center;
}

@media (max-width: 768px) {
    .admin-header {
        flex-direction: column;
        align-items: flex-start;
        gap: 20px;
    }
    
    .admin-title {
        font-size: 1.8em;
    }
    
    .orders-table-wrapper {
        overflow-x: auto;
    }
    
    .orders-table {
        min-width: 800px;
    }
}
</style>
@endsection

