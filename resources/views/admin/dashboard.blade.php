@extends('layouts.app')

@section('title', 'Админ-панель - PHARMA')

@section('content')
<div class="admin-container">
    <h1 class="admin-title">Админ-панель</h1>
    
    <div class="admin-stats">
        <div class="stat-card">
            <div class="stat-icon">👥</div>
            <div class="stat-content">
                <div class="stat-value">{{ $usersCount }}</div>
                <div class="stat-label">Пользователей</div>
            </div>
        </div>
        
        <div class="stat-card">
            <div class="stat-icon">💊</div>
            <div class="stat-content">
                <div class="stat-value">{{ $medicinesCount }}</div>
                <div class="stat-label">Лекарств</div>
            </div>
        </div>
        
        <div class="stat-card">
            <div class="stat-icon">📦</div>
            <div class="stat-content">
                <div class="stat-value">{{ $ordersCount }}</div>
                <div class="stat-label">Заказов</div>
            </div>
        </div>
    </div>
    
    <div class="admin-actions">
        <a href="{{ route('admin.users') }}" class="admin-btn">
            <span>Управление пользователями</span>
            <svg width="20" height="20" viewBox="0 0 20 20" fill="none">
                <path d="M7 5L12 10L7 15" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
        </a>
        
        <a href="{{ route('medicines.index') }}" class="admin-btn">
            <span>Управление лекарствами</span>
            <svg width="20" height="20" viewBox="0 0 20 20" fill="none">
                <path d="M7 5L12 10L7 15" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
        </a>
        
        <a href="{{ route('admin.orders') }}" class="admin-btn">
            <span>Просмотр заказов</span>
            <svg width="20" height="20" viewBox="0 0 20 20" fill="none">
                <path d="M7 5L12 10L7 15" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
        </a>
    </div>
</div>

<style>
.admin-container {
    max-width: 1200px;
    margin: 0 auto;
    padding: 40px 20px;
}

.admin-title {
    font-size: 3em;
    font-weight: 700;
    margin-bottom: 40px;
    color: var(--gold);
}

.admin-stats {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 30px;
    margin-bottom: 50px;
}

.stat-card {
    background: var(--gray);
    border: 2px solid rgba(255, 215, 0, 0.2);
    border-radius: 16px;
    padding: 30px;
    display: flex;
    align-items: center;
    gap: 20px;
    transition: all 0.3s ease;
}

.stat-card:hover {
    border-color: var(--gold);
    transform: translateY(-5px);
    box-shadow: 0 10px 30px rgba(255, 215, 0, 0.2);
}

.stat-icon {
    font-size: 3em;
}

.stat-content {
    flex: 1;
}

.stat-value {
    font-size: 2.5em;
    font-weight: 700;
    color: var(--gold);
    margin-bottom: 5px;
}

.stat-label {
    font-size: 1em;
    color: rgba(255, 255, 255, 0.7);
}

.admin-actions {
    display: flex;
    flex-direction: column;
    gap: 20px;
}

.admin-btn {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 20px 30px;
    background: var(--gray);
    border: 2px solid rgba(255, 215, 0, 0.2);
    border-radius: 12px;
    color: var(--white);
    text-decoration: none;
    font-size: 1.1em;
    font-weight: 600;
    transition: all 0.3s ease;
}

.admin-btn:hover {
    border-color: var(--gold);
    background: rgba(255, 215, 0, 0.1);
    transform: translateX(5px);
}

.admin-btn svg {
    color: var(--gold);
}

@media (max-width: 768px) {
    .admin-title {
        font-size: 2em;
    }
    
    .admin-stats {
        grid-template-columns: 1fr;
    }
}
</style>
@endsection

