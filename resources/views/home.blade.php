@extends('layouts.app')

@section('title', 'Главная - PHARMA')

@section('content')
    <div class="hero-section">
        <div class="hero-text">
            <div class="hero-label">МЕДИЦИНА БУДУЩЕГО</div>
            <h1 class="hero-title">Здоровье<br>начинается здесь</h1>
            <p class="hero-description">Премиум препараты. Мгновенная доставка. Гарантия качества.</p>
            <div class="hero-cta">
                <a href="{{ route('medicines.index') }}" class="cta-primary">
                    <span>Смотреть каталог</span>
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none">
                        <path d="M5 12H19M19 12L12 5M19 12L12 19" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </a>
                <div class="hero-stats-mini">
                    <div><strong>{{ $featuredMedicines->count() }}+</strong> товаров</div>
                    <div><strong>24/7</strong> поддержка</div>
                </div>
            </div>
        </div>
        <div class="hero-visual">
            <div class="floating-card card-1">
                <svg width="48" height="48" viewBox="0 0 48 48" fill="none">
                    <rect width="48" height="48" rx="12" fill="var(--gold)" opacity="0.1"/>
                    <path d="M24 16L28 22H32L27 26L29 32L24 28L19 32L21 26L16 22H20L24 16Z" fill="var(--gold)"/>
                </svg>
                <div class="card-text">Премиум</div>
            </div>
            <div class="floating-card card-2">
                <svg width="48" height="48" viewBox="0 0 48 48" fill="none">
                    <rect width="48" height="48" rx="12" fill="var(--gold)" opacity="0.1"/>
                    <path d="M24 8L28 20L40 24L28 28L24 40L20 28L8 24L20 20L24 8Z" fill="var(--gold)"/>
                </svg>
                <div class="card-text">Быстро</div>
            </div>
            <div class="floating-card card-3">
                <svg width="48" height="48" viewBox="0 0 48 48" fill="none">
                    <rect width="48" height="48" rx="12" fill="var(--gold)" opacity="0.1"/>
                    <circle cx="24" cy="24" r="12" stroke="var(--gold)" stroke-width="3"/>
                    <path d="M18 24L22 28L30 20" stroke="var(--gold)" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
                <div class="card-text">Надежно</div>
            </div>
            <div class="floating-card card-4">
                <svg width="48" height="48" viewBox="0 0 48 48" fill="none">
                    <rect width="48" height="48" rx="12" fill="var(--gold)" opacity="0.1"/>
                    <path d="M24 8L28 20L40 24L28 28L24 40L20 28L8 24L20 20L24 8Z" fill="var(--gold)"/>
                </svg>
                <div class="card-text">Выгодно</div>
            </div>
        </div>
    </div>

    @if($categories->count() > 0)
    <section class="categories-section">
        <div class="section-title-wrapper">
            <h2 class="section-title">Категории</h2>
            <div class="title-underline"></div>
        </div>
        <div class="categories-masonry">
            @foreach($categories as $index => $category)
                <a href="{{ route('medicines.index') }}?category={{ urlencode($category->category) }}" class="category-brick" style="--delay: {{ $index * 0.1 }}s">
                    <div class="brick-number">{{ str_pad($index + 1, 2, '0', STR_PAD_LEFT) }}</div>
                    <div class="brick-content">
                        <div class="brick-title">{{ $category->category }}</div>
                        <div class="brick-count">{{ $category->total }} товаров</div>
                    </div>
                    <div class="brick-arrow">→</div>
                </a>
            @endforeach
        </div>
    </section>
    @endif

    @if($featuredMedicines->count() > 0)
    <section class="products-section">
        <div class="section-title-wrapper">
            <h2 class="section-title">Популярные</h2>
            <div class="title-underline"></div>
        </div>
        <div class="products-showcase">
            @foreach($featuredMedicines as $index => $medicine)
                <div class="product-tile" style="--index: {{ $index }}">
                    <div class="tile-image">
                        @if($medicine->image_url)
                            <img src="{{ $medicine->image_url }}" alt="{{ $medicine->name }}" onerror="this.src='https://via.placeholder.com/300x300/1a1a1a/FFD700?text=Medicine'">
                        @else
                            <img src="https://via.placeholder.com/300x300/1a1a1a/FFD700?text=Medicine" alt="{{ $medicine->name }}">
                        @endif
                    </div>
                    <div class="tile-header">
                        <div class="tile-badge">В наличии</div>
                        <div class="tile-category">{{ $medicine->category ?? 'Без категории' }}</div>
                    </div>
                    <div class="tile-body">
                        <h3 class="tile-name">{{ $medicine->name }}</h3>
                        @if($medicine->description)
                            <p class="tile-desc">{{ Str::limit($medicine->description, 70) }}</p>
                        @endif
                        <div class="tile-manufacturer">{{ $medicine->manufacturer ?? 'Производитель не указан' }}</div>
                    </div>
                    <div class="tile-footer">
                        <div class="tile-price">{{ number_format($medicine->price, 0) }} ₽</div>
                        <a href="{{ route('medicines.show', $medicine) }}" class="tile-link">
                            <span>Подробнее</span>
                            <svg width="16" height="16" viewBox="0 0 16 16" fill="none">
                                <path d="M6 12L10 8L6 4" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                        </a>
                    </div>
                </div>
            @endforeach
        </div>
        <div class="view-all-link">
            <a href="{{ route('medicines.index') }}">Смотреть все →</a>
        </div>
    </section>
    @endif

    <section class="features-section">
        <div class="features-grid">
            <div class="feature-block">
                <div class="feature-icon-svg">
                    <svg width="40" height="40" viewBox="0 0 40 40" fill="none">
                        <rect width="40" height="40" rx="8" fill="var(--gold)" opacity="0.1"/>
                        <path d="M20 12L25 18H30L26 22L28 28L20 24L12 28L14 22L10 18H15L20 12Z" fill="var(--gold)"/>
                    </svg>
                </div>
                <h3>Доставка</h3>
                <p>В течение 2 часов по городу</p>
            </div>
            <div class="feature-block">
                <div class="feature-icon-svg">
                    <svg width="40" height="40" viewBox="0 0 40 40" fill="none">
                        <rect width="40" height="40" rx="8" fill="var(--gold)" opacity="0.1"/>
                        <circle cx="20" cy="20" r="10" stroke="var(--gold)" stroke-width="2"/>
                        <path d="M15 20L18 23L25 16" stroke="var(--gold)" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </div>
                <h3>Качество</h3>
                <p>100% оригинальные препараты</p>
            </div>
            <div class="feature-block">
                <div class="feature-icon-svg">
                    <svg width="40" height="40" viewBox="0 0 40 40" fill="none">
                        <rect width="40" height="40" rx="8" fill="var(--gold)" opacity="0.1"/>
                        <path d="M20 8L24 16H32L26 20L28 28L20 24L12 28L14 20L8 16H16L20 8Z" fill="var(--gold)"/>
                    </svg>
                </div>
                <h3>Цены</h3>
                <p>Лучшие цены на рынке</p>
            </div>
            <div class="feature-block">
                <div class="feature-icon-svg">
                    <svg width="40" height="40" viewBox="0 0 40 40" fill="none">
                        <rect width="40" height="40" rx="8" fill="var(--gold)" opacity="0.1"/>
                        <circle cx="20" cy="15" r="5" stroke="var(--gold)" stroke-width="2"/>
                        <path d="M10 30C10 25.5817 14.4772 22 20 22C25.5228 22 30 25.5817 30 30" stroke="var(--gold)" stroke-width="2" stroke-linecap="round"/>
                    </svg>
                </div>
                <h3>Поддержка</h3>
                <p>Круглосуточная помощь</p>
            </div>
        </div>
    </section>
