  <aside class="fixed lg:static inset-y-0 left-0 z-50 w-64 bg-white dark:bg-zinc-900 border-r border-slate-200 dark:border-zinc-800/80 flex flex-col justify-between transition-transform duration-300 transform lg:translate-x-0"
         :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'">

    <div>
      <!-- Brand Logo -->
      <div class="h-16 flex items-center justify-between px-6 border-b border-slate-100 dark:border-zinc-800">
        <a href="{{ route('admin.dashboard'); }}" class="flex items-center justify-center gap-3">
          <img src="{{ asset('assets/img/logo.png'); }}" alt="Logo" class="h-15 w-auto dark:brightness-110">
        </a>
        <button @click="sidebarOpen = false" class="lg:hidden text-slate-500 hover:text-slate-700 dark:text-zinc-400">
          <i class="fa-solid fa-xmark text-xl"></i>
        </button>
      </div>

      <!-- Navigation Links -->
      <nav class="p-4 space-y-1">
        <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl {{ request()->routeIs('admin.dashboard') ? 'bg-brand-800 text-white dark:bg-brand-600 shadow-sm' : 'text-slate-600 dark:text-zinc-400 hover:bg-slate-100 dark:hover:bg-zinc-800/60' }} font-medium text-sm transition-colors">
          <i class="fa-solid fa-chart-pie text-base"></i>
          <span>Dashboard</span>
        </a>

        <a href="#" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-slate-600 dark:text-zinc-400 hover:bg-slate-100 dark:hover:bg-zinc-800/60 font-medium text-sm transition-colors">
          <i class="fa-solid fa-utensils text-base"></i>
          <span>Meal Management</span>
        </a>

        <a href="#" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-slate-600 dark:text-zinc-400 hover:bg-slate-100 dark:hover:bg-zinc-800/60 font-medium text-sm transition-colors">
          <i class="fa-solid fa-users text-base"></i>
          <span>Members</span>
        </a>

        <a href="#" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-slate-600 dark:text-zinc-400 hover:bg-slate-100 dark:hover:bg-zinc-800/60 font-medium text-sm transition-colors">
          <i class="fa-solid fa-wallet text-base"></i>
          <span>Deposit & Cost</span>
        </a>

        <!-- Profile & Security Dropdown -->
        <div x-data="{ open: {{ (request()->routeIs('admin.profile*') || request()->routeIs('admin.change-password*')) ? 'true' : 'false' }} }" class="space-y-1">
          <button @click="open = !open"
                  type="button"
                  class="w-full flex items-center justify-between px-3.5 py-2.5 rounded-xl font-medium text-sm transition-colors {{ (request()->routeIs('admin.profile*') || request()->routeIs('admin.change-password*')) ? 'bg-slate-100/90 text-brand-800 dark:bg-zinc-800/80 dark:text-brand-400' : 'text-slate-600 dark:text-zinc-400 hover:bg-slate-100 dark:hover:bg-zinc-800/60' }}">
            <div class="flex items-center gap-3">
              <i class="fa-solid fa-user-gear text-base"></i>
              <span>Profile Settings</span>
            </div>
            <i class="fa-solid fa-chevron-down text-xs transition-transform duration-200" :class="open ? 'rotate-180 text-brand-700 dark:text-brand-400' : 'text-slate-400'"></i>
          </button>

          <!-- Dropdown Items -->
          <div x-show="open" x-transition class="pl-4 pr-1 py-1 space-y-1">
            <a href="{{ route('admin.profile') }}"
               class="flex items-center gap-2.5 px-3 py-2 rounded-xl text-xs font-medium transition-colors {{ request()->routeIs('admin.profile') ? 'bg-brand-800 text-white dark:bg-brand-600 shadow-sm' : 'text-slate-600 dark:text-zinc-400 hover:bg-slate-100 dark:hover:bg-zinc-800/60' }}">
              <i class="fa-regular fa-user text-xs"></i>
              <span>My Profile</span>
            </a>

            <a href="{{ route('admin.change-password') }}"
               class="flex items-center gap-2.5 px-3 py-2 rounded-xl text-xs font-medium transition-colors {{ request()->routeIs('admin.change-password') ? 'bg-brand-800 text-white dark:bg-brand-600 shadow-sm' : 'text-slate-600 dark:text-zinc-400 hover:bg-slate-100 dark:hover:bg-zinc-800/60' }}">
              <i class="fa-solid {{ !empty(auth()->user()->password) ? 'fa-key' : 'fa-lock-open' }} text-xs"></i>
              <span>{{ !empty(auth()->user()->password) ? 'Change Password' : 'Set Password' }}</span>
            </a>
          </div>
        </div>
      </nav>
    </div>

    <!-- Sidebar Footer Info -->
    <div class="p-4 border-t border-slate-100 dark:border-zinc-800">
      <div class="p-3 bg-slate-50 dark:bg-zinc-800/50 rounded-xl text-xs text-slate-500 dark:text-zinc-400 flex justify-between items-center">
        <span>System Status</span>
        <span class="inline-flex items-center gap-1.5 font-medium text-brand-700 dark:text-brand-500">
          <span class="w-2 h-2 rounded-full bg-brand-500"></span> Active
        </span>
      </div>
    </div>
  </aside>
