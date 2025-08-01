<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ThemeController extends Controller
{
    public function toggle(Request $request)
    {
        $newTheme = $request->get('theme', 'dark');

        // Validasi tema yang valid
        $validThemes = ['light', 'dark', 'warm'];
        if (!in_array($newTheme, $validThemes)) {
            $newTheme = 'dark';
        }

        if (Auth::check()) {
            $user = Auth::user();
            $user->theme_preference = $newTheme;
            $user->save();
        } else {
            // Untuk pengunjung tanpa login, simpan ke session (default dark)
            session(['theme' => $newTheme]);
        }

        return back();
    }

    public function setTheme(Request $request)
    {
        $theme = $request->get('theme', 'dark');

        // Validasi tema yang valid
        $validThemes = ['light', 'dark', 'warm'];
        if (!in_array($theme, $validThemes)) {
            $theme = 'dark';
        }

        if (Auth::check()) {
            $user = Auth::user();
            $user->theme_preference = $theme;
            $user->save();
        } else {
            session(['theme' => $theme]);
        }

        return response()->json(['success' => true, 'theme' => $theme]);
    }
}
