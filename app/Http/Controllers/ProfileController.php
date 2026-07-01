<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileRequest;
use App\Models\ActivityLog;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Show profile edit form.
     */
    public function edit(): View
    {
        $user = auth()->user();
        return view('admin.profile.edit', compact('user'));
    }

    /**
     * Update profile.
     */
    public function update(ProfileRequest $request): RedirectResponse
    {
        try {
            $user = auth()->user();
            $data = $request->only(['name', 'email', 'phone']);

            // Handle password change
            if ($request->filled('new_password')) {
                $data['password'] = Hash::make($request->new_password);
            }

            // Handle avatar upload
            if ($request->hasFile('avatar')) {
                // Delete old avatar if exists
                if ($user->avatar && Storage::disk('public')->exists($user->avatar)) {
                    Storage::disk('public')->delete($user->avatar);
                }

                // Store new avatar
                $path = $request->file('avatar')->store('avatars', 'public');
                $data['avatar'] = $path;
            }

            $user->update($data);

            ActivityLog::log(
                action: 'update',
                description: 'Updated profile',
                modelType: \App\Models\User::class,
                modelId: $user->id
            );

            return redirect()->back()
                ->with('success', 'Profil berhasil diperbarui.');
        } catch (\Throwable $e) {
            report($e);

            return back()
                ->withInput()
                ->with('error', 'Gagal memperbarui profil.');
        }
    }

    /**
     * Remove avatar.
     */
    public function removeAvatar(): RedirectResponse
    {
        try {
            $user = auth()->user();

            if ($user->avatar && Storage::disk('public')->exists($user->avatar)) {
                Storage::disk('public')->delete($user->avatar);
            }

            $user->update(['avatar' => null]);

            return redirect()->back()
                ->with('success', 'Foto profil berhasil dihapus.');
        } catch (\Throwable $e) {
            report($e);

            return back()->with('error', 'Gagal menghapus foto profil.');
        }
    }
}