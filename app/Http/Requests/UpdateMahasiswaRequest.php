<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateMahasiswaRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $mahasiswa = $this->route('mahasiswa');

        return [
            'nama' => ['required', 'string', 'max:255'],
            'nim' => ['required', 'string', 'max:20', Rule::unique('mahasiswa')->ignore($mahasiswa)],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', Rule::unique('mahasiswa')->ignore($mahasiswa)],
            'no_hp' => ['nullable', 'string', 'max:20'],
            'password' => ['sometimes', 'nullable', 'string', 'min:8'],
            'foto' => ['nullable', 'file', 'mimes:jpeg,png,jpg,gif,webp', 'max:2048'],
            'angkatan' => ['nullable', 'integer', 'min:2000', 'max:' . (date('Y') + 1)],
            'role' => ['nullable', 'string', 'in:anggota,admin,administrator'],
        ];
    }
}
