<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view (for web only).
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request (web + API).
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
        ]);

        event(new Registered($user));

        Auth::login($user);

        // Jika permintaan API (expects JSON), kirim JSON
        try {
            $token = $user->createToken('api_token')->plainTextToken;
            return response()->json([
                'message' => 'User registered successfully.',
                'user' => $user,
                'token' => $token
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'User created, but token generation failed.',
                'user' => $user,
                'error' => $e->getMessage()
            ], 500);
        }
        

        // Jika permintaan dari web, redirect biasa
        return redirect()->route('dashboard');
    }

    public function index()
    {
        return response()->json([
            'status' => 'success',
            'data' => User::all()
        ]);
    }

    public function destroy($id)
    {
        $user = User::find($id);

        if (!$user) {
            return response()->json([
                'status' => 'error',
                'message' => 'User tidak ditemukan.'
            ], 404);
        }

        $user->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'User berhasil dihapus.'
        ]);
    }

    public function update(Request $request, $id)
    {
        $user = User::find($id);

        if (!$user) {
            return response()->json([
                'status' => 'error',
                'message' => 'User tidak ditemukan.'
            ], 404);
        }

        // Validasi data
        $request->validate([
            'name' => 'sometimes|string|max:255',
            'email' => 'sometimes|email|unique:users,email,' . $id,
            'password' => 'sometimes|string|min:6'
        ]);

        // Update field yang dikirim
        if ($request->has('name')) $user->name = $request->name;
        if ($request->has('email')) $user->email = $request->email;
        if ($request->has('password')) $user->password = bcrypt($request->password);

        $user->save();

        return response()->json([
            'status' => 'success',
            'message' => 'User berhasil diupdate.',
            'data' => $user
        ]);
    }


   
}
