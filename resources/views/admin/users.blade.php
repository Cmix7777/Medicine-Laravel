@extends('layouts.app')

@section('title', 'Пользователи - Админ-панель')

@section('content')
<div class="admin-container">
    <div class="admin-header">
        <h1 class="admin-title">Управление пользователями</h1>
        <a href="{{ route('admin.dashboard') }}" class="back-link">← Назад к панели</a>
    </div>
    
    <div class="users-table-wrapper">
        <table class="users-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Имя</th>
                    <th>Email</th>
                    <th>Роль</th>
                    <th>Дата регистрации</th>
                    <th>Действия</th>
                </tr>
            </thead>
            <tbody>
                @foreach($users as $user)
                <tr>
                    <td>{{ $user->id }}</td>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>
                        <span class="role-badge role-{{ $user->role }}">
                            {{ $user->role == 2 ? 'Администратор' : 'Пользователь' }}
                        </span>
                    </td>
                    <td>{{ $user->created_at->format('d.m.Y') }}</td>
                    <td>
                        <form action="{{ route('admin.users.updateRole', $user) }}" method="POST" class="role-form">
                            @csrf
                            @method('PUT')
                            <select name="role" class="role-select" onchange="this.form.submit()">
                                <option value="1" {{ $user->role == 1 ? 'selected' : '' }}>Пользователь</option>
                                <option value="2" {{ $user->role == 2 ? 'selected' : '' }}>Администратор</option>
                            </select>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    
    <div class="pagination-wrapper">
        {{ $users->links() }}
    </div>
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

.users-table-wrapper {
    background: var(--gray);
    border: 2px solid rgba(255, 215, 0, 0.2);
    border-radius: 16px;
    overflow: hidden;
    margin-bottom: 30px;
}

.users-table {
    width: 100%;
    border-collapse: collapse;
}

.users-table thead {
    background: rgba(255, 215, 0, 0.1);
}

.users-table th {
    padding: 20px;
    text-align: left;
    font-weight: 600;
    color: var(--gold);
    border-bottom: 2px solid rgba(255, 215, 0, 0.2);
}

.users-table td {
    padding: 20px;
    border-bottom: 1px solid rgba(255, 215, 0, 0.1);
    color: var(--white);
}

.users-table tbody tr:hover {
    background: rgba(255, 215, 0, 0.05);
}

.role-badge {
    display: inline-block;
    padding: 6px 12px;
    border-radius: 20px;
    font-size: 0.85em;
    font-weight: 600;
    font-family: 'JetBrains Mono', monospace;
}

.role-2 {
    background: rgba(255, 215, 0, 0.2);
    color: var(--gold);
    border: 1px solid var(--gold);
}

.role-1 {
    background: rgba(255, 255, 255, 0.1);
    color: rgba(255, 255, 255, 0.7);
    border: 1px solid rgba(255, 255, 255, 0.2);
}

.role-form {
    display: inline-block;
}

.role-select {
    padding: 8px 12px;
    background: var(--black);
    border: 1px solid rgba(255, 215, 0, 0.3);
    border-radius: 8px;
    color: var(--white);
    font-size: 0.9em;
    cursor: pointer;
    transition: all 0.3s ease;
}

.role-select:hover {
    border-color: var(--gold);
}

.role-select:focus {
    outline: none;
    border-color: var(--gold);
    box-shadow: 0 0 0 3px rgba(255, 215, 0, 0.1);
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
    
    .users-table-wrapper {
        overflow-x: auto;
    }
    
    .users-table {
        min-width: 800px;
    }
}
</style>
@endsection

