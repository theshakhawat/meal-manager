<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="light">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Forgot Password - {{ config('app.name', 'Laravel') }}</title>

  <!-- Dynamic Favicon -->
  <link rel="icon" type="image/png" href="{{ asset('assets/img/favicon.png') }}">

  <!-- Modern Font: Inter -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

  <!-- Tailwind CSS CDN -->
  <script src="https://cdn.tailwindcss.com"></script>
  <script>
    tailwind.config = {
      darkMode: 'class',
      theme: {
        extend: {
          fontFamily: {
            sans: ['Inter', 'sans-serif'],
          },
          colors: {
            brand: {
              50: '#f0fdf4',
              100: '#dcfce7',
              500: '#22c55e',
              600: '#16a34a',
              700: '#15803d',
              800: '#166534',
              900: '#14532d',
            }
          }
        }
      }
    }
  </script>

  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

  <style>
    body {
      font-family: 'Inter', sans-serif;
    }
  </style>
</head>
<body class="bg-slate-50 dark:bg-zinc-950 text-slate-900 dark:text-zinc-100 min-h-screen flex items-center justify-center p-4 sm:p-6 transition-colors duration-300">

  <!-- Dark / Light Theme Toggle Button -->
  <button id="themeToggle" type="button" aria-label="Toggle Theme" class="fixed top-4 right-4 sm:top-6 sm:right-6 p-2.5 sm:p-3 rounded-full bg-white dark:bg-zinc-900 border border-slate-200 dark:border-zinc-800 text-slate-700 dark:text-zinc-200 shadow-sm hover:shadow-md transition-all z-50">
    <i id="themeIcon" class="fa-solid fa-moon text-base sm:text-lg"></i>
  </button>

  <div class="w-full max-w-md bg-white dark:bg-zinc-900 rounded-2xl shadow-xl sm:shadow-2xl border border-slate-100 dark:border-zinc-800/80 p-6 sm:p-8 transition-colors">

    <!-- Brand Logo / Header -->
    <div class="text-center mb-6 sm:mb-8">
      <div class="inline-flex items-center justify-center mb-3">
        <!-- Dynamic Logo from public/assets/img/logo.png -->
        <img src="{{ asset('assets/img/logo.png') }}" alt="{{ config('app.name') }} Logo" class="h-10 sm:h-12 w-auto object-contain dark:brightness-110">
      </div>
      <h2 class="text-2xl sm:text-3xl font-bold tracking-tight text-slate-900 dark:text-white">Forgot Password?</h2>
      <p class="text-xs sm:text-sm text-slate-500 dark:text-zinc-400 mt-1.5 leading-relaxed">
        No problem. Just enter your email address and we will send you a link to reset your password.
      </p>
    </div>

    <!-- Laravel Session Status (Success Message) -->
    @if (session('status'))
      <div class="mb-5 p-3.5 sm:p-4 rounded-xl text-xs sm:text-sm flex items-start space-x-3 bg-brand-50 text-brand-900 border border-brand-200 dark:bg-zinc-800/90 dark:text-brand-400 dark:border-zinc-700">
        <i class="fa-solid fa-circle-check text-brand-600 dark:text-brand-500 mt-0.5 text-base flex-shrink-0"></i>
        <span>{{ session('status') }}</span>
      </div>
    @endif

    <!-- Laravel Validation Error Message -->
    @if ($errors->any())
      <div class="mb-5 p-3.5 sm:p-4 rounded-xl text-xs sm:text-sm bg-red-50 text-red-800 border border-red-200 dark:bg-red-950/40 dark:text-red-300 dark:border-red-900/60">
        <div class="flex items-center space-x-2 font-semibold mb-1">
          <i class="fa-solid fa-circle-exclamation text-red-500"></i>
          <span>Please fix the error below:</span>
        </div>
        <ul class="list-disc list-inside space-y-0.5 text-xs">
          @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
          @endforeach
        </ul>
      </div>
    @endif

    <!-- Forgot Password Form -->
    <form action="{{ route('password.email') }}" method="POST" class="space-y-4">
      @csrf

      <div>
        <label for="email" class="block text-xs font-medium tracking-wide text-slate-700 dark:text-zinc-300 mb-1.5">Email Address</label>
        <div class="relative">
          <i class="fa-regular fa-envelope absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400 dark:text-zinc-500 text-sm"></i>
          <input type="email" name="email" id="email" value="{{ old('email') }}" required autofocus placeholder="name@company.com"
            class="w-full pl-10 pr-4 py-2.5 sm:py-3 rounded-xl border @error('email') border-red-500 dark:border-red-500 @else border-slate-200 dark:border-zinc-800 @enderror bg-transparent focus:outline-none focus:ring-2 focus:ring-brand-600/20 focus:border-brand-700 dark:focus:border-brand-500 text-sm transition-all dark:text-white placeholder:text-slate-400 dark:placeholder:text-zinc-600">
        </div>
        @error('email')
          <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
        @enderror
      </div>

      <button type="submit"
        class="w-full mt-2 py-3 px-4 bg-brand-800 hover:bg-brand-900 dark:bg-brand-600 dark:hover:bg-brand-500 text-white font-medium rounded-xl text-sm transition-all shadow-md hover:shadow-lg active:scale-[0.99] focus:ring-2 focus:ring-brand-600/40">
        Email Password Reset Link
      </button>
    </form>

    <!-- Back to Login Link -->
    <div class="mt-6 text-center">
      <a href="{{ route('login') }}" class="inline-flex items-center gap-2 text-xs font-semibold text-slate-600 dark:text-zinc-400 hover:text-brand-800 dark:hover:text-brand-500 transition-colors">
        <i class="fa-solid fa-arrow-left text-xs"></i>
        <span>Back to Login</span>
      </a>
    </div>

  </div>

  <script>
    // LocalStorage Managed Dark Mode
    const htmlEl = document.documentElement;
    const themeBtn = document.getElementById('themeToggle');
    const themeIcon = document.getElementById('themeIcon');

    function applyTheme(theme) {
      if (theme === 'dark') {
        htmlEl.classList.add('dark');
        themeIcon.className = 'fa-solid fa-sun text-yellow-400';
      } else {
        htmlEl.classList.remove('dark');
        themeIcon.className = 'fa-solid fa-moon text-slate-700';
      }
    }

    const savedTheme = localStorage.getItem('theme') ||
      (window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light');
    applyTheme(savedTheme);

    themeBtn.addEventListener('click', () => {
      const isDark = htmlEl.classList.toggle('dark');
      const newTheme = isDark ? 'dark' : 'light';
      localStorage.setItem('theme', newTheme);
      applyTheme(newTheme);
    });
  </script>
</body>
</html>
