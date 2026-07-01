<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Concert;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\View\View;

class ConcertController extends Controller
{
    /**
     * Display a listing of concerts.
     */
    public function index(Request $request): View
    {
        $query = Concert::query();

        // Search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('venue', 'like', "%{$search}%")
                    ->orWhere('location', 'like', "%{$search}%");
            });
        }

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter by date range
        if ($request->filled('date_from')) {
            $query->whereDate('start_date', '>=', $request->date_from);
        }
        if ($request->filled('date_to')) {
            $query->whereDate('start_date', '<=', $request->date_to);
        }

        $concerts = $query->latest('start_date')->paginate(10)->withQueryString();

        return view('admin.concerts.index', compact('concerts'));
    }

    /**
     * Show the form for creating a new concert.
     */
    public function create(): View
    {
        return view('admin.concerts.create');
    }

    /**
     * Store a newly created concert.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'slug' => ['nullable', 'string', 'max:255', 'unique:concerts,slug'],
            'description' => ['required', 'string'],
            'venue' => ['required', 'string', 'max:255'],
            'location' => ['required', 'string', 'max:255'],
            'start_date' => ['required', 'date', 'after:now'],
            'end_date' => ['nullable', 'date', 'after:start_date'],
            'ticket_sales_start' => ['nullable', 'date'],
            'ticket_sales_end' => ['nullable', 'date', 'after:ticket_sales_start'],
            'capacity' => ['required', 'integer', 'min:1'],
            'ticket_price' => ['required', 'numeric', 'min:0'],
            'status' => ['required', 'in:draft,published,ongoing,completed,cancelled'],
            'image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
            'lineup' => ['nullable', 'string'],
        ], [
            'name.required' => 'Nama konser wajib diisi.',
            'description.required' => 'Deskripsi wajib diisi.',
            'venue.required' => 'Venue wajib diisi.',
            'location.required' => 'Lokasi wajib diisi.',
            'start_date.required' => 'Tanggal mulai wajib diisi.',
            'start_date.after' => 'Tanggal mulai harus di masa depan.',
            'capacity.required' => 'Kapasitas wajib diisi.',
            'capacity.min' => 'Kapasitas minimal 1.',
            'ticket_price.required' => 'Harga tiket wajib diisi.',
            'ticket_price.min' => 'Harga tiket minimal 0.',
            'image.image' => 'File harus berupa gambar.',
            'image.mimes' => 'Format gambar: JPG, JPEG, PNG, WEBP.',
            'image.max' => 'Ukuran gambar maksimal 2MB.',
        ]);

        try {
            // Handle image upload
            if ($request->hasFile('image')) {
                $validated['image'] = $request->file('image')->store('concerts', 'public');
            }

            // Parse lineup from textarea (one per line)
            if (!empty($validated['lineup'])) {
                $validated['lineup'] = array_filter(array_map('trim', explode("\n", $validated['lineup'])));
            } else {
                $validated['lineup'] = [];
            }

            // Generate slug if empty
            if (empty($validated['slug'])) {
                $validated['slug'] = Str::slug($validated['name']) . '-' . Str::random(5);
            }

            Concert::create($validated);

            return redirect()->route('admin.concerts.index')
                ->with('success', 'Konser berhasil ditambahkan!');
        } catch (\Throwable $e) {
            report($e);
            return back()->withInput()->with('error', 'Gagal menambahkan konser.');
        }
    }

    /**
     * Display the specified concert.
     */
    public function show(Concert $concert): View
    {
        $concert->loadCount('tickets');

        $ticketsByStatus = $concert->tickets()
            ->selectRaw('status, count(*) as count')
            ->groupBy('status')
            ->pluck('count', 'status')
            ->toArray();

        return view('admin.concerts.show', compact('concert', 'ticketsByStatus'));
    }

    /**
     * Show the form for editing the specified concert.
     */
    public function edit(Concert $concert): View
    {
        return view('admin.concerts.edit', compact('concert'));
    }

    /**
     * Update the specified concert.
     */
    public function update(Request $request, Concert $concert): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'slug' => ['nullable', 'string', 'max:255', 'unique:concerts,slug,' . $concert->id],
            'description' => ['required', 'string'],
            'venue' => ['required', 'string', 'max:255'],
            'location' => ['required', 'string', 'max:255'],
            'start_date' => ['required', 'date'],
            'end_date' => ['nullable', 'date', 'after:start_date'],
            'ticket_sales_start' => ['nullable', 'date'],
            'ticket_sales_end' => ['nullable', 'date', 'after:ticket_sales_start'],
            'capacity' => ['required', 'integer', 'min:1'],
            'ticket_price' => ['required', 'numeric', 'min:0'],
            'status' => ['required', 'in:draft,published,ongoing,completed,cancelled'],
            'image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
            'lineup' => ['nullable', 'string'],
        ]);

        try {
            // Handle image upload
            if ($request->hasFile('image')) {
                // Delete old image
                if ($concert->image) {
                    Storage::disk('public')->delete($concert->image);
                }
                $validated['image'] = $request->file('image')->store('concerts', 'public');
            }

            // Parse lineup
            if (!empty($validated['lineup'])) {
                $validated['lineup'] = array_filter(array_map('trim', explode("\n", $validated['lineup'])));
            } else {
                $validated['lineup'] = [];
            }

            // Generate slug if empty
            if (empty($validated['slug'])) {
                $validated['slug'] = Str::slug($validated['name']) . '-' . Str::random(5);
            }

            $concert->update($validated);

            return redirect()->route('admin.concerts.index')
                ->with('success', 'Konser berhasil diperbarui!');
        } catch (\Throwable $e) {
            report($e);
            return back()->withInput()->with('error', 'Gagal memperbarui konser.');
        }
    }

    /**
     * Remove the specified concert.
     */
    public function destroy(Concert $concert): RedirectResponse
    {
        try {
            // Check if concert has tickets
            if ($concert->tickets()->count() > 0) {
                return back()->with('error', 'Tidak dapat menghapus konser yang sudah memiliki tiket.');
            }

            // Delete image
            if ($concert->image) {
                Storage::disk('public')->delete($concert->image);
            }

            $concert->delete();

            return redirect()->route('admin.concerts.index')
                ->with('success', 'Konser berhasil dihapus!');
        } catch (\Throwable $e) {
            report($e);
            return back()->with('error', 'Gagal menghapus konser.');
        }
    }

    /**
     * Update concert status.
     */
    public function updateStatus(Request $request, Concert $concert): RedirectResponse
    {
        $validated = $request->validate([
            'status' => ['required', 'in:draft,published,ongoing,completed,cancelled'],
        ]);

        try {
            $concert->update(['status' => $validated['status']]);

            return back()->with('success', 'Status konser berhasil diperbarui!');
        } catch (\Throwable $e) {
            report($e);
            return back()->with('error', 'Gagal memperbarui status.');
        }
    }
}