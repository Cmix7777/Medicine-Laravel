<?php

namespace App\Http\Controllers;

use App\Models\Medicine;
use Illuminate\Http\Request;

class MedicineController extends Controller
{
    public function home()
    {
        $featuredMedicines = Medicine::orderBy('created_at', 'desc')->take(6)->get();
        $categories = Medicine::select('category')
            ->whereNotNull('category')
            ->distinct()
            ->pluck('category')
            ->take(6);
        return view('home', compact('featuredMedicines', 'categories'));
    }

    public function index(Request $request)
    {
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
        
        $medicines = $query->orderBy('created_at', 'desc')->paginate(12)->withQueryString();
        return view('medicines.index', compact('medicines'));
    }

    public function create()
    {
        return view('medicines.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'quantity' => 'required|integer|min:0',
            'category' => 'nullable|string|max:255',
            'manufacturer' => 'nullable|string|max:255',
            'expiry_date' => 'nullable|date',
        ]);

        Medicine::create($request->all());

        return redirect()->route('medicines.index');
    }

    public function show(Medicine $medicine)
    {
        return view('medicines.show', compact('medicine'));
    }

    public function edit(Medicine $medicine)
    {
        return view('medicines.edit', compact('medicine'));
    }

    public function update(Request $request, Medicine $medicine)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'quantity' => 'required|integer|min:0',
            'category' => 'nullable|string|max:255',
            'manufacturer' => 'nullable|string|max:255',
            'expiry_date' => 'nullable|date',
        ]);

        $medicine->update($request->all());

        return redirect()->route('medicines.index');
    }

    public function destroy(Medicine $medicine)
    {
        $medicine->delete();

        return redirect()->route('medicines.index');
    }
}