@endsection

<style>
    .hero-section {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 80px;
        align-items: center;
        padding: 80px 0;
        margin-bottom: 120px;
        position: relative;
    }

    .hero-label {
        font-family: 'JetBrains Mono', monospace;
        font-size: 0.85em;
        color: var(--gold);
        letter-spacing: 3px;
        margin-bottom: 30px;
        text-transform: uppercase;
    }

    .hero-title {
        font-size: 5.5em;
        font-weight: 700;
        line-height: 1;
        margin-bottom: 30px;
        background: linear-gradient(135deg, var(--white) 0%, var(--gold) 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }

    .hero-description {
        font-size: 1.3em;
        color: rgba(255, 255, 255, 0.7);
        margin-bottom: 50px;
        line-height: 1.6;
    }

    .hero-cta {
        display: flex;
        align-items: center;
        gap: 40px;
    }

    .cta-primary {
        display: inline-flex;
        align-items: center;
        gap: 12px;
        padding: 18px 40px;
        background: var(--gold);
        color: var(--black);
        text-decoration: none;
        font-weight: 600;
        font-size: 1.1em;
        border-radius: 12px;
        transition: all 0.3s ease;
    }

    .cta-primary:hover {
        transform: translateX(5px);
        box-shadow: 0 10px 40px rgba(255, 215, 0, 0.4);
    }

    .hero-stats-mini {
        display: flex;
        gap: 30px;
        font-size: 0.95em;
        color: rgba(255, 255, 255, 0.6);
    }

    .hero-stats-mini strong {
        color: var(--gold);
        font-weight: 700;
    }

    .hero-visual {
        position: relative;
        height: 500px;
    }

    .floating-card {
        position: absolute;
        width: 180px;
        height: 180px;
        background: var(--gray);
        border: 2px solid var(--gold);
        border-radius: 24px;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        gap: 15px;
        animation: float 6s ease-in-out infinite;
    }

    @keyframes float1 {
        0%, 100% { transform: translate(0, 0) rotate(0deg); }
        50% { transform: translate(15px, -15px) rotate(3deg); }
    }

    @keyframes float2 {
        0%, 100% { transform: translate(0, 0) rotate(0deg); }
        50% { transform: translate(-12px, 18px) rotate(-4deg); }
    }

    @keyframes float3 {
        0%, 100% { transform: translate(0, 0) rotate(0deg); }
        50% { transform: translate(10px, 12px) rotate(2deg); }
    }

    @keyframes float4 {
        0%, 100% { transform: translate(0, 0) rotate(0deg); }
        50% { transform: translate(-15px, -10px) rotate(-3deg); }
    }

    .card-1 {
        top: 0;
        left: 0;
        animation: float1 8s ease-in-out infinite;
    }

    .card-2 {
        top: 0;
        right: 0;
        animation: float2 7s ease-in-out infinite;
    }

    .card-3 {
        bottom: 0;
        left: 0;
        animation: float3 9s ease-in-out infinite;
    }

    .card-4 {
        bottom: 0;
        right: 0;
        animation: float4 8.5s ease-in-out infinite;
    }

    .card-icon {
        width: 48px;
        height: 48px;
    }

    .card-text {
        font-weight: 600;
        color: var(--gold);
        font-size: 1.1em;
    }

    .section-title-wrapper {
        margin-bottom: 60px;
        position: relative;
    }

    .section-title {
        font-size: 4em;
        font-weight: 700;
        margin-bottom: 15px;
        position: relative;
        display: inline-block;
    }

    .title-underline {
        width: 100px;
        height: 4px;
        background: var(--gold);
        margin-top: 10px;
    }

    .categories-masonry {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
        gap: 20px;
        margin-bottom: 80px;
    }

    .category-brick {
        background: var(--gray);
        border: 1px solid rgba(255, 215, 0, 0.2);
        border-radius: 16px;
        padding: 30px;
        display: flex;
        align-items: center;
        gap: 20px;
        text-decoration: none;
        color: var(--white);
        transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        position: relative;
        overflow: hidden;
        animation: slideIn 0.6s ease backwards;
        animation-delay: var(--delay);
    }

    @keyframes slideIn {
        from {
            opacity: 0;
            transform: translateX(-30px);
        }
        to {
            opacity: 1;
            transform: translateX(0);
        }
    }

    .category-brick::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255, 215, 0, 0.1), transparent);
        transition: left 0.5s ease;
    }

    .category-brick:hover::before {
        left: 100%;
    }

    .category-brick:hover {
        border-color: var(--gold);
        transform: translateY(-5px) scale(1.02);
        box-shadow: 0 15px 40px rgba(255, 215, 0, 0.2);
    }

    .brick-number {
        font-family: 'JetBrains Mono', monospace;
        font-size: 2em;
        font-weight: 700;
        color: var(--gold);
        opacity: 0.5;
    }

    .brick-content {
        flex: 1;
    }

    .brick-title {
        font-size: 1.3em;
        font-weight: 600;
        margin-bottom: 5px;
        word-break: break-word;
        hyphens: auto;
        line-height: 1.3;
    }

    .brick-count {
        font-size: 0.85em;
        color: rgba(255, 255, 255, 0.5);
    }

    .brick-arrow {
        font-size: 1.5em;
        color: var(--gold);
        opacity: 0;
        transform: translateX(-10px);
        transition: all 0.3s ease;
    }

    .category-brick:hover .brick-arrow {
        opacity: 1;
        transform: translateX(0);
    }

    .products-showcase {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
        gap: 30px;
        margin-bottom: 60px;
    }

    .product-tile {
        background: var(--gray);
        border: 1px solid rgba(255, 215, 0, 0.2);
        border-radius: 20px;
        padding: 35px;
        display: flex;
        flex-direction: column;
        transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        position: relative;
        overflow: hidden;
        animation: fadeInUp 0.6s ease backwards;
        animation-delay: calc(var(--index) * 0.1s);
    }

    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(30px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .product-tile::after {
        content: '';
        position: absolute;
        top: -50%;
        right: -50%;
        width: 200%;
        height: 200%;
        background: radial-gradient(circle, rgba(255, 215, 0, 0.1) 0%, transparent 70%);
        opacity: 0;
        transition: opacity 0.3s ease;
    }

    .product-tile:hover::after {
        opacity: 1;
    }

    .product-tile:hover {
        border-color: var(--gold);
        transform: translateY(-8px);
        box-shadow: 0 20px 60px rgba(255, 215, 0, 0.15);
    }

    .tile-image {
        width: 100%;
        height: 200px;
        margin-bottom: 20px;
        border-radius: 12px;
        overflow: hidden;
        background: var(--black);
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .tile-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.3s ease;
    }

    .product-tile:hover .tile-image img {
        transform: scale(1.05);
    }

    .tile-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 25px;
    }

    .tile-badge {
        background: var(--gold);
        color: var(--black);
        padding: 6px 14px;
        border-radius: 20px;
        font-size: 0.75em;
        font-weight: 700;
        font-family: 'JetBrains Mono', monospace;
    }

    .tile-category {
        font-size: 0.8em;
        color: rgba(255, 255, 255, 0.5);
        font-family: 'JetBrains Mono', monospace;
    }

    .tile-body {
        flex-grow: 1;
        margin-bottom: 25px;
    }

    .tile-name {
        font-size: 1.8em;
        font-weight: 700;
        margin-bottom: 15px;
        line-height: 1.2;
    }

    .tile-desc {
        color: rgba(255, 255, 255, 0.6);
        font-size: 0.95em;
        line-height: 1.6;
        margin-bottom: 15px;
    }

    .tile-manufacturer {
        font-size: 0.85em;
        color: rgba(255, 255, 255, 0.4);
        font-family: 'JetBrains Mono', monospace;
    }

    .tile-footer {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding-top: 25px;
        border-top: 1px solid rgba(255, 215, 0, 0.2);
    }

    .tile-price {
        font-size: 2.5em;
        font-weight: 700;
        color: var(--gold);
        font-family: 'JetBrains Mono', monospace;
    }

    .tile-link {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        color: var(--gold);
        font-weight: 600;
        text-decoration: none;
        transition: all 0.3s ease;
    }

    .tile-link:hover {
        gap: 12px;
        color: var(--gold-dark);
    }

    .view-all-link {
        text-align: center;
        margin-top: 60px;
    }

    .view-all-link a {
        font-size: 1.2em;
        font-weight: 600;
        color: var(--gold);
        text-decoration: none;
        transition: all 0.3s ease;
    }

    .view-all-link a:hover {
        letter-spacing: 2px;
    }

    .features-section {
        margin-top: 120px;
        padding: 80px 0;
        border-top: 1px solid rgba(255, 215, 0, 0.2);
    }

    .features-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 30px;
    }

    .feature-block {
        text-align: center;
        padding: 40px 20px;
        position: relative;
    }

    .feature-icon-svg {
        display: inline-flex;
        margin-bottom: 20px;
    }

    .feature-block h3 {
        font-size: 1.4em;
        font-weight: 600;
        margin-bottom: 10px;
    }

    .feature-block p {
        color: rgba(255, 255, 255, 0.6);
        font-size: 0.95em;
    }

    @media (max-width: 1200px) {
        .hero-section {
            grid-template-columns: 1fr;
            gap: 60px;
        }

        .hero-title {
            font-size: 4em;
        }

        .products-showcase {
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
        }

        .features-grid {
            grid-template-columns: repeat(2, 1fr);
        }
    }

    @media (max-width: 768px) {
        .hero-title {
            font-size: 3em;
        }

        .section-title {
            font-size: 2.5em;
        }

        .products-showcase {
            grid-template-columns: 1fr;
        }

        .features-grid {
            grid-template-columns: 1fr;
        }
    }
</style>
