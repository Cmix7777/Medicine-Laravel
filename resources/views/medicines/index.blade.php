@extends('layouts.app')

@section('title', 'Каталог - PHARMA')

@section('content')
    <div class="catalog-header">
        <div>
            <h2>Каталог</h2>
            <div class="catalog-meta">
                <span class="meta-item">{{ $medicines->total() }} товаров</span>
                @if(request('category') || request('search'))
                    <a href="{{ route('medicines.index') }}" class="meta-link">Сбросить</a>
                @endif
            </div>
        </div>
    </div>
    
    @if(request('category') || request('search'))
        <div class="filter-badge">
            @if(request('category'))
                <span>Категория: {{ request('category') }}</span>
            @endif
            @if(request('search'))
                <span>Поиск: "{{ request('search') }}"</span>
            @endif
        </div>
    @endif

    @if($medicines->count() > 0)
        <div class="medicines-grid">
            @foreach($medicines as $index => $medicine)
                <div class="medicine-item" style="--index: {{ $index }}">
                    <div class="item-header">
                        <div class="item-badge">В наличии</div>
                        <div class="item-category">{{ $medicine->category ?? 'Без категории' }}</div>
                    </div>
                    <div class="item-body">
                        <h3><a href="{{ route('medicines.show', $medicine) }}" class="item-title-link">{{ $medicine->name }}</a></h3>
                        @if($medicine->description)
                            <p>{{ Str::limit($medicine->description, 100) }}</p>
                        @endif
                        <div class="item-meta">
                            <span>{{ $medicine->manufacturer ?? 'Не указан' }}</span>
                            <span>•</span>
                            <span>{{ $medicine->quantity }} шт.</span>
                        </div>
                    </div>
                    <div class="item-footer">
                        <div class="item-price">{{ number_format($medicine->price, 0) }} ₽</div>
                        <button class="item-buy-button">Купить</button>
                    </div>
                </div>
            @endforeach
        </div>
        
        <div class="pagination-wrapper">
            <div class="pagination-info">
                Показано {{ $medicines->firstItem() }}–{{ $medicines->lastItem() }} из {{ $medicines->total() }}
            </div>
            {{ $medicines->links('vendor.pagination.default') }}
        </div>
    @else
        <div class="empty-state">
            <div class="empty-icon">
                <svg width="80" height="80" viewBox="0 0 80 80" fill="none">
                    <circle cx="40" cy="40" r="30" stroke="currentColor" stroke-width="2" opacity="0.3"/>
                    <path d="M40 20V40M40 40L50 50" stroke="currentColor" stroke-width="2" stroke-linecap="round" opacity="0.3"/>
                </svg>
            </div>
            <h3>Ничего не найдено</h3>
            <p>Попробуйте изменить параметры поиска</p>
        </div>
    @endif
@endsection
