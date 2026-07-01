@extends('layouts.admin')

@section('title', 'Tambah User')
@section('breadcrumb', 'Tambah User')

@section('admin-content')
    <div class="max-w-3xl mx-auto space-y-6">
        <!-- Header -->
        <div class="flex items-center gap-3" data-aos="fade-up">
            <a href="{{ route('admin.users.index') }}"
                class="p-2 rounded-lg text-slate-500 hover:bg-slate-100 dark:hover:bg-slate-700 transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
            </a>
            <div>
                <h1 class="text-2xl font-bold font-heading text-slate-900 dark:text-white">Tambah User Baru</h1>
                <p class="mt-1 text-slate-500">Buat akun administrator atau staff check-in.</p>
            </div>
        </div>

        <!-- Form -->
        <form action="{{ route('admin.users.store') }}" method="POST"
            class="bg-white dark:bg-slate-800 rounded-2xl border border-slate-200 dark:border-slate-700 shadow-sm"
            data-aos="fade-up" data-aos-delay="100">
            @csrf

            <div class="p-6 lg:p-8 space-y-6">
                <!-- Account Info -->
                <div>
                    <h3 class="text-lg font-semibold text-slate-900 dark:text-white mb-4 flex items-center gap-2">
                        <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                        Informasi Akun
                    </h3>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1.5">Nama Lengkap
                                <span class="text-red-500">*</span></label>
                            <input type="text" name="name" value="{{ old('name') }}"
                                class="w-full px-4 py-2.5 rounded-xl border border-slate-200 dark:border-slate-600 bg-white dark:bg-slate-700 text-slate-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('name') border-red-500 @enderror">
                            @error('name') <p class="mt-1 text-sm text-red-500">{{ $message }}</p> @enderror
                        </div>

                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1.5">Email <span
                                    class="text-red-500">*</span></label>
                            <input type="email" name="email" value="{{ old('email') }}" placeholder="user@example.com"
                                class="w-full px-4 py-2.5 rounded-xl border border-slate-200 dark:border-slate-600 bg-white dark:bg-slate-700 text-slate-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('email') border-red-500 @enderror">
                            @error('email') <p class="mt-1 text-sm text-red-500">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1.5">Nomor
                                HP</label>
                            <input type="text" name="phone" value="{{ old('phone') }}" placeholder="08xxxxxxxxxx"
                                class="w-full px-4 py-2.5 rounded-xl border border-slate-200 dark:border-slate-600 bg-white dark:bg-slate-700 text-slate-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('phone') border-red-500 @enderror">
                            @error('phone') <p class="mt-1 text-sm text-red-500">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1.5">Role <span
                                    class="text-red-500">*</span></label>
                            <select name="role"
                                class="w-full px-4 py-2.5 rounded-xl border border-slate-200 dark:border-slate-600 bg-white dark:bg-slate-700 text-slate-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('role') border-red-500 @enderror">
                                <option value="">Pilih Role</option>
                                <option value="admin" {{ old('role') === 'admin' ? 'selected' : '' }}>Administrator</option>
                                <option value="checkin_staff" {{ old('role') === 'checkin_staff' ? 'selected' : '' }}>Check In
                                    Staff</option>
                            </select>
                            @error('role') <p class="mt-1 text-sm text-red-500">{{ $message }}</p> @enderror
                        </div>
                    </div>
                </div>

                <hr class="border-slate-200 dark:border-slate-700">

                <!-- Password -->
                <div>
                    <h3 class="text-lg font-semibold text-slate-900 dark:text-white mb-4 flex items-center gap-2">
                        <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                        </svg>
                        Password
                    </h3>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                        <div>
                            <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1.5">Password
                                <span class="text-red-500">*</span></label>
                            <input type="password" name="password"
                                class="w-full px-4 py-2.5 rounded-xl border border-slate-200 dark:border-slate-600 bg-white dark:bg-slate-700 text-slate-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('password') border-red-500 @enderror">
                            @error('password') <p class="mt-1 text-sm text-red-500">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1.5">Konfirmasi
                                Password <span class="text-red-500">*</span></label>
                            <input type="password" name="password_confirmation"
                                class="w-full px-4 py-2.5 rounded-xl border border-slate-200 dark:border-slate-600 bg-white dark:bg-slate-700 text-slate-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        </div>
                    </div>

                    <div
                        class="mt-3 p-3 rounded-lg bg-blue-50 dark:bg-blue-900/20 border border-blue-100 dark:border-blue-800">
                        <p class="text-xs text-blue-700 dark:text-blue-300">
                            💡 Password minimal 8 karakter, kombinasi huruf besar, kecil, dan angka.
                        </p>
                    </div>
                </div>
            </div>

            <!-- Footer -->
            <div
                class="px-6 lg:px-8 py-4 bg-slate-50 dark:bg-slate-700/30 border-t border-slate-200 dark:border-slate-700 rounded-b-2xl flex items-center justify-end gap-3">
                <a href="{{ route('admin.users.index') }}"
                    class="px-5 py-2.5 rounded-xl border border-slate-200 dark:border-slate-600 text-slate-600 dark:text-slate-400 font-medium text-sm hover:bg-slate-100 dark:hover:bg-slate-700 transition-all">
                    Batal
                </a>
                <button type="submit"
                    class="btn-ripple px-6 py-2.5 rounded-xl gradient-primary text-white font-medium text-sm shadow-lg shadow-blue-500/25 hover:shadow-xl transition-all">
                    Simpan User
                </button>
            </div>
        </form>
    </div>
@endsection