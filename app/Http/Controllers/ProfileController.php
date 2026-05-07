<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ])->withwith('status', 'profile-updated');
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $request->user()->fill($request->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

        return Redirect::route('dashboard')->with('status', 'profile-updated');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }

    public function uploadFoto(Request $request): RedirectResponse
    {
         $request->validate([
        'foto' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
    ]);

    $user     = $request->user();
    $file     = $request->file('foto');
    $filename = time() . '_' . str_replace(' ', '_', $file->getClientOriginalName());
    $path     = $file->storeAs('foto-profil', $filename, 'public');

    if ($user->foto && $user->foto !== 'default.png') {
        Storage::disk('public')->delete($user->foto);
    }

     // Debug — pastikan path tersimpan
    \Illuminate\Support\Facades\DB::table('users')
        ->where('id', $user->id)
        ->update(['foto' => $path]);

    // Auth::setUser($user->fresh());
    auth()->setUser($user->fresh());

    $user->foto = $path;
    $user->save();

    return Redirect::route('dashboard')
        ->with('status', 'foto-updated');
    }


        
    }

