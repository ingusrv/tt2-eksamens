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
        $user = $request->user();
        $panelOptions = [
            ["value" => "none", "name" => __("None")],
            ["value" => "myboards", "name" => __("My boards")],
            ["value" => "sharedboards", "name" => __("Boards shared with me")],
        ];

        if ($user->role === 1) {
            $panelOptions[] = ["value" => "allboards", "name" => __("All boards")];
            $panelOptions[] = ["value" => "allusers", "name" => __("All users")];
        }

        $panelOrder = ["myboards", "sharedboards", "allboards", "allusers"];
        // ja ir lietotāja definēts order
        if ($user->panel_order) {
            $panelOrder = explode(",", $user->panel_order);
        }

        return view('profile.edit', compact("user", "panelOrder", "panelOptions"));
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

    public function panelOrder(Request $request)
    {
        if ($request->firstPanel == null || $request->secondPanel == null) {
            return redirect()->route("profile.edit");
        }

        $user = $request->user();

        if ($user->role === 1) {
            if ($request->thirdPanel == null || $request->fourthPanel == null) {
                return redirect()->route("profile.edit");
            } else {
                $user->panel_order = $request->firstPanel . "," . $request->secondPanel . "," . $request->thirdPanel . "," . $request->fourthPanel;
            }
        } else {
            $user->panel_order = $request->firstPanel . "," . $request->secondPanel;
        }

        $user->save();

        return Redirect::route('profile.edit')->with('status', 'panel-order-updated');
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
}
