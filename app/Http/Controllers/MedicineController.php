<?php

namespace App\Http\Controllers;

use App\Models\Medicine;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MedicineController extends Controller
{
    public function home()
    {
        $featuredMedicines = Medicine::orderBy('created_at', 'desc')
            ->take(6)
            ->get();

        $categories = Medicine::selectRaw('category, COUNT(*) as total')
            ->whereNotNull('category')
            ->groupBy('category')
            ->orderByDesc('total')
            ->take(6)
            ->get();

        return view('home', compact('featuredMedicines', 'categories'));
    }

    public function index(Request $request)
    {
        try {
            $query = Medicine::query();
            
            if ($request->has('category') && $request->category) {
                $query->where('category', $request->category);
            }
            
            if ($request->has('search') && $request->search) {
                $search = $request->search;
                $query->where(function($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                      ->orWhere('description', 'like', "%{$search}%")
                      ->orWhere('manufacturer', 'like', "%{$search}%");
                });
            }
            
            // Фильтр по цене
            if ($request->has('price_min') && $request->price_min) {
                $query->where('price', '>=', $request->price_min);
            }
            
            if ($request->has('price_max') && $request->price_max) {
                $query->where('price', '<=', $request->price_max);
            }
            
            // Сортировка
            $sortBy = $request->get('sort_by', 'created_at');
            $sortOrder = $request->get('sort_order', 'desc');
            
            $allowedSorts = ['name', 'price', 'created_at', 'expiry_date'];
            if (in_array($sortBy, $allowedSorts)) {
                $query->orderBy($sortBy, $sortOrder);
            } else {
                $query->orderBy('created_at', 'desc');
            }
            
            $medicines = $query->paginate(12)->withQueryString();
            return view('medicines.index', compact('medicines'));
        } catch (\Exception $e) {
            return back()->with('error', 'Ошибка при загрузке каталога: ' . $e->getMessage());
        }
    }

    public function create()
    {
        abort_unless(Auth::check() && Auth::user()->role === 2, 403);

        return view('medicines.create');
    }

    public function store(Request $request)
    {
        abort_unless(Auth::check() && Auth::user()->role === 2, 403);

        try {
            $request->validate([
                'name' => 'required|string|max:255',
                'image_url' => 'nullable|url|max:500',
                'description' => 'nullable|string',
                'price' => 'required|numeric|min:0',
                'quantity' => 'required|integer|min:0',
                'category' => 'nullable|string|max:255',
                'manufacturer' => 'nullable|string|max:255',
                'expiry_date' => 'nullable|date',
            ]);

            // Проверка на истекший срок годности
            if ($request->expiry_date && \Carbon\Carbon::parse($request->expiry_date)->isPast()) {
                return back()->withErrors(['expiry_date' => 'Срок годности не может быть в прошлом'])->withInput();
            }

            Medicine::create($request->all());

            return redirect()->route('medicines.index')
                ->with('success', 'Лекарство успешно добавлено!');
        } catch (\Exception $e) {
            return back()->with('error', 'Ошибка при добавлении лекарства: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function show(Medicine $medicine)
    {
        try {
            // Проверка на истекший срок годности
            $isExpired = $medicine->expiry_date && $medicine->expiry_date->isPast();
            
            return view('medicines.show', compact('medicine', 'isExpired'));
        } catch (\Exception $e) {
            return back()->with('error', 'Ошибка при загрузке лекарства: ' . $e->getMessage());
        }
    }

    public function edit(Medicine $medicine)
    {
        abort_unless(Auth::check() && Auth::user()->role === 2, 403);

        return view('medicines.edit', compact('medicine'));
    }

    public function update(Request $request, Medicine $medicine)
    {
        abort_unless(Auth::check() && Auth::user()->role === 2, 403);

        try {
            $request->validate([
                'name' => 'required|string|max:255',
                'image_url' => 'nullable|url|max:500',
                'description' => 'nullable|string',
                'price' => 'required|numeric|min:0',
                'quantity' => 'required|integer|min:0',
                'category' => 'nullable|string|max:255',
                'manufacturer' => 'nullable|string|max:255',
                'expiry_date' => 'nullable|date',
            ]);

            // Проверка на истекший срок годности
            if ($request->expiry_date && \Carbon\Carbon::parse($request->expiry_date)->isPast()) {
                return back()->withErrors(['expiry_date' => 'Срок годности не может быть в прошлом'])->withInput();
            }

            $medicine->update($request->all());

            return redirect()->route('medicines.index')
                ->with('success', 'Лекарство успешно обновлено!');
        } catch (\Exception $e) {
            return back()->with('error', 'Ошибка при обновлении лекарства: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function destroy(Medicine $medicine)
    {
        abort_unless(Auth::check() && Auth::user()->role === 2, 403);

        try {
            $medicine->delete();

            return redirect()->route('medicines.index')
                ->with('success', 'Лекарство успешно удалено!');
        } catch (\Exception $e) {
            return back()->with('error', 'Ошибка при удалении лекарства: ' . $e->getMessage());
        }
    }
}

