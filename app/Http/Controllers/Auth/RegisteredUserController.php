<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Mahasiswa;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    public function create(): View
    {
        return view('auth.register');
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'nama' => ['required', 'string', 'max:255'],
            'nim' => ['required', 'string', 'max:20', 'unique:' . Mahasiswa::class],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . Mahasiswa::class],
            'no_hp' => ['nullable', 'string', 'max:20'],
            'angkatan' => ['nullable', 'integer', 'min:2000', 'max:' . (date('Y') + 1)],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'kode_kelas' => ['required', 'string', function (string $attribute, mixed $value, \Closure $fail) {
                if (strtoupper($value) !== strtoupper(config('app.kelas_kode'))) {
                    $fail('Kode kelas tidak valid.');
                }
            }],
        ]);

        $user = Mahasiswa::create([
            'nama' => $request->nama,
            'nim' => $request->nim,
            'email' => $request->email,
            'no_hp' => $request->no_hp,
            'angkatan' => $request->angkatan,
            'password' => Hash::make($request->password),
        ]);

        event(new Registered($user));

        Auth::login($user);

        return redirect(route('dashboard', absolute: false));
    }
}
