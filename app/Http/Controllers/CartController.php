<?php

namespace App\Http\Controllers;

use App\Models\Medicine;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class CartController extends Controller
{
    public function index()
    {
        $cart = Session::get('cart', []);
        $items = [];
        $total = 0;

        foreach ($cart as $medicineId => $quantity) {
            $medicine = Medicine::find($medicineId);
            if ($medicine) {
                // Проверка на истекший срок годности
                $isExpired = $medicine->expiry_date && $medicine->expiry_date->isPast();
                
                $items[] = [
                    'medicine' => $medicine,
                    'quantity' => $quantity,
                    'subtotal' => $medicine->price * $quantity,
                    'isExpired' => $isExpired,
                ];
                $total += $medicine->price * $quantity;
            }
        }

        return view('cart.index', compact('items', 'total'));
    }

    public function add(Request $request, Medicine $medicine)
    {
        try {
            // Проверка на истекший срок годности
            if ($medicine->expiry_date && $medicine->expiry_date->isPast()) {
                return back()->with('error', 'Нельзя добавить лекарство с истекшим сроком годности в корзину');
            }

            // Проверка наличия
            if ($medicine->quantity <= 0) {
                return back()->with('error', 'Лекарство отсутствует в наличии');
            }

            $quantity = $request->input('quantity', 1);
            
            if ($quantity <= 0 || $quantity > $medicine->quantity) {
                return back()->with('error', 'Недостаточное количество товара');
            }

            $cart = Session::get('cart', []);
            
            if (isset($cart[$medicine->id])) {
                $newQuantity = $cart[$medicine->id] + $quantity;
                if ($newQuantity > $medicine->quantity) {
                    return back()->with('error', 'Недостаточное количество товара');
                }
                $cart[$medicine->id] = $newQuantity;
            } else {
                $cart[$medicine->id] = $quantity;
            }

            Session::put('cart', $cart);

            return back()->with('success', 'Лекарство добавлено в корзину!');
        } catch (\Exception $e) {
            return back()->with('error', 'Ошибка при добавлении в корзину: ' . $e->getMessage());
        }
    }

    public function update(Request $request, Medicine $medicine)
    {
        try {
            $quantity = $request->input('quantity', 1);
            
            if ($quantity <= 0) {
                return $this->remove($medicine);
            }

            if ($quantity > $medicine->quantity) {
                return back()->with('error', 'Недостаточное количество товара');
            }

            $cart = Session::get('cart', []);
            $cart[$medicine->id] = $quantity;
            Session::put('cart', $cart);

            return back()->with('success', 'Корзина обновлена!');
        } catch (\Exception $e) {
            return back()->with('error', 'Ошибка при обновлении корзины: ' . $e->getMessage());
        }
    }

    public function remove(Medicine $medicine)
    {
        try {
            $cart = Session::get('cart', []);
            unset($cart[$medicine->id]);
            Session::put('cart', $cart);

            return back()->with('success', 'Лекарство удалено из корзины!');
        } catch (\Exception $e) {
            return back()->with('error', 'Ошибка при удалении из корзины: ' . $e->getMessage());
        }
    }

    public function clear()
    {
        try {
            Session::forget('cart');
            return redirect()->route('medicines.index')->with('success', 'Корзина очищена!');
        } catch (\Exception $e) {
            return back()->with('error', 'Ошибка при очистке корзины: ' . $e->getMessage());
        }
    }
}
