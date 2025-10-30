<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreRespondentProfileRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'jenis_responden' => ['required', 'in:mahasiswa,dosen,staff,alumni,stakeholder'],
            'nama' => ['required', 'string', 'max:255'],
            'npm' => ['nullable', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
            'fakultas' => ['required', 'string', 'max:255'],
            'jurusan' => ['required', 'string', 'max:255'],
        ];
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'jenis_responden.required' => 'Jenis responden wajib dipilih',
            'jenis_responden.in' => 'Jenis responden tidak valid',
            'nama.required' => 'Nama wajib diisi',
            'nama.max' => 'Nama maksimal 255 karakter',
            'npm.max' => 'NPM maksimal 255 karakter',
            'email.required' => 'Email wajib diisi',
            'email.email' => 'Format email tidak valid',
            'email.max' => 'Email maksimal 255 karakter',
            'fakultas.required' => 'Fakultas wajib dipilih',
            'fakultas.max' => 'Fakultas maksimal 255 karakter',
            'jurusan.required' => 'Jurusan wajib diisi',
            'jurusan.max' => 'Jurusan maksimal 255 karakter',
        ];
    }
    
    /**
     * Get custom attributes for validator errors.
     *
     * @return array<string, string>
     */
    public function attributes(): array
    {
        return [
            'jenis_responden' => 'jenis responden',
            'nama' => 'nama',
            'npm' => 'NPM',
            'email' => 'email',
            'fakultas' => 'fakultas',
            'jurusan' => 'jurusan',
        ];
    }
}
