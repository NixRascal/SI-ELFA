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
        $jenisResponden = $this->input('jenis_responden');
        
        $rules = [
            'jenis_responden' => ['required', 'in:mahasiswa,dosen,staff,alumni,stakeholder'],
            'nama' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
        ];
        
        // Mahasiswa: semua field wajib termasuk NPM
        if ($jenisResponden === 'mahasiswa') {
            $rules['npm'] = ['required', 'string', 'max:255'];
            $rules['fakultas'] = ['required', 'string', 'max:255'];
            $rules['jurusan'] = ['required', 'string', 'max:255'];
        }
        // Dosen: semua field wajib, NPM diganti NIP
        elseif ($jenisResponden === 'dosen') {
            $rules['npm'] = ['required', 'string', 'max:255']; // akan menjadi NIP di form
            $rules['fakultas'] = ['required', 'string', 'max:255'];
            $rules['jurusan'] = ['required', 'string', 'max:255'];
        }
        // Staff: semua field wajib kecuali fakultas dan jurusan opsional, NPM tidak ada
        elseif ($jenisResponden === 'staff') {
            $rules['npm'] = ['nullable'];
            $rules['fakultas'] = ['nullable', 'string', 'max:255'];
            $rules['jurusan'] = ['nullable', 'string', 'max:255'];
        }
        // Alumni: semua field wajib termasuk NPM
        elseif ($jenisResponden === 'alumni') {
            $rules['npm'] = ['required', 'string', 'max:255'];
            $rules['fakultas'] = ['required', 'string', 'max:255'];
            $rules['jurusan'] = ['required', 'string', 'max:255'];
        }
        // Stakeholder: tidak mengisi NPM, fakultas, dan jurusan
        elseif ($jenisResponden === 'stakeholder') {
            $rules['npm'] = ['nullable'];
            $rules['fakultas'] = ['nullable'];
            $rules['jurusan'] = ['nullable'];
        }
        
        return $rules;
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
            'npm.required' => $this->input('jenis_responden') === 'dosen' ? 'NIP wajib diisi' : 'NPM wajib diisi',
            'npm.max' => $this->input('jenis_responden') === 'dosen' ? 'NIP maksimal 255 karakter' : 'NPM maksimal 255 karakter',
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
