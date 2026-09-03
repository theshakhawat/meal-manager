@extends('layouts.admin.app')

@section('content')
  @php
    $hasPassword = !empty($admin->password);
  @endphp

  <!-- Page Header Banner -->
  <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 bg-white dark:bg-zinc-900 p-6 rounded-2xl border border-slate-100 dark:border-zinc-800/80 shadow-sm mb-6">
    <div>
      <div class="flex items-center gap-2 text-xs font-semibold text-brand-700 dark:text-brand-500 uppercase tracking-wider mb-1">
        <a href="{{ route('admin.profile') }}" class="hover:underline flex items-center gap-1">
          <i class="fa-solid fa-arrow-left text-[10px]"></i>
          <span>Profile Settings</span>
        </a>
        <span>/</span>
        <span>Security</span>
      </div>
      <h1 class="text-xl sm:text-2xl font-bold tracking-tight text-slate-900 dark:text-white">
        {{ $hasPassword ? 'Change Password' : 'Set Account Password' }}
      </h1>
      <p class="text-xs sm:text-sm text-slate-500 dark:text-zinc-400 mt-1">
        {{ $hasPassword
            ? 'Update your password to keep your administrator account safe and protected.'
            : 'You logged in using Google or social signup. Create a password to enable password-based login.' }}
      </p>
    </div>
    <div class="flex items-center gap-2">
      <a href="{{ route('admin.profile') }}" class="py-2.5 px-4 rounded-xl border border-slate-200 dark:border-zinc-800 text-slate-700 dark:text-zinc-300 hover:bg-slate-100 dark:hover:bg-zinc-800 text-xs font-semibold transition-all flex items-center gap-2">
        <i class="fa-regular fa-user"></i>
        <span>Back to Profile</span>
      </a>
    </div>
  </div>

  <!-- Google/Social Auth Info Notice if No Password -->
  @if (!$hasPassword)
    <div class="mb-6 p-4 rounded-2xl bg-blue-50 dark:bg-blue-950/40 border border-blue-200 dark:border-blue-900/60 text-blue-900 dark:text-blue-200 flex items-start gap-3.5 shadow-sm">
      <div class="w-8 h-8 rounded-xl bg-blue-500 text-white flex items-center justify-center text-sm shadow-sm flex-shrink-0 mt-0.5">
        <i class="fa-solid fa-circle-info"></i>
      </div>
      <div>
        <h4 class="font-bold text-xs sm:text-sm">No Current Password Required</h4>
        <p class="text-xs opacity-90 mt-0.5 leading-relaxed">
          Your account was registered via Google / Social Authentication without a password. You can set a new password directly below without providing any current password.
        </p>
      </div>
    </div>
  @endif

  <!-- Success Notification -->
  @if (session('success') || session('status'))
    <div x-data="{ show: true }" x-show="show" x-transition class="mb-6 p-4 rounded-2xl bg-brand-50 dark:bg-brand-950/30 border border-brand-200 dark:border-brand-800/60 text-brand-900 dark:text-brand-200 flex items-start justify-between shadow-sm">
      <div class="flex items-center gap-3">
        <div class="w-8 h-8 rounded-xl bg-brand-500 text-white flex items-center justify-center text-sm shadow-sm flex-shrink-0">
          <i class="fa-solid fa-check"></i>
        </div>
        <div>
          <p class="font-semibold text-sm">Success</p>
          <p class="text-xs opacity-90">{{ session('success') ?? session('status') }}</p>
        </div>
      </div>
      <button @click="show = false" class="text-brand-700 dark:text-brand-400 hover:text-brand-900 p-1">
        <i class="fa-solid fa-xmark"></i>
      </button>
    </div>
  @endif

  <!-- Validation Errors Notification -->
  @if ($errors->any())
    <div x-data="{ show: true }" x-show="show" x-transition class="mb-6 p-4 rounded-2xl bg-red-50 dark:bg-red-950/30 border border-red-200 dark:border-red-800/60 text-red-900 dark:text-red-200 flex items-start justify-between shadow-sm">
      <div class="flex items-start gap-3">
        <div class="w-8 h-8 rounded-xl bg-red-500 text-white flex items-center justify-center text-sm shadow-sm flex-shrink-0 mt-0.5">
          <i class="fa-solid fa-triangle-exclamation"></i>
        </div>
        <div>
          <p class="font-semibold text-sm">Operation failed</p>
          <ul class="text-xs list-disc list-inside mt-1 space-y-0.5 opacity-90">
            @foreach ($errors->all() as $error)
              <li>{{ $error }}</li>
            @endforeach
          </ul>
        </div>
      </div>
      <button @click="show = false" class="text-red-700 dark:text-red-400 hover:text-red-900 p-1">
        <i class="fa-solid fa-xmark"></i>
      </button>
    </div>
  @endif

  <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

  

    <!-- Right Column: Change / Set Password Form Card -->
    <div class="lg:col-span-2">
      <div class="bg-white dark:bg-zinc-900 p-6 sm:p-7 rounded-2xl border border-slate-100 dark:border-zinc-800/80 shadow-sm">
        <div class="flex items-center justify-between pb-5 border-b border-slate-100 dark:border-zinc-800 mb-6">
          <div>
            <h2 class="text-base font-bold text-slate-900 dark:text-white flex items-center gap-2">
              <i class="fa-solid fa-key text-brand-700 dark:text-brand-500"></i>
              {{ $hasPassword ? 'Update Your Password' : 'Create a Password' }}
            </h2>
            <p class="text-xs text-slate-500 dark:text-zinc-400 mt-0.5">
              {{ $hasPassword
                  ? 'Please provide your current password followed by your new chosen password.'
                  : 'Enter a secure password for your account. No current password is required.' }}
            </p>
          </div>
        </div>

        <form method="POST" action="{{ route('admin.change-password.update') }}" class="space-y-5">
          @csrf
          @method('PUT')

          <!-- Current Password (ONLY shown if user already has a password) -->
          @if ($hasPassword)
            <div>
              <label for="current_password" class="block text-xs font-semibold text-slate-700 dark:text-zinc-300 mb-1.5">
                Current Password <span class="text-red-500">*</span>
              </label>
              <div class="relative" x-data="{ show: false }">
                <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400 dark:text-zinc-500 text-xs">
                  <i class="fa-solid fa-lock"></i>
                </div>
                <input :type="show ? 'text' : 'password'"
                       name="current_password"
                       id="current_password"
                       required
                       autocomplete="current-password"
                       placeholder="Enter your current password"
                       class="w-full pl-9 pr-10 py-2.5 text-xs sm:text-sm rounded-xl border {{ $errors->has('current_password') ? 'border-red-400 focus:ring-red-400/20' : 'border-slate-200 dark:border-zinc-800 focus:border-brand-700 dark:focus:border-brand-500 focus:ring-brand-600/20' }} bg-slate-50 dark:bg-zinc-950 text-slate-900 dark:text-white focus:outline-none focus:ring-2 transition-all">
                <button type="button" @click="show = !show" class="absolute inset-y-0 right-0 pr-3.5 flex items-center text-slate-400 hover:text-slate-600 dark:hover:text-zinc-200 text-xs">
                  <i class="fa-solid" :class="show ? 'fa-eye-slash' : 'fa-eye'"></i>
                </button>
              </div>
              @error('current_password')
                <p class="text-red-500 text-xs mt-1.5 flex items-center gap-1"><i class="fa-solid fa-circle-exclamation"></i> {{ $message }}</p>
              @enderror
            </div>
          @endif

          <!-- New Password -->
          <div>
            <label for="password" class="block text-xs font-semibold text-slate-700 dark:text-zinc-300 mb-1.5">
              New Password <span class="text-red-500">*</span>
            </label>
            <div class="relative" x-data="{ show: false }">
              <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400 dark:text-zinc-500 text-xs">
                <i class="fa-solid fa-key"></i>
              </div>
              <input :type="show ? 'text' : 'password'"
                     name="password"
                     id="password"
                     required
                     autocomplete="new-password"
                     placeholder="Enter new password (min. 8 characters)"
                     class="w-full pl-9 pr-10 py-2.5 text-xs sm:text-sm rounded-xl border {{ $errors->has('password') ? 'border-red-400 focus:ring-red-400/20' : 'border-slate-200 dark:border-zinc-800 focus:border-brand-700 dark:focus:border-brand-500 focus:ring-brand-600/20' }} bg-slate-50 dark:bg-zinc-950 text-slate-900 dark:text-white focus:outline-none focus:ring-2 transition-all">
              <button type="button" @click="show = !show" class="absolute inset-y-0 right-0 pr-3.5 flex items-center text-slate-400 hover:text-slate-600 dark:hover:text-zinc-200 text-xs">
                <i class="fa-solid" :class="show ? 'fa-eye-slash' : 'fa-eye'"></i>
              </button>
            </div>
            @error('password')
              <p class="text-red-500 text-xs mt-1.5 flex items-center gap-1"><i class="fa-solid fa-circle-exclamation"></i> {{ $message }}</p>
            @enderror
          </div>

          <!-- Confirm New Password -->
          <div>
            <label for="password_confirmation" class="block text-xs font-semibold text-slate-700 dark:text-zinc-300 mb-1.5">
              Confirm New Password <span class="text-red-500">*</span>
            </label>
            <div class="relative" x-data="{ show: false }">
              <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400 dark:text-zinc-500 text-xs">
                <i class="fa-solid fa-shield-halved"></i>
              </div>
              <input :type="show ? 'text' : 'password'"
                     name="password_confirmation"
                     id="password_confirmation"
                     required
                     autocomplete="new-password"
                     placeholder="Repeat new password"
                     class="w-full pl-9 pr-10 py-2.5 text-xs sm:text-sm rounded-xl border border-slate-200 dark:border-zinc-800 bg-slate-50 dark:bg-zinc-950 text-slate-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-brand-600/20 focus:border-brand-700 dark:focus:border-brand-500 transition-all">
              <button type="button" @click="show = !show" class="absolute inset-y-0 right-0 pr-3.5 flex items-center text-slate-400 hover:text-slate-600 dark:hover:text-zinc-200 text-xs">
                <i class="fa-solid" :class="show ? 'fa-eye-slash' : 'fa-eye'"></i>
              </button>
            </div>
          </div>

          <!-- Action Buttons -->
          <div class="pt-4 border-t border-slate-100 dark:border-zinc-800 flex items-center justify-between">
            <a href="{{ route('admin.profile') }}" class="py-2.5 px-4 rounded-xl text-slate-600 dark:text-zinc-400 hover:bg-slate-100 dark:hover:bg-zinc-800 text-xs font-semibold transition-colors">
              Cancel
            </a>
            <button type="submit" class="py-2.5 px-6 bg-brand-800 hover:bg-brand-900 dark:bg-brand-600 dark:hover:bg-brand-500 text-white font-medium text-xs sm:text-sm rounded-xl transition-all shadow-sm flex items-center gap-2">
              <i class="fa-solid {{ $hasPassword ? 'fa-shield-check' : 'fa-key' }}"></i>
              <span>{{ $hasPassword ? 'Save New Password' : 'Set Password' }}</span>
            </button>
          </div>
        </form>
      </div>
    </div>

  </div>
@endsection
