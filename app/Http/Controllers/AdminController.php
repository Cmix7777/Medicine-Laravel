<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Medicine;
use App\Models\Order;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    /**
     * Главная страница админки
     */
    public function dashboard()
    {
        $usersCount = User::count();
        $medicinesCount = Medicine::count();
        $ordersCount = Order::count();
        
        return view('admin.dashboard', compact('usersCount', 'medicinesCount', 'ordersCount'));
    }

    /**
     * Список всех пользователей
     */
    public function users()
    {
        $users = User::orderBy('created_at', 'desc')->paginate(10);
        return view('admin.users', compact('users'));
    }

    /**
     * Изменение роли пользователя
     */
    public function updateUserRole(Request $request, User $user)
    {
        $request->validate([
            'role' => 'required|in:1,2', // 1 = user, 2 = admin
        ]);

        $user->update([
            'role' => (int)$request->role,
        ]);

        return redirect()->route('admin.users')->with('success', 'Роль пользователя обновлена');
    }

    /**
     * Просмотр всех заказов в админке
     */
    public function orders()
    {
        $orders = Order::with('items.medicine', 'user')
            ->orderBy('created_at', 'desc')
            ->paginate(10);
        
        return view('admin.orders', compact('orders'));
    }
}
