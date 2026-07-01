@extends('layouts.admin')

@section('title', 'Edit Konser')
@section('breadcrumb', 'Edit Konser')

@section('admin-content')
    <div class="max-w-5xl mx-auto space-y-6">
        <!-- Header -->
        <div class="flex items-center gap-3" data-aos="fade-up">
            <a href="{{ route('admin.concerts.index') }}"
                class="p-2 rounded-lg text-slate-500 hover:bg-slate-100 dark:hover:bg-slate-700 transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
            </a>
            <div>
                <h1 class="text-2xl font-bold font-heading text-slate-900 dark:text-white">Edit Konser</h1>
                <p class="mt-1 text-slate-500">Mengubah data: <span class="font-semibold">{{ $concert->name }}</span></p>
            </div>
        </div>

        <!-- Form -->
        <form action="{{ route('admin.concerts.update', $concert) }}" method="POST" enctype="multipart/form-data"
            class="bg-white dark:bg-slate-800 rounded-2xl border border-slate-200 dark:border-slate-700 shadow-sm"
            data-aos="fade-up" data-aos-delay="100">
            @csrf
            @method('PUT')

            <div class="p-6 lg:p-8 space-y-8">
                <!-- Basic Info -->
                <div>
                    <h3 class="text-lg font-semibold text-slate-900 dark:text-white mb-4 flex items-center gap-2">
                        <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        Informasi Dasar
                    </h3>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1.5">Nama Konser
                                <span class="text-red-500">*</span></label>
                            <input type="text" name="name" value="{{ old('name', $concert->name) }}"
                                class="w-full px-4 py-2.5 rounded-xl border border-slate-200 dark:border-slate-600 bg-white dark:bg-slate-700 text-slate-900 dark:text-white focus:ring-2 focus:ring-blue-500 @error('name') border-red-500 @enderror">
                            @error('name') <p class="mt-1 text-sm text-red-500">{{ $message }}</p> @enderror
                        </div>

                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1.5">Slug
                                (URL)</label>
                            <input type="text" name="slug" value="{{ old('slug', $concert->slug) }}"
                                class="w-full px-4 py-2.5 rounded-xl border border-slate-200 dark:border-slate-600 bg-white dark:bg-slate-700 text-slate-900 dark:text-white focus:ring-2 focus:ring-blue-500 @error('slug') border-red-500 @enderror">
                            @error('slug') <p class="mt-1 text-sm text-red-500">{{ $message }}</p> @enderror
                        </div>

                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1.5">Deskripsi
                                <span class="text-red-500">*</span></label>
                            <textarea name="description" rows="4"
                                class="w-full px-4 py-2.5 rounded-xl border border-slate-200 dark:border-slate-600 bg-white dark:bg-slate-700 text-slate-900 dark:text-white focus:ring-2 focus:ring-blue-500 resize-none @error('description') border-red-500 @enderror">{{ old('description', $concert->description) }}</textarea>
                            @error('description') <p class="mt-1 text-sm text-red-500">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1.5">Venue <span
                                    class="text-red-500">*</span></label>
                            <input type="text" name="venue" value="{{ old('venue', $concert->venue) }}"
                                class="w-full px-4 py-2.5 rounded-xl border border-slate-200 dark:border-slate-600 bg-white dark:bg-slate-700 text-slate-900 dark:text-white focus:ring-2 focus:ring-blue-500 @error('venue') border-red-500 @enderror">
                            @error('venue') <p class="mt-1 text-sm text-red-500">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1.5">Lokasi <span
                                    class="text-red-500">*</span></label>
                            <input type="text" name="location" value="{{ old('location', $concert->location) }}"
                                class="w-full px-4 py-2.5 rounded-xl border border-slate-200 dark:border-slate-600 bg-white dark:bg-slate-700 text-slate-900 dark:text-white focus:ring-2 focus:ring-blue-500 @error('location') border-red-500 @enderror">
                            @error('location') <p class="mt-1 text-sm text-red-500">{{ $message }}</p> @enderror
                        </div>
                    </div>
                </div>

                <hr class="border-slate-200 dark:border-slate-700">

                <!-- Dates & Capacity -->
                <div>
                    <h3 class="text-lg font-semibold text-slate-900 dark:text-white mb-4 flex items-center gap-2">
                        <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                        Tanggal & Kapasitas
                    </h3>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                        <div>
                            <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1.5">Tanggal Mulai
                                <span class="text-red-500">*</span></label>
                            <input type="datetime-local" name="start_date"
                                value="{{ old('start_date', $concert->start_date->format('Y-m-d\TH:i')) }}"
                                class="w-full px-4 py-2.5 rounded-xl border border-slate-200 dark:border-slate-600 bg-white dark:bg-slate-700 text-slate-900 dark:text-white focus:ring-2 focus:ring-blue-500 @error('start_date') border-red-500 @enderror">
                            @error('start_date') <p class="mt-1 text-sm text-red-500">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1.5">Tanggal
                                Selesai</label>
                            <input type="datetime-local" name="end_date"
                                value="{{ old('end_date', $concert->end_date?->format('Y-m-d\TH:i')) }}"
                                class="w-full px-4 py-2.5 rounded-xl border border-slate-200 dark:border-slate-600 bg-white dark:bg-slate-700 text-slate-900 dark:text-white focus:ring-2 focus:ring-blue-500 @error('end_date') border-red-500 @enderror">
                            @error('end_date') <p class="mt-1 text-sm text-red-500">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1.5">Penjualan
                                Tiket Mulai</label>
                            <input type="datetime-local" name="ticket_sales_start"
                                value="{{ old('ticket_sales_start', $concert->ticket_sales_start?->format('Y-m-d\TH:i')) }}"
                                class="w-full px-4 py-2.5 rounded-xl border border-slate-200 dark:border-slate-600 bg-white dark:bg-slate-700 text-slate-900 dark:text-white focus:ring-2 focus:ring-blue-500 @error('ticket_sales_start') border-red-500 @enderror">
                            @error('ticket_sales_start') <p class="mt-1 text-sm text-red-500">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1.5">Penjualan
                                Tiket Selesai</label>
                            <input type="datetime-local" name="ticket_sales_end"
                                value="{{ old('ticket_sales_end', $concert->ticket_sales_end?->format('Y-m-d\TH:i')) }}"
                                class="w-full px-4 py-2.5 rounded-xl border border-slate-200 dark:border-slate-600 bg-white dark:bg-slate-700 text-slate-900 dark:text-white focus:ring-2 focus:ring-blue-500 @error('ticket_sales_end') border-red-500 @enderror">
                            @error('ticket_sales_end') <p class="mt-1 text-sm text-red-500">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1.5">Kapasitas
                                <span class="text-red-500">*</span></label>
                            <input type="number" name="capacity" value="{{ old('capacity', $concert->capacity) }}" min="1"
                                class="w-full px-4 py-2.5 rounded-xl border border-slate-200 dark:border-slate-600 bg-white dark:bg-slate-700 text-slate-900 dark:text-white focus:ring-2 focus:ring-blue-500 @error('capacity') border-red-500 @enderror">
                            @error('capacity') <p class="mt-1 text-sm text-red-500">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1.5">Harga Tiket
                                (Rp) <span class="text-red-500">*</span></label>
                            <input type="number" name="ticket_price"
                                value="{{ old('ticket_price', $concert->ticket_price) }}" min="0"
                                class="w-full px-4 py-2.5 rounded-xl border border-slate-200 dark:border-slate-600 bg-white dark:bg-slate-700 text-slate-900 dark:text-white focus:ring-2 focus:ring-blue-500 @error('ticket_price') border-red-500 @enderror">
                            @error('ticket_price') <p class="mt-1 text-sm text-red-500">{{ $message }}</p> @enderror
                        </div>
                    </div>
                </div>

                <hr class="border-slate-200 dark:border-slate-700">

                <!-- Image & Lineup -->
                <div>
                    <h3 class="text-lg font-semibold text-slate-900 dark:text-white mb-4 flex items-center gap-2">
                        <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                        Gambar & Line Up
                    </h3>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                        <div>
                            <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1.5">Poster
                                Konser</label>
                            <input type="file" name="image" accept="image/*" onchange="previewImage(this)"
                                class="w-full px-4 py-2.5 rounded-xl border border-slate-200 dark:border-slate-600 bg-white dark:bg-slate-700 text-slate-900 dark:text-white focus:ring-2 focus:ring-blue-500 @error('image') border-red-500 @enderror">
                            <p class="mt-1 text-xs text-slate-500">JPG, PNG, WEBP. Maksimal 2MB. Kosongkan jika tidak ingin
                                mengubah.</p>
                            @error('image') <p class="mt-1 text-sm text-red-500">{{ $message }}</p> @enderror

                            @if($concert->image)
                                <div class="mt-4">
                                    <p class="text-xs text-slate-500 mb-2">Gambar saat ini:</p>
                                    <img src="{{ asset('storage/' . $concert->image) }}" alt="Current"
                                        class="w-full h-48 object-cover rounded-xl border border-slate-200 dark:border-slate-600">
                                </div>
                            @endif

                            <div id="imagePreview" class="mt-4 hidden">
                                <p class="text-xs text-slate-500 mb-2">Preview baru:</p>
                                <img id="previewImg" src="" alt="Preview"
                                    class="w-full h-48 object-cover rounded-xl border border-slate-200 dark:border-slate-600">
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1.5">Line Up (satu
                                per baris)</label>
                            <textarea name="lineup" rows="8" placeholder="Tulus&#10;Raisa&#10;Pamungkas"
                                class="w-full px-4 py-2.5 rounded-xl border border-slate-200 dark:border-slate-600 bg-white dark:bg-slate-700 text-slate-900 dark:text-white focus:ring-2 focus:ring-blue-500 resize-none @error('lineup') border-red-500 @enderror">{{ old('lineup', is_array($concert->lineup) ? implode("\n", $concert->lineup) : '') }}</textarea>
                            @error('lineup') <p class="mt-1 text-sm text-red-500">{{ $message }}</p> @enderror
                        </div>
                    </div>
                </div>

                <hr class="border-slate-200 dark:border-slate-700">

                <!-- Status -->
                <div>
                    <h3 class="text-lg font-semibold text-slate-900 dark:text-white mb-4 flex items-center gap-2">
                        <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        Status
                    </h3>

                    <div class="grid grid-cols-2 md:grid-cols-5 gap-3">
                        @php
                            $statuses = [
                                'draft' => ['label' => 'Draft', 'color' => 'amber'],
                                'published' => ['label' => 'Published', 'color' => 'blue'],
                                'ongoing' => ['label' => 'Ongoing', 'color' => 'emerald'],
                                'completed' => ['label' => 'Completed', 'color' => 'slate'],
                                'cancelled' => ['label' => 'Cancelled', 'color' => 'red'],
                            ];
                        @endphp
                        @foreach($statuses as $value => $info)
                            <label class="cursor-pointer">
                                <input type="radio" name="status" value="{{ $value }}" {{ old('status', $concert->status) === $value ? 'checked' : '' }} class="peer sr-only">
                                <div
                                    class="p-3 rounded-xl border-2 border-slate-200 dark:border-slate-700 peer-checked:border-{{ $info['color'] }}-500 peer-checked:bg-{{ $info['color'] }}-50 dark:peer-checked:bg-{{ $info['color'] }}-900/20 text-center transition-all hover:border-slate-300">
                                    <p class="text-sm font-medium text-slate-900 dark:text-white">{{ $info['label'] }}</p>
                                </div>
                            </label>
                        @endforeach
                    </div>
                    @error('status') <p class="mt-2 text-sm text-red-500">{{ $message }}</p> @enderror
                </div>

                <!-- Stats -->
                <div class="p-4 rounded-xl bg-slate-50 dark:bg-slate-700/30 border border-slate-200 dark:border-slate-600">
                    <h4 class="text-sm font-semibold text-slate-700 dark:text-slate-300 mb-3">Statistik</h4>
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-3 text-sm">
                        <div>
                            <span class="text-slate-500">Dibuat:</span>
                            <p class="font-medium text-slate-900 dark:text-white">
                                {{ $concert->created_at->format('d M Y') }}</p>
                        </div>
                        <div>
                            <span class="text-slate-500">Tiket Terjual:</span>
                            <p class="font-medium text-emerald-600">{{ number_format($concert->tickets_sold) }}</p>
                        </div>
                        <div>
                            <span class="text-slate-500">Sisa Tiket:</span>
                            <p class="font-medium text-blue-600">{{ number_format($concert->available_tickets) }}</p>
                        </div>
                        <div>
                            <span class="text-slate-500">Terjual:</span>
                            <p class="font-medium text-slate-900 dark:text-white">
                                {{ $concert->capacity > 0 ? round(($concert->tickets_sold / $concert->capacity) * 100) : 0 }}%
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Footer -->
            <div
                class="px-6 lg:px-8 py-4 bg-slate-50 dark:bg-slate-700/30 border-t border-slate-200 dark:border-slate-700 rounded-b-2xl flex items-center justify-end gap-3">
                <a href="{{ route('admin.concerts.index') }}"
                    class="px-5 py-2.5 rounded-xl border border-slate-200 dark:border-slate-600 text-slate-600 dark:text-slate-400 font-medium text-sm hover:bg-slate-100 dark:hover:bg-slate-700 transition-all">
                    Batal
                </a>
                <button type="submit"
                    class="btn-ripple px-6 py-2.5 rounded-xl gradient-primary text-white font-medium text-sm shadow-lg shadow-blue-500/25 hover:shadow-xl transition-all">
                    Update Konser
                </button>
            </div>
        </form>
    </div>

    @push('scripts')
        <script>
            function previewImage(input) {
                const preview = document.getElementById('imagePreview');
                const img = document.getElementById('previewImg');

                if (input.files && input.files[0]) {
                    const reader = new FileReader();
                    reader.onload = function (e) {
                        img.src = e.target.result;
                        preview.classList.remove('hidden');
                    };
                    reader.readAsDataURL(input.files[0]);
                } else {
                    preview.classList.add('hidden');
                }
            }
        </script>
    @endpush
@endsection