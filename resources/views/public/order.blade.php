@extends('layouts.app')

@section('title', 'Pesan Tiket')

@section('content')
<!-- Navigation -->
<nav class="fixed top-0 left-0 right-0 z-50 bg-white/80 dark:bg-slate-900/80 backdrop-blur-xl border-b border-slate-200/50 dark:border-slate-700/50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-16">
            <a href="{{ route('home') }}" class="flex items-center gap-3">
                <div class="w-9 h-9 rounded-xl gradient-primary flex items-center justify-center">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z"/>
                    </svg>
                </div>
                <span class="text-lg font-bold font-heading text-slate-900 dark:text-white">AGX Concert</span>
            </a>
            
            <button onclick="toggleDarkMode()" class="p-2 rounded-lg text-slate-500 hover:bg-slate-100 dark:hover:bg-slate-800">
                <svg class="w-5 h-5 dark:hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"/>
                </svg>
                <svg class="w-5 h-5 hidden dark:block" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"/>
                </svg>
            </button>
        </div>
    </div>
</nav>

<!-- Main Content -->
<main class="min-h-screen pt-24 pb-16 bg-slate-50 dark:bg-slate-900">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="text-center mb-10" data-aos="fade-up">
            <h1 class="text-3xl sm:text-4xl font-bold font-heading text-slate-900 dark:text-white">Pesan Tiket Konser</h1>
            <p class="mt-3 text-lg text-slate-600 dark:text-slate-400">Isi data berikut dengan lengkap dan benar.</p>
        </div>
        
        <!-- Form -->
        <form action="{{ route('order.store') }}" method="POST" class="bg-white dark:bg-slate-800 rounded-2xl border border-slate-200 dark:border-slate-700 shadow-xl overflow-hidden" data-aos="fade-up" data-aos-delay="100">
            @csrf
            
            <div class="p-6 lg:p-8 space-y-8">
                <!-- Personal Info -->
                <div>
                    <h3 class="text-lg font-semibold text-slate-900 dark:text-white mb-5 flex items-center gap-2">
                        <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                        </svg>
                        Informasi Pribadi
                    </h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1.5">Nama Lengkap <span class="text-red-500">*</span></label>
                            <input type="text" name="full_name" value="{{ old('full_name') }}" class="w-full px-4 py-3 rounded-xl border border-slate-200 dark:border-slate-600 bg-white dark:bg-slate-700 text-slate-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all @error('full_name') border-red-500 @enderror">
                            @error('full_name') <p class="mt-1 text-sm text-red-500">{{ $message }}</p> @enderror
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1.5">Email <span class="text-red-500">*</span></label>
                            <input type="email" name="email" value="{{ old('email') }}" class="w-full px-4 py-3 rounded-xl border border-slate-200 dark:border-slate-600 bg-white dark:bg-slate-700 text-slate-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all @error('email') border-red-500 @enderror">
                            @error('email') <p class="mt-1 text-sm text-red-500">{{ $message }}</p> @enderror
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1.5">Nomor HP <span class="text-red-500">*</span></label>
                            <input type="text" name="phone" value="{{ old('phone') }}" class="w-full px-4 py-3 rounded-xl border border-slate-200 dark:border-slate-600 bg-white dark:bg-slate-700 text-slate-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all @error('phone') border-red-500 @enderror">
                            @error('phone') <p class="mt-1 text-sm text-red-500">{{ $message }}</p> @enderror
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1.5">Jenis Kelamin <span class="text-red-500">*</span></label>
                            <select name="gender" class="w-full px-4 py-3 rounded-xl border border-slate-200 dark:border-slate-600 bg-white dark:bg-slate-700 text-slate-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all @error('gender') border-red-500 @enderror">
                                <option value="">Pilih</option>
                                <option value="male" {{ old('gender') === 'male' ? 'selected' : '' }}>Laki-laki</option>
                                <option value="female" {{ old('gender') === 'female' ? 'selected' : '' }}>Perempuan</option>
                            </select>
                            @error('gender') <p class="mt-1 text-sm text-red-500">{{ $message }}</p> @enderror
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1.5">Tanggal Lahir <span class="text-red-500">*</span></label>
                            <input type="date" name="birth_date" value="{{ old('birth_date') }}" class="w-full px-4 py-3 rounded-xl border border-slate-200 dark:border-slate-600 bg-white dark:bg-slate-700 text-slate-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all @error('birth_date') border-red-500 @enderror">
                            @error('birth_date') <p class="mt-1 text-sm text-red-500">{{ $message }}</p> @enderror
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1.5">Nomor Identitas <span class="text-red-500">*</span></label>
                            <input type="text" name="identity_number" value="{{ old('identity_number') }}" class="w-full px-4 py-3 rounded-xl border border-slate-200 dark:border-slate-600 bg-white dark:bg-slate-700 text-slate-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all @error('identity_number') border-red-500 @enderror">
                            @error('identity_number') <p class="mt-1 text-sm text-red-500">{{ $message }}</p> @enderror
                        </div>
                    </div>
                </div>
                
                <hr class="border-slate-200 dark:border-slate-700">
                
                <!-- Address Info -->
                <div>
                    <h3 class="text-lg font-semibold text-slate-900 dark:text-white mb-5 flex items-center gap-2">
                        <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                        </svg>
                        Alamat
                    </h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1.5">Alamat Lengkap <span class="text-red-500">*</span></label>
                            <textarea name="address" rows="3" class="w-full px-4 py-3 rounded-xl border border-slate-200 dark:border-slate-600 bg-white dark:bg-slate-700 text-slate-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all resize-none @error('address') border-red-500 @enderror">{{ old('address') }}</textarea>
                            @error('address') <p class="mt-1 text-sm text-red-500">{{ $message }}</p> @enderror
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1.5">Kota <span class="text-red-500">*</span></label>
                            <input type="text" name="city" value="{{ old('city') }}" class="w-full px-4 py-3 rounded-xl border border-slate-200 dark:border-slate-600 bg-white dark:bg-slate-700 text-slate-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all @error('city') border-red-500 @enderror">
                            @error('city') <p class="mt-1 text-sm text-red-500">{{ $message }}</p> @enderror
                        </div>
                    </div>
                </div>
                
                <hr class="border-slate-200 dark:border-slate-700">
                
                <!-- Emergency Contact -->
                <div>
                    <h3 class="text-lg font-semibold text-slate-900 dark:text-white mb-5 flex items-center gap-2">
                        <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                        </svg>
                        Kontak Darurat
                    </h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                        <div>
                            <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1.5">Nama Kontak Darurat <span class="text-red-500">*</span></label>
                            <input type="text" name="emergency_contact" value="{{ old('emergency_contact') }}" class="w-full px-4 py-3 rounded-xl border border-slate-200 dark:border-slate-600 bg-white dark:bg-slate-700 text-slate-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all @error('emergency_contact') border-red-500 @enderror">
                            @error('emergency_contact') <p class="mt-1 text-sm text-red-500">{{ $message }}</p> @enderror
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1.5">Nomor Kontak Darurat <span class="text-red-500">*</span></label>
                            <input type="text" name="emergency_phone" value="{{ old('emergency_phone') }}" class="w-full px-4 py-3 rounded-xl border border-slate-200 dark:border-slate-600 bg-white dark:bg-slate-700 text-slate-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all @error('emergency_phone') border-red-500 @enderror">
                            @error('emergency_phone') <p class="mt-1 text-sm text-red-500">{{ $message }}</p> @enderror
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Footer -->
            <div class="px-6 lg:px-8 py-5 bg-slate-50 dark:bg-slate-700/30 border-t border-slate-200 dark:border-slate-700 flex items-center justify-end gap-3">
                <a href="{{ route('home') }}" class="px-6 py-3 rounded-xl border border-slate-200 dark:border-slate-600 text-slate-600 dark:text-slate-400 font-medium hover:bg-slate-100 dark:hover:bg-slate-700 transition-all">
                    Batal
                </a>
                <button type="submit" class="btn-ripple px-8 py-3 rounded-xl gradient-primary text-white font-semibold shadow-lg shadow-blue-500/25 hover:shadow-xl transition-all">
                    Pesan Tiket
                </button>
            </div>
        </form>
    </div>
</main>
@endsection