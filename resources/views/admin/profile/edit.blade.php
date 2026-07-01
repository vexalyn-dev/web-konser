@extends('layouts.admin')

@section('title', 'Profil Saya')
@section('breadcrumb', 'Profil Saya')

@section('admin-content')
    <div class="max-w-4xl mx-auto space-y-6">
        <!-- Header -->
        <div data-aos="fade-up">
            <h1 class="text-2xl font-bold font-heading text-slate-900 dark:text-white">Profil Saya</h1>
            <p class="mt-1 text-slate-500">Kelola informasi akun dan keamanan Anda.</p>
        </div>

        <!-- Profile Card -->
        <form action="{{ route('admin.profile.update') }}" method="POST" enctype="multipart/form-data"
            class="bg-white dark:bg-slate-800 rounded-2xl border border-slate-200 dark:border-slate-700 shadow-sm"
            data-aos="fade-up" data-aos-delay="100">
            @csrf
            @method('PUT')

            <div class="p-6 lg:p-8">
                <!-- Avatar Section -->
                <div
                    class="flex flex-col sm:flex-row items-center gap-6 pb-6 border-b border-slate-200 dark:border-slate-700">
                    <div class="relative">
                        <div
                            class="w-24 h-24 rounded-full bg-gradient-to-br from-blue-500 to-blue-700 flex items-center justify-center text-white text-3xl font-bold overflow-hidden">
                            @if($user->avatar)
                                <img src="{{ $user->avatar_url }}" alt="Avatar" class="w-full h-full object-cover">
                            @else
                                {{ $user->initials }}
                            @endif
                        </div>
                        @if($user->avatar)
                            <a href="{{ route('admin.profile.remove-avatar') }}"
                                onclick="event.preventDefault(); document.getElementById('removeAvatarForm').submit();"
                                class="absolute -top-1 -right-1 w-7 h-7 rounded-full bg-red-500 text-white flex items-center justify-center hover:bg-red-600 transition-colors"
                                title="Hapus foto">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </a>
                            <form id="removeAvatarForm" action="{{ route('admin.profile.remove-avatar') }}" method="POST"
                                class="hidden">@csrf @method('DELETE')</form>
                        @endif
                    </div>
                    <div class="flex-1 text-center sm:text-left">
                        <h3 class="text-xl font-semibold text-slate-900 dark:text-white">{{ $user->name }}</h3>
                        <p class="text-sm text-slate-500">{{ $user->email }}</p>
                        <label
                            class="mt-3 inline-flex items-center gap-2 px-4 py-2 rounded-xl bg-blue-50 dark:bg-blue-900/20 text-blue-700 dark:text-blue-400 font-medium text-sm cursor-pointer hover:bg-blue-100 transition-all">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12" />
                            </svg>
                            Upload Foto
                            <input type="file" name="avatar" accept="image/*" class="hidden" onchange="previewImage(this)">
                        </label>
                        <p class="mt-1 text-xs text-slate-500">JPG, PNG, atau WEBP. Maksimal 2MB.</p>
                    </div>
                </div>

                <!-- Account Info -->
                <div class="pt-6 space-y-5">
                    <h3 class="text-lg font-semibold text-slate-900 dark:text-white">Informasi Akun</h3>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1.5">Nama Lengkap
                                <span class="text-red-500">*</span></label>
                            <input type="text" name="name" value="{{ old('name', $user->name) }}"
                                class="w-full px-4 py-2.5 rounded-xl border border-slate-200 dark:border-slate-600 bg-white dark:bg-slate-700 text-slate-900 dark:text-white focus:ring-2 focus:ring-blue-500 @error('name') border-red-500 @enderror">
                            @error('name') <p class="mt-1 text-sm text-red-500">{{ $message }}</p> @enderror
                        </div>

                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1.5">Email <span
                                    class="text-red-500">*</span></label>
                            <input type="email" name="email" value="{{ old('email', $user->email) }}"
                                class="w-full px-4 py-2.5 rounded-xl border border-slate-200 dark:border-slate-600 bg-white dark:bg-slate-700 text-slate-900 dark:text-white focus:ring-2 focus:ring-blue-500 @error('email') border-red-500 @enderror">
                            @error('email') <p class="mt-1 text-sm text-red-500">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1.5">Nomor
                                HP</label>
                            <input type="text" name="phone" value="{{ old('phone', $user->phone) }}"
                                class="w-full px-4 py-2.5 rounded-xl border border-slate-200 dark:border-slate-600 bg-white dark:bg-slate-700 text-slate-900 dark:text-white focus:ring-2 focus:ring-blue-500 @error('phone') border-red-500 @enderror">
                            @error('phone') <p class="mt-1 text-sm text-red-500">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1.5">Role</label>
                            <input type="text" value="{{ $user->role_name }}" disabled
                                class="w-full px-4 py-2.5 rounded-xl border border-slate-200 dark:border-slate-600 bg-slate-100 dark:bg-slate-700/50 text-slate-500 cursor-not-allowed">
                        </div>
                    </div>
                </div>

                <hr class="border-slate-200 dark:border-slate-700 my-6">

                <!-- Change Password -->
                <div>
                    <h3 class="text-lg font-semibold text-slate-900 dark:text-white mb-4">Ubah Password</h3>
                    <div
                        class="p-3 mb-4 rounded-lg bg-amber-50 dark:bg-amber-900/20 border border-amber-100 dark:border-amber-800">
                        <p class="text-xs text-amber-700 dark:text-amber-300">⚠️ Kosongkan semua field password jika tidak
                            ingin mengubah password.</p>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                        <div>
                            <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1.5">Password
                                Lama</label>
                            <input type="password" name="current_password"
                                class="w-full px-4 py-2.5 rounded-xl border border-slate-200 dark:border-slate-600 bg-white dark:bg-slate-700 text-slate-900 dark:text-white focus:ring-2 focus:ring-blue-500 @error('current_password') border-red-500 @enderror">
                            @error('current_password') <p class="mt-1 text-sm text-red-500">{{ $message }}</p> @enderror
                        </div>
                        <div></div>
                        <div>
                            <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1.5">Password
                                Baru</label>
                            <input type="password" name="new_password"
                                class="w-full px-4 py-2.5 rounded-xl border border-slate-200 dark:border-slate-600 bg-white dark:bg-slate-700 text-slate-900 dark:text-white focus:ring-2 focus:ring-blue-500 @error('new_password') border-red-500 @enderror">
                            @error('new_password') <p class="mt-1 text-sm text-red-500">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1.5">Konfirmasi
                                Password</label>
                            <input type="password" name="new_password_confirmation"
                                class="w-full px-4 py-2.5 rounded-xl border border-slate-200 dark:border-slate-600 bg-white dark:bg-slate-700 text-slate-900 dark:text-white focus:ring-2 focus:ring-blue-500">
                        </div>
                    </div>
                </div>

                <!-- Info -->
                <div
                    class="mt-6 p-4 rounded-xl bg-slate-50 dark:bg-slate-700/30 border border-slate-200 dark:border-slate-600">
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 text-sm">
                        <div>
                            <span class="text-slate-500">Terdaftar:</span>
                            <span
                                class="ml-2 font-medium text-slate-900 dark:text-white">{{ $user->created_at->format('d M Y') }}</span>
                        </div>
                        <div>
                            <span class="text-slate-500">Login Terakhir:</span>
                            <span class="ml-2 font-medium text-slate-900 dark:text-white">
                                {{ $user->last_login_at ? $user->last_login_at->diffForHumans() : 'Belum pernah' }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Footer -->
            <div
                class="px-6 lg:px-8 py-4 bg-slate-50 dark:bg-slate-700/30 border-t border-slate-200 dark:border-slate-700 rounded-b-2xl flex items-center justify-end">
                <button type="submit"
                    class="btn-ripple px-6 py-2.5 rounded-xl gradient-primary text-white font-medium text-sm shadow-lg shadow-blue-500/25 hover:shadow-xl transition-all">
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>

    @push('scripts')
        <script>
            function previewImage(input) {
                if (input.files && input.files[0]) {
                    const reader = new FileReader();
                    reader.onload = function (e) {
                        const avatarDiv = input.closest('.flex').querySelector('.w-24');
                        if (avatarDiv) {
                            avatarDiv.innerHTML = `<img src="${e.target.result}" class="w-full h-full object-cover">`;
                        }
                    };
                    reader.readAsDataURL(input.files[0]);
                }
            }
        </script>
    @endpush
@endsection