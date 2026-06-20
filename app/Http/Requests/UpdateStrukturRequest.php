<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateStrukturRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'jabatan' => ['required', 'string', 'max:100'],
            'user_id' => ['required', 'exists:mahasiswa,id'],
            'foto' => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp', 'max:2048'],
            'urutan' => ['required', 'integer', 'min:0'],
            'deskripsi' => ['nullable', 'string'],
            'parent_id' => ['nullable', 'exists:struktur_kelas,id'],
        ];
    }
}
