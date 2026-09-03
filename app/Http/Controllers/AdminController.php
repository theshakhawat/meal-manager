<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class AdminController extends Controller
{
    public function dashboard()
    {
        return view('admin.dashboard');
    }

    public function profile()
    {
        $admin = auth()->user();
        return view('admin.profile', compact('admin'));
    }

    public function updateProfile(Request $request)
    {
        $admin = auth()->user();

        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($admin->id)],
            'phone' => ['nullable', 'string', 'max:20'],
            'photo' => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp,gif', 'max:2048'],
        ]);

        if ($request->hasFile('photo')) {
            $destinationPath = public_path('uploads/avatars');
            if (!File::isDirectory($destinationPath)) {
                File::makeDirectory($destinationPath, 0755, true, true);
            }

            // Remove old photo if exists
            if ($admin->photo && File::exists(public_path('uploads/avatars/' . $admin->photo))) {
                File::delete(public_path('uploads/avatars/' . $admin->photo));
            }

            $file = $request->file('photo');
            $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move($destinationPath, $filename);
            $admin->photo = $filename;
        }

        $admin->name = $request->name;
        $admin->email = $request->email;
        $admin->phone = $request->phone;
        $admin->save();

        return redirect()->route('admin.profile')->with('success', 'Profile updated successfully!');
    }

    public function changePassword()
    {
        $admin = auth()->user();
        return view('admin.change-password', compact('admin'));
    }

    public function updatePassword(Request $request)
    {
        $admin = auth()->user();
        $hasPassword = !empty($admin->password);

        $rules = [
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ];

        if ($hasPassword) {
            $rules['current_password'] = ['required', 'string'];
        }

        $request->validate($rules);

        if ($hasPassword && !Hash::check($request->current_password, $admin->password)) {
            return back()->withErrors(['current_password' => 'Current password does not match our records.'])->withInput();
        }

        $admin->password = Hash::make($request->password);
        $admin->save();

        $message = $hasPassword ? 'Password changed successfully!' : 'Password set successfully!';
        return redirect()->route('admin.change-password')->with('success', $message);
    }
}

