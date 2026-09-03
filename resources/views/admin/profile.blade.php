@extends('layouts.admin.app')

@section('content')
@php
  $hasPassword = !empty($admin->password);
@endphp

  <!-- Page Header Banner -->
  <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 bg-white dark:bg-zinc-900 p-6 rounded-2xl border border-slate-100 dark:border-zinc-800/80 shadow-sm mb-6">
    <div>
      <div class="flex items-center gap-2 text-xs font-semibold text-brand-700 dark:text-brand-500 uppercase tracking-wider mb-1">
        <i class="fa-solid fa-user-gear"></i>
        <span>Account Settings</span>
      </div>
      <h1 class="text-xl sm:text-2xl font-bold tracking-tight text-slate-900 dark:text-white">Admin Profile</h1>
      <p class="text-xs sm:text-sm text-slate-500 dark:text-zinc-400 mt-1">Manage your personal information, contact details, and account preferences.</p>
    </div>
    <div class="flex items-center gap-3">
      <a href="{{ route('admin.change-password') }}" class="py-2.5 px-4 bg-slate-100 hover:bg-slate-200 dark:bg-zinc-800 dark:hover:bg-zinc-700 text-slate-700 dark:text-zinc-200 font-medium text-xs sm:text-sm rounded-xl transition-all shadow-sm flex items-center gap-2 border border-slate-200 dark:border-zinc-700">
        <i class="fa-solid {{ $hasPassword ? 'fa-key' : 'fa-lock-open' }} text-brand-700 dark:text-brand-500"></i>
        <span>{{ $hasPassword ? 'Change Password' : 'Set Password' }}</span>
      </a>
    </div>
  </div>

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
          <p class="font-semibold text-sm">Please check the form for errors</p>
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

  <!-- Main Grid Content -->
  <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

    <!-- Left Column: User Summary Card & Security Link -->
    <div class="lg:col-span-1 space-y-6">
      <!-- Profile Card -->
      <div class="bg-white dark:bg-zinc-900 p-6 rounded-2xl border border-slate-100 dark:border-zinc-800/80 shadow-sm text-center">
        <div class="relative inline-block mx-auto mb-4">
          <img id="avatarDisplay"
               src="{{ $admin->avatar_url }}"
               alt="{{ $admin->name }}"
               class="w-24 h-24 sm:w-28 sm:h-28 rounded-2xl object-cover border-4 border-slate-50 dark:border-zinc-800 shadow-md">
          <span class="absolute bottom-1 right-1 w-4 h-4 rounded-full bg-brand-500 border-2 border-white dark:border-zinc-900" title="Active"></span>
        </div>

        <h2 class="text-lg font-bold text-slate-900 dark:text-white">{{ $admin->name }}</h2>
        <p class="text-xs text-slate-500 dark:text-zinc-400 mt-0.5">{{ $admin->email }}</p>

        <div class="mt-4 flex flex-wrap justify-center gap-2">
          <span class="px-2.5 py-1 rounded-full text-[11px] font-semibold bg-brand-50 text-brand-800 border border-brand-200/70 dark:bg-zinc-800 dark:text-brand-400 dark:border-zinc-700">
            <i class="fa-solid fa-shield-halved text-[10px] mr-1"></i> Administrator
          </span>
          @if ($admin->phone)
            <span class="px-2.5 py-1 rounded-full text-[11px] font-medium bg-slate-100 text-slate-700 dark:bg-zinc-800 dark:text-zinc-300">
              <i class="fa-solid fa-phone text-[10px] mr-1"></i> {{ $admin->phone }}
            </span>
          @endif
        </div>

        <!-- Account Details List -->
        <div class="mt-6 pt-6 border-t border-slate-100 dark:border-zinc-800 text-left space-y-3">
          <div class="flex justify-between items-center text-xs">
            <span class="text-slate-500 dark:text-zinc-400">Account ID:</span>
            <span class="font-semibold text-slate-700 dark:text-zinc-200">#{{ str_pad($admin->id, 4, '0', STR_PAD_LEFT) }}</span>
          </div>
          <div class="flex justify-between items-center text-xs">
            <span class="text-slate-500 dark:text-zinc-400">Joined Date:</span>
            <span class="font-semibold text-slate-700 dark:text-zinc-200">{{ $admin->created_at ? $admin->created_at->format('M d, Y') : 'N/A' }}</span>
          </div>
          <div class="flex justify-between items-center text-xs">
            <span class="text-slate-500 dark:text-zinc-400">Last Profile Update:</span>
            <span class="font-semibold text-slate-700 dark:text-zinc-200">{{ $admin->updated_at ? $admin->updated_at->diffForHumans() : 'Just now' }}</span>
          </div>
        </div>

        <!-- Quick Logout Action -->
        <div class="mt-6 pt-5 border-t border-slate-100 dark:border-zinc-800">
          <form method="POST" action="{{ route('admin.logout') }}">
            @csrf
            <button type="submit" class="w-full py-2.5 px-4 rounded-xl border border-red-200 dark:border-red-900/60 text-red-600 dark:text-red-400 hover:bg-red-50 dark:hover:bg-red-950/30 text-xs font-semibold transition-all flex items-center justify-center gap-2">
              <i class="fa-solid fa-arrow-right-from-bracket"></i>
              <span>Log Out From Account</span>
            </button>
          </form>
        </div>
      </div>

      <!-- Security Quick Link Card -->
      <div class="bg-white dark:bg-zinc-900 p-5 rounded-2xl border border-slate-100 dark:border-zinc-800/80 shadow-sm">
        <div class="flex items-center justify-between mb-3">
          <div class="flex items-center gap-2 text-xs font-bold text-slate-900 dark:text-white">
            <i class="fa-solid fa-lock text-brand-700 dark:text-brand-500"></i>
            <span>Account Security</span>
          </div>
          <span class="text-[10px] {{ $hasPassword ? 'text-brand-700 dark:text-brand-500' : 'text-amber-600 dark:text-amber-400' }} font-semibold">
            {{ $hasPassword ? 'Password Protected' : 'Password Not Set' }}
          </span>
        </div>
        <p class="text-xs text-slate-500 dark:text-zinc-400 mb-4">
          {{ $hasPassword
              ? 'Want to update your account password? Visit the dedicated password change page.'
              : 'You signed in via Google / Social login. You can set a password here anytime without a current password.' }}
        </p>
        <a href="{{ route('admin.change-password') }}" class="w-full py-2 px-3 rounded-xl bg-slate-50 hover:bg-slate-100 dark:bg-zinc-800/80 dark:hover:bg-zinc-800 text-slate-700 dark:text-zinc-200 text-xs font-semibold transition-colors flex items-center justify-center gap-2 border border-slate-200/80 dark:border-zinc-700">
          <i class="fa-solid {{ $hasPassword ? 'fa-key' : 'fa-lock-open' }} text-xs text-brand-700 dark:text-brand-500"></i>
          <span>{{ $hasPassword ? 'Go to Change Password' : 'Set Account Password' }}</span>
        </a>
      </div>
    </div>

    <!-- Right Column: Profile Edit Form (2 Cols) -->
    <div class="lg:col-span-2">
      <div class="bg-white dark:bg-zinc-900 p-6 sm:p-7 rounded-2xl border border-slate-100 dark:border-zinc-800/80 shadow-sm">
        <div class="flex items-center justify-between pb-5 border-b border-slate-100 dark:border-zinc-800 mb-6">
          <div>
            <h2 class="text-base font-bold text-slate-900 dark:text-white flex items-center gap-2">
              <i class="fa-regular fa-id-badge text-brand-700 dark:text-brand-500"></i>
              Personal Information
            </h2>
            <p class="text-xs text-slate-500 dark:text-zinc-400 mt-0.5">Update your display name, email, phone number, and profile photo.</p>
          </div>
        </div>

        <form method="POST" action="{{ route('admin.profile.update') }}" enctype="multipart/form-data" class="space-y-5">
          @csrf
          @method('PUT')

          <!-- Photo Upload with Live Preview -->
          <div>
            <label class="block text-xs font-semibold text-slate-700 dark:text-zinc-300 mb-2">Profile Photo</label>
            <div class="flex items-center gap-4">
              <div class="relative group">
                <img id="photoPreview"
                     src="{{ $admin->avatar_url }}"
                     alt="Preview"
                     class="w-16 h-16 rounded-xl object-cover border-2 border-slate-200 dark:border-zinc-700 shadow-sm">
              </div>
              <div class="flex-1">
                <input type="file" name="photo" id="photoInput" accept="image/*" class="hidden" onchange="previewImage(event)">
                <label for="photoInput" class="cursor-pointer inline-flex items-center gap-2 px-4 py-2 rounded-xl text-xs font-semibold bg-slate-100 hover:bg-slate-200 dark:bg-zinc-800 dark:hover:bg-zinc-700 text-slate-700 dark:text-zinc-200 transition-colors border border-slate-200 dark:border-zinc-700 shadow-sm">
                  <i class="fa-solid fa-cloud-arrow-up"></i>
                  <span>Upload New Photo</span>
                </label>
                <p class="text-[11px] text-slate-400 dark:text-zinc-500 mt-1.5">PNG, JPG, WEBP or GIF up to 2MB. Recommended square aspect ratio.</p>
              </div>
            </div>
            @error('photo')
              <p class="text-red-500 text-xs mt-1.5 flex items-center gap-1"><i class="fa-solid fa-circle-exclamation"></i> {{ $message }}</p>
            @enderror
          </div>

          <!-- Name & Phone Grid -->
          <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <!-- Full Name -->
            <div>
              <label for="name" class="block text-xs font-semibold text-slate-700 dark:text-zinc-300 mb-1.5">Full Name <span class="text-red-500">*</span></label>
              <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400 dark:text-zinc-500 text-xs">
                  <i class="fa-regular fa-user"></i>
                </div>
                <input type="text"
                       name="name"
                       id="name"
                       value="{{ old('name', $admin->name) }}"
                       required
                       class="w-full pl-9 pr-4 py-2.5 text-xs sm:text-sm rounded-xl border {{ $errors->has('name') ? 'border-red-400 focus:ring-red-400/20' : 'border-slate-200 dark:border-zinc-800 focus:border-brand-700 dark:focus:border-brand-500 focus:ring-brand-600/20' }} bg-slate-50 dark:bg-zinc-950 text-slate-900 dark:text-white focus:outline-none focus:ring-2 transition-all">
              </div>
              @error('name')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
              @enderror
            </div>

            <!-- Phone Number -->
            <div>
              <label for="phone" class="block text-xs font-semibold text-slate-700 dark:text-zinc-300 mb-1.5">Phone Number</label>
              <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400 dark:text-zinc-500 text-xs">
                  <i class="fa-solid fa-phone"></i>
                </div>
                <input type="text"
                       name="phone"
                       id="phone"
                       placeholder="e.g. 01712345678"
                       value="{{ old('phone', $admin->phone) }}"
                       class="w-full pl-9 pr-4 py-2.5 text-xs sm:text-sm rounded-xl border {{ $errors->has('phone') ? 'border-red-400 focus:ring-red-400/20' : 'border-slate-200 dark:border-zinc-800 focus:border-brand-700 dark:focus:border-brand-500 focus:ring-brand-600/20' }} bg-slate-50 dark:bg-zinc-950 text-slate-900 dark:text-white focus:outline-none focus:ring-2 transition-all">
              </div>
              @error('phone')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
              @enderror
            </div>
          </div>

          <!-- Email Address -->
          <div>
            <label for="email" class="block text-xs font-semibold text-slate-700 dark:text-zinc-300 mb-1.5">Email Address <span class="text-red-500">*</span></label>
            <div class="relative">
              <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400 dark:text-zinc-500 text-xs">
                <i class="fa-regular fa-envelope"></i>
              </div>
              <input type="email"
                     name="email"
                     id="email"
                     value="{{ old('email', $admin->email) }}"
                     required
                     class="w-full pl-9 pr-4 py-2.5 text-xs sm:text-sm rounded-xl border {{ $errors->has('email') ? 'border-red-400 focus:ring-red-400/20' : 'border-slate-200 dark:border-zinc-800 focus:border-brand-700 dark:focus:border-brand-500 focus:ring-brand-600/20' }} bg-slate-50 dark:bg-zinc-950 text-slate-900 dark:text-white focus:outline-none focus:ring-2 transition-all">
            </div>
            @error('email')
              <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
          </div>

          <!-- Save Changes Button -->
          <div class="pt-4 border-t border-slate-100 dark:border-zinc-800 flex justify-end">
            <button type="submit" class="py-2.5 px-6 bg-brand-800 hover:bg-brand-900 dark:bg-brand-600 dark:hover:bg-brand-500 text-white font-medium text-xs sm:text-sm rounded-xl transition-all shadow-sm flex items-center gap-2">
              <i class="fa-solid fa-floppy-disk"></i>
              <span>Save Changes</span>
            </button>
          </div>
        </form>
      </div>
    </div>

  </div>

  <!-- Image Preview Script -->
  <script>
    function previewImage(event) {
      const input = event.target;
      if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = function(e) {
          const previewEl = document.getElementById('photoPreview');
          const displayEl = document.getElementById('avatarDisplay');
          if (previewEl) previewEl.src = e.target.result;
          if (displayEl) displayEl.src = e.target.result;
        }
        reader.readAsDataURL(input.files[0]);
      }
    }
  </script>
@endsection
