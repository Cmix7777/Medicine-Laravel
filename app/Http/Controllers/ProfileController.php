<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class ProfileController extends Controller
{
    public function show()
    {
        $user = Auth::user();
        $orders = $user->orders()
            ->with('items.medicine')
            ->orderByDesc('created_at')
            ->paginate(10);

        return view('profile.index', compact('user', 'orders'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'password' => ['nullable', 'string', 'min:8', 'confirmed'],
        ]);

        try {
            $user->name = $data['name'];
            $user->email = $data['email'];

            if (!empty($data['password'])) {
                $user->password = Hash::make($data['password']);
            }

            $user->save();

            return redirect()->route('profile.show')
                ->with('success', 'Профиль обновлён');
        } catch (\Exception $e) {
            return back()->with('error', 'Ошибка при обновлении профиля: ' . $e->getMessage())
                ->withInput();
        }
    }
}


