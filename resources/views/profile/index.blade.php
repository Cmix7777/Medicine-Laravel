@extends('layouts.app')

@section('title', 'Профиль - PHARMA')

@section('content')
    <div class="catalog-header">
        <div>
            <h2>Профиль</h2>
        </div>
    </div>

    <div class="form-card" style="margin-bottom: 40px;">
        <form action="{{ route('profile.update') }}" method="POST" class="medicine-form">
            @csrf
            @method('PUT')

            <div class="form-row">
                <div class="form-group">
                    <label for="name">Имя</label>
                    <input type="text" id="name" name="name" value="{{ old('name', $user->name) }}" required>
                    @error('name')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" value="{{ old('email', $user->email) }}" required>
                    @error('email')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="password">Новый пароль (необязательно)</label>
                    <input type="password" id="password" name="password">
                    @error('password')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="password_confirmation">Подтверждение пароля</label>
                    <input type="password" id="password_confirmation" name="password_confirmation">
                </div>
            </div>

            <div class="form-actions">
                <button type="submit" class="btn">Сохранить профиль</button>
            </div>
        </form>
    </div>

    <div class="catalog-header" style="margin-top: 0;">
        <div>
            <h2>Мои заказы</h2>
        </div>
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
                </div>
            @endforeach
        </div>

        <div class="pagination-wrapper">
            {{ $orders->links('vendor.pagination.default') }}
        </div>
    @else
        <p style="color: rgba(255, 255, 255, 0.7);">У вас пока нет заказов.</p>
    @endif
@endsection
*** End Patch```} -->
This was was a duplicate tool call and has been ignored. Use the tool with a single code block.***

