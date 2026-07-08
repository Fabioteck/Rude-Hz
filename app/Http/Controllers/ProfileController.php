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
        ]);
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

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
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

    public function editLiberatoria() {
    return view('profile.liberatoria');
}

public function updateLiberatoria(Request $request) {
    $request->validate([
        'real_name' => 'required|string|max:255',
        'tax_code' => [
            'required', 
            'string', 
            'regex:/^[A-Z]{6}[0-9LMNPQRSTUV]{2}[A-Z]{1}[0-9LMNPQRSTUV]{2}[A-Z]{1}[0-9LMNPQRSTUV]{3}[A-Z]{1}$/i'
        ],
        'accepted_terms' => 'required|accepted',
    ], [
        'tax_code.regex' => 'Il formato del Codice Fiscale non è valido.',
        'accepted_terms.accepted' => 'Devi accettare i termini della liberatoria per procedere!',
        'accepted_terms.required' => 'Devi accettare i termini della liberatoria per procedere!',
    ]);

    // Aggiorna tramite la relazione artist()
    $artist = $request->user()->artist()->firstOrCreate(['user_id' => $request->user()->id]);
    $artist->update([
        'real_name' => $request->real_name,
        'tax_code' => strtoupper($request->tax_code),
        'accepted_terms' => true,
    ]);

    return redirect()->route('user.studio')->with('success', 'Liberatoria firmata con successo. Benvenuto nello Studio!');
}

}
