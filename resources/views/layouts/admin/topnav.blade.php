<header class="h-16 bg-white dark:bg-zinc-900 border-b border-slate-200 dark:border-zinc-800/80 px-4 sm:px-6 flex items-center justify-between sticky top-0 z-30">

      <!-- Left: Mobile Toggle & Search Bar -->
      <div class="flex items-center gap-3 sm:gap-4 flex-1 max-w-md">
        <button @click="sidebarOpen = true" class="lg:hidden p-2 rounded-xl text-slate-600 dark:text-zinc-300 hover:bg-slate-100 dark:hover:bg-zinc-800">
          <i class="fa-solid fa-bars text-lg"></i>
        </button>

        <!-- Search Input -->
        <div class="relative w-full">
          <i class="fa-solid fa-magnifying-glass absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400 dark:text-zinc-500 text-sm"></i>
          <input type="text" placeholder="Search members, meals, reports..."
            class="w-full pl-10 pr-4 py-2 text-xs sm:text-sm rounded-xl border border-slate-200 dark:border-zinc-800 bg-slate-50 dark:bg-zinc-950 focus:outline-none focus:ring-2 focus:ring-brand-600/20 focus:border-brand-700 dark:focus:border-brand-500 transition-all dark:text-white placeholder:text-slate-400 dark:placeholder:text-zinc-500">
        </div>
      </div>

      <!-- Right: Actions (Dark Mode + Notifications + User Profile) -->
      <div class="flex items-center gap-2 sm:gap-4">

        <!-- Theme Toggle Button -->
        <button id="themeToggle" type="button" aria-label="Toggle Theme" class="p-2.5 rounded-xl border border-slate-200 dark:border-zinc-800 text-slate-700 dark:text-zinc-300 hover:bg-slate-100 dark:hover:bg-zinc-800 transition-all">
          <i id="themeIcon" class="fa-solid fa-moon text-base"></i>
        </button>

        <!-- Notifications Icon -->
        <button type="button" class="relative p-2.5 rounded-xl border border-slate-200 dark:border-zinc-800 text-slate-700 dark:text-zinc-300 hover:bg-slate-100 dark:hover:bg-zinc-800 transition-all">
          <i class="fa-regular fa-bell text-base"></i>
          <span class="absolute top-2 right-2 w-2 h-2 rounded-full bg-brand-600"></span>
        </button>

        <!-- User Dropdown Menu -->
        <div class="relative" x-data="{ open: false }">
          <button @click="open = !open" class="flex items-center gap-2.5 p-1 sm:p-1.5 rounded-xl hover:bg-slate-100 dark:hover:bg-zinc-800 transition-colors focus:outline-none">
            <img src="{{ auth()->user()->avatar_url ?? 'https://ui-avatars.com/api/?name=Admin&background=166534&color=fff' }}" alt="User Avatar" class="w-8 h-8 rounded-lg object-cover border border-slate-200 dark:border-zinc-700">
            <div class="hidden md:block text-left">
              <p class="text-xs font-semibold text-slate-800 dark:text-zinc-200 leading-tight">{{ auth()->user()->name ?? 'Admin User' }}</p>
              <p class="text-[10px] text-slate-500 dark:text-zinc-400">Admin</p>
            </div>
            <i class="fa-solid fa-chevron-down text-xs text-slate-400 hidden sm:block"></i>
          </button>

          <!-- Dropdown Card -->
          <div x-show="open" @click.outside="open = false" x-transition
               class="absolute right-0 mt-2 w-48 bg-white dark:bg-zinc-900 rounded-xl shadow-xl border border-slate-100 dark:border-zinc-800 py-1.5 z-50 text-xs">

            <div class="px-4 py-2 border-b border-slate-100 dark:border-zinc-800 md:hidden">
              <p class="font-semibold text-slate-800 dark:text-zinc-200">{{ auth()->user()->name ?? 'Admin User' }}</p>
              <p class="text-[10px] text-slate-500">Admin</p>
            </div>

            <a href="{{ route('admin.profile') }}" class="flex items-center gap-2.5 px-4 py-2 text-slate-700 dark:text-zinc-300 hover:bg-slate-50 dark:hover:bg-zinc-800/60 transition-colors">
              <i class="fa-regular fa-user text-sm text-slate-400"></i> Profile
            </a>
            <a href="{{ route('admin.change-password') }}" class="flex items-center gap-2.5 px-4 py-2 text-slate-700 dark:text-zinc-300 hover:bg-slate-50 dark:hover:bg-zinc-800/60 transition-colors">
              <i class="fa-solid {{ !empty(auth()->user()->password) ? 'fa-key' : 'fa-lock-open' }} text-sm text-slate-400"></i>
              <span>{{ !empty(auth()->user()->password) ? 'Change Password' : 'Set Password' }}</span>
            </a>

            <div class="border-t border-slate-100 dark:border-zinc-800 my-1"></div>

            <form method="POST" action="{{ route('admin.logout') }}">
              @csrf
              <button type="submit" class="w-full flex items-center gap-2.5 px-4 py-2 text-red-600 dark:text-red-400 hover:bg-red-50 dark:hover:bg-red-950/30 transition-colors">
                <i class="fa-solid fa-arrow-right-from-bracket text-sm"></i> Log Out
              </button>
            </form>
          </div>
        </div>

      </div>
    </header>
