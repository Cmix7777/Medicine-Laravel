<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Medicine;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function index()
    {
        try {
            $query = Order::with('items.medicine')
                ->orderBy('created_at', 'desc');

            if (Auth::user()?->role !== 2) { // 2 = admin
                $query->where('user_id', Auth::id());
            }

            $orders = $query->paginate(10);

            return view('orders.index', compact('orders'));
        } catch (\Exception $e) {
            return back()->with('error', 'Ошибка при загрузке заказов: ' . $e->getMessage());
        }
    }

    public function store(Request $request)
    {
        try {
            $cart = Session::get('cart', []);

            if (empty($cart)) {
                return back()->with('error', 'Корзина пуста');
            }

            DB::beginTransaction();

            $totalAmount = 0;
            $orderItems = [];

            foreach ($cart as $medicineId => $quantity) {
                $medicine = Medicine::find($medicineId);
                
                if (!$medicine) {
                    DB::rollBack();
                    return back()->with('error', 'Лекарство не найдено');
                }

                // Проверка на истекший срок годности
                if ($medicine->expiry_date && $medicine->expiry_date->isPast()) {
                    DB::rollBack();
                    return back()->with('error', "Лекарство '{$medicine->name}' имеет истекший срок годности");
                }

                // Проверка наличия
                if ($medicine->quantity < $quantity) {
                    DB::rollBack();
                    return back()->with('error', "Недостаточное количество товара '{$medicine->name}'");
                }

                $subtotal = $medicine->price * $quantity;
                $totalAmount += $subtotal;

                $orderItems[] = [
                    'medicine_id' => $medicine->id,
                    'quantity' => $quantity,
                    'price' => $medicine->price,
                ];
            }

            $order = Order::create([
                'user_id' => Auth::id(),
                'total_amount' => $totalAmount,
                'status' => 'pending',
            ]);

            foreach ($orderItems as $item) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'medicine_id' => $item['medicine_id'],
                    'quantity' => $item['quantity'],
                    'price' => $item['price'],
                ]);

                // Уменьшаем количество лекарства
                $medicine = Medicine::find($item['medicine_id']);
                $medicine->quantity -= $item['quantity'];
                $medicine->save();
            }

            DB::commit();
            Session::forget('cart');

            return redirect()->route('orders.show', $order)
                ->with('success', 'Заказ успешно оформлен!');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Ошибка при оформлении заказа: ' . $e->getMessage());
        }
    }

    public function show(Order $order)
    {
        try {
            // Админ может просматривать любые заказы, обычный пользователь - только свои
            if (Auth::user()?->role !== 2 && $order->user_id !== Auth::id()) {
                abort(403);
            }

            $order->load('items.medicine');

            return view('orders.show', compact('order'));
        } catch (\Exception $e) {
            return back()->with('error', 'Ошибка при загрузке заказа: ' . $e->getMessage());
        }
    }
}
