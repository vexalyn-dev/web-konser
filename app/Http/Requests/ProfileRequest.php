<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;

class ProfileRequest extends FormRequest
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
     */
    public function rules(): array
    {
        $userId = auth()->id();

        return [
            'name' => ['required', 'string', 'min:3', 'max:255'],
            'email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('users', 'email')->ignore($userId),
            ],
            'phone' => ['nullable', 'string', 'min:10', 'max:20', 'regex:/^[0-9+\-\s()]+$/'],
            'avatar' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],

            // Password fields - only required if new_password is filled
            'current_password' => [
                'nullable',
                'required_with:new_password',
                'current_password',
            ],
            'new_password' => [
                'nullable',
                'required_with:current_password',
                'confirmed',
                Password::defaults(),
            ],
        ];
    }

    /**
     * Get custom messages for validator errors.
     */
    public function messages(): array
    {
        return [
            'name.required' => 'Nama wajib diisi.',
            'name.min' => 'Nama minimal 3 karakter.',
            'name.max' => 'Nama maksimal 255 karakter.',

            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.unique' => 'Email sudah digunakan oleh user lain.',

            'phone.min' => 'Nomor HP minimal 10 karakter.',
            'phone.max' => 'Nomor HP maksimal 20 karakter.',
            'phone.regex' => 'Format nomor HP tidak valid.',

            'avatar.image' => 'File harus berupa gambar.',
            'avatar.mimes' => 'Format gambar harus JPG, JPEG, PNG, atau WEBP.',
            'avatar.max' => 'Ukuran gambar maksimal 2MB.',

            'current_password.required_with' => 'Password lama wajib diisi untuk mengubah password.',
            'current_password.current_password' => 'Password lama tidak sesuai.',

            'new_password.required_with' => 'Password baru wajib diisi.',
            'new_password.confirmed' => 'Konfirmasi password baru tidak sesuai.',
        ];
    }

    /**
     * Get custom attributes for validator errors.
     */
    public function attributes(): array
    {
        return [
            'name' => 'nama',
            'email' => 'email',
            'phone' => 'nomor HP',
            'avatar' => 'foto profil',
            'current_password' => 'password lama',
            'new_password' => 'password baru',
        ];
    }

    /**
     * Prepare the data for validation.
     */
    protected function prepareForValidation(): void
    {
        // Remove empty password fields
        if (empty($this->new_password)) {
            $this->request->remove('new_password');
            $this->request->remove('new_password_confirmation');
            $this->request->remove('current_password');
        }
    }
}