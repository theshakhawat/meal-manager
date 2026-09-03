<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (auth()->attempt($credentials)) {
            $request->session()->regenerate();

            if (auth()->user()->role === 'admin') {
                return redirect()->route('admin.dashboard');
            } elseif (auth()->user()->role === 'member') {
                return redirect()->route('member.dashboard');
            }
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ]);
    }

    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);

        auth()->login($user);

        return redirect()->route('admin.dashboard');
    }

    public function redirectToGoogle()
    {
        return \Laravel\Socialite\Facades\Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback(Request $request)
    {
        try {
            $googleUser = \Laravel\Socialite\Facades\Socialite::driver('google')->user();

            $user = User::where('google_id', $googleUser->getId())
                ->orWhere('email', $googleUser->getEmail())
                ->first();

            if ($user) {
                $user->google_id = $googleUser->getId();
                if (empty($user->photo) && $googleUser->getAvatar()) {
                    $user->photo = $googleUser->getAvatar();
                }
                $user->save();
            } else {
                $user = User::create([
                    'name' => $googleUser->getName() ?? $googleUser->getNickname() ?? 'Google User',
                    'email' => $googleUser->getEmail(),
                    'google_id' => $googleUser->getId(),
                    'photo' => $googleUser->getAvatar(),
                    'password' => null,
                ]);
            }

            auth()->login($user);
            $request->session()->regenerate();

            return redirect()->route('admin.dashboard')->with('success', 'Logged in successfully with Google!');
        } catch (\Exception $e) {
            return redirect()->route('login')->with('error', 'Google authentication failed: ' . $e->getMessage());
        }
    }

    public function redirectToGitHub()
    {
        return \Laravel\Socialite\Facades\Socialite::driver('github')->redirect();
    }

    public function handleGitHubCallback(Request $request)
    {
        try {
            $githubUser = \Laravel\Socialite\Facades\Socialite::driver('github')->user();

            // If user's email is private, generate a fallback email
            $email = $githubUser->getEmail() ?? ($githubUser->getNickname() . '@users.noreply.github.com');

            $user = User::where('github_id', $githubUser->getId())
                ->orWhere('email', $email)
                ->first();

            if ($user) {
                $user->github_id = $githubUser->getId();
                if (empty($user->photo) && $githubUser->getAvatar()) {
                    $user->photo = $githubUser->getAvatar();
                }
                $user->save();
            } else {
                $user = User::create([
                    'name' => $githubUser->getName() ?? $githubUser->getNickname() ?? 'GitHub User',
                    'email' => $email,
                    'github_id' => $githubUser->getId(),
                    'photo' => $githubUser->getAvatar(),
                    'password' => null,
                ]);
            }

            auth()->login($user);
            $request->session()->regenerate();

            return redirect()->route('admin.dashboard')->with('success', 'Logged in successfully with GitHub!');
        } catch (\Exception $e) {
            return redirect()->route('login')->with('error', 'GitHub authentication failed: ' . $e->getMessage());
        }
    }

    public function logout(Request $request)
    {
        auth()->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home');
    }
}
