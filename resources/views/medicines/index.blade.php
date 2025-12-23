@extends('layouts.app')

@section('title', 'Каталог - PHARMA')

@section('content')
    <div class="catalog-header">
        <div>
            <h2>Каталог</h2>
            <div class="catalog-meta">
                <span class="meta-item">{{ $medicines->total() }} товаров</span>
                @if(request()->anyFilled(['category', 'search', 'price_min', 'price_max', 'sort_by']))
                    <a href="{{ route('medicines.index') }}" class="meta-link">Сбросить</a>
                @endif
            </div>
        </div>
    </div>

    @php
        $defaultMin = 0;
        $defaultMax = 10000;
        $defaultSortBy = 'created_at';
        $defaultSortOrder = 'desc';

        $hasFilters =
            (request('category')) ||
            (request('search')) ||
            (request()->filled('price_min') && request('price_min') != $defaultMin) ||
            (request()->filled('price_max') && request('price_max') != $defaultMax) ||
            (request('sort_by') && request('sort_by') !== $defaultSortBy) ||
            (request('sort_order') && request('sort_order') !== $defaultSortOrder);
    @endphp

    <!-- Фильтры и сортировка -->
    <div class="filters-section">
        <form method="GET" action="{{ route('medicines.index') }}" class="filters-form">
            <div class="filters-row">
                <div class="filter-group">
                    <label>Цена от:</label>
                    <input type="number" name="price_min" value="{{ request('price_min', $defaultMin) }}" min="0" step="0.01">
                </div>
                <div class="filter-group">
                    <label>Цена до:</label>
                    <input type="number" name="price_max" value="{{ request('price_max', $defaultMax) }}" min="0" step="0.01">
                </div>
                <div class="filter-group">
                    <label>Сортировка:</label>
                    <select name="sort_by">
                        <option value="created_at" {{ request('sort_by', $defaultSortBy) == 'created_at' ? 'selected' : '' }}>По дате</option>
                        <option value="name" {{ request('sort_by') == 'name' ? 'selected' : '' }}>По названию</option>
                        <option value="price" {{ request('sort_by') == 'price' ? 'selected' : '' }}>По цене</option>
                        <option value="expiry_date" {{ request('sort_by') == 'expiry_date' ? 'selected' : '' }}>По сроку годности</option>
                    </select>
                </div>
                <div class="filter-group">
                    <label>Порядок:</label>
                    <select name="sort_order">
                        <option value="asc" {{ request('sort_order') == 'asc' ? 'selected' : '' }}>По возрастанию</option>
                        <option value="desc" {{ request('sort_order', $defaultSortOrder) == 'desc' ? 'selected' : '' }}>По убыванию</option>
                    </select>
                </div>
                @if(request('category'))
                    <input type="hidden" name="category" value="{{ request('category') }}">
                @endif
                @if(request('search'))
                    <input type="hidden" name="search" value="{{ request('search') }}">
                @endif
                <button type="submit" class="btn-filter">Применить</button>
            </div>
        </form>
    </div>
    
    @if($hasFilters)
        <div class="filter-badge">
            @if(request('category'))
                <span>Категория: {{ request('category') }}</span>
            @endif
            @if(request('search'))
                <span>Поиск: "{{ request('search') }}"</span>
            @endif
            @if(request()->filled('price_min') && request('price_min') != $defaultMin)
                <span>Цена от: {{ number_format(request('price_min'), 0) }}₽</span>
            @endif
            @if(request()->filled('price_max') && request('price_max') != $defaultMax)
                <span>Цена до: {{ number_format(request('price_max'), 0) }}₽</span>
            @endif
            @if(request('sort_by') && request('sort_by') !== $defaultSortBy)
                <span>Сортировка: 
                    @if(request('sort_by') === 'name') По названию
                    @elseif(request('sort_by') === 'price') По цене
                    @elseif(request('sort_by') === 'expiry_date') По сроку годности
                    @else По дате
                    @endif
                </span>
            @endif
            @if(request('sort_order') && request('sort_order') !== $defaultSortOrder)
                <span>Порядок: {{ request('sort_order') === 'asc' ? 'По возрастанию' : 'По убыванию' }}</span>
            @endif
        </div>
    @endif

    @if($medicines->count() > 0)
        <div class="medicines-grid">
            @foreach($medicines as $index => $medicine)
                <div class="medicine-item" style="--index: {{ $index }}">
                    <div class="item-image">
                        @if($medicine->image_url)
                            <img src="{{ $medicine->image_url }}" alt="{{ $medicine->name }}" onerror="this.src='https://via.placeholder.com/300x300/1a1a1a/FFD700?text=Medicine'">
                        @else
                            <img src="https://via.placeholder.com/300x300/1a1a1a/FFD700?text=Medicine" alt="{{ $medicine->name }}">
                        @endif
                    </div>
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
                        <form action="{{ route('cart.add', $medicine) }}" method="POST" style="display: inline;">
                            @csrf
                            <input type="hidden" name="quantity" value="1">
                            <button type="submit" class="item-buy-button" 
                                @if($medicine->quantity <= 0 || ($medicine->expiry_date && $medicine->expiry_date->isPast())) 
                                    disabled 
                                    title="{{ $medicine->quantity <= 0 ? 'Нет в наличии' : 'Истек срок годности' }}"
                                @endif>
                                Купить
                            </button>
                        </form>
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
