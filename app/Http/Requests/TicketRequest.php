<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TicketRequest extends FormRequest
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
            'concert_id' => ['required', 'exists:concerts,id'],
            'full_name' => ['required', 'string', 'min:3', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
            'phone' => ['required', 'string', 'min:10', 'max:20', 'regex:/^[0-9+\-\s()]+$/'],
            'gender' => ['required', 'in:male,female'],
            'birth_date' => ['required', 'date', 'before:today', 'after:1920-01-01'],
            'address' => ['required', 'string', 'min:5', 'max:500'],
            'city' => ['required', 'string', 'min:2', 'max:100'],
            'identity_number' => ['required', 'string', 'min:5', 'max:50'],
            'emergency_contact' => ['required', 'string', 'min:3', 'max:255'],
            'emergency_phone' => ['required', 'string', 'min:10', 'max:20', 'regex:/^[0-9+\-\s()]+$/'],
        ];
    }

    /**
     * Get custom messages for validator errors.
     */
    public function messages(): array
    {
        return [
            'concert_id.required' => 'Pilih konser terlebih dahulu.',
            'concert_id.exists' => 'Konser yang dipilih tidak valid.',

            'full_name.required' => 'Nama lengkap wajib diisi.',
            'full_name.min' => 'Nama lengkap minimal 3 karakter.',
            'full_name.max' => 'Nama lengkap maksimal 255 karakter.',

            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.max' => 'Email maksimal 255 karakter.',

            'phone.required' => 'Nomor HP wajib diisi.',
            'phone.min' => 'Nomor HP minimal 10 karakter.',
            'phone.max' => 'Nomor HP maksimal 20 karakter.',
            'phone.regex' => 'Nomor HP hanya boleh berisi angka, +, -, spasi, dan kurung.',

            'gender.required' => 'Jenis kelamin wajib dipilih.',
            'gender.in' => 'Jenis kelamin tidak valid.',

            'birth_date.required' => 'Tanggal lahir wajib diisi.',
            'birth_date.date' => 'Format tanggal lahir tidak valid.',
            'birth_date.before' => 'Tanggal lahir harus sebelum hari ini.',
            'birth_date.after' => 'Tanggal lahir tidak valid.',

            'address.required' => 'Alamat wajib diisi.',
            'address.min' => 'Alamat minimal 5 karakter.',
            'address.max' => 'Alamat maksimal 500 karakter.',

            'city.required' => 'Kota wajib diisi.',
            'city.min' => 'Nama kota minimal 2 karakter.',
            'city.max' => 'Nama kota maksimal 100 karakter.',

            'identity_number.required' => 'Nomor identitas wajib diisi.',
            'identity_number.min' => 'Nomor identitas minimal 5 karakter.',
            'identity_number.max' => 'Nomor identitas maksimal 50 karakter.',

            'emergency_contact.required' => 'Kontak darurat wajib diisi.',
            'emergency_contact.min' => 'Nama kontak darurat minimal 3 karakter.',
            'emergency_contact.max' => 'Nama kontak darurat maksimal 255 karakter.',

            'emergency_phone.required' => 'Nomor kontak darurat wajib diisi.',
            'emergency_phone.min' => 'Nomor kontak darurat minimal 10 karakter.',
            'emergency_phone.max' => 'Nomor kontak darurat maksimal 20 karakter.',
            'emergency_phone.regex' => 'Nomor kontak darurat hanya boleh berisi angka, +, -, spasi, dan kurung.',
        ];
    }

    /**
     * Get custom attributes for validator errors.
     */
    public function attributes(): array
    {
        return [
            'full_name' => 'nama lengkap',
            'email' => 'email',
            'phone' => 'nomor HP',
            'gender' => 'jenis kelamin',
            'birth_date' => 'tanggal lahir',
            'address' => 'alamat',
            'city' => 'kota',
            'identity_number' => 'nomor identitas',
            'emergency_contact' => 'kontak darurat',
            'emergency_phone' => 'nomor kontak darurat',
        ];
    }

    /**
     * Prepare the data for validation.
     */
    protected function prepareForValidation(): void
    {
        // Trim and normalize data
        if ($this->has('full_name')) {
            $this->merge([
                'full_name' => ucwords(strtolower(trim($this->full_name))),
            ]);
        }

        if ($this->has('email')) {
            $this->merge([
                'email' => strtolower(trim($this->email)),
            ]);
        }

        if ($this->has('city')) {
            $this->merge([
                'city' => ucwords(strtolower(trim($this->city))),
            ]);
        }
    }
}