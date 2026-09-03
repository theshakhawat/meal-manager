@extends('layouts.admin.app')
@section('content')
      <!-- Welcome Banner -->
      <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 bg-white dark:bg-zinc-900 p-6 rounded-2xl border border-slate-100 dark:border-zinc-800/80 shadow-sm mb-5">
        <div>
          <h1 class="text-xl sm:text-2xl font-bold tracking-tight text-slate-900 dark:text-white">Dashboard Overview</h1>
          <p class="text-xs sm:text-sm text-slate-500 dark:text-zinc-400 mt-1">Here is the summary of today's meal status and expenses.</p>
        </div>
        <button class="py-2.5 px-4 bg-brand-800 hover:bg-brand-900 dark:bg-brand-600 dark:hover:bg-brand-500 text-white font-medium text-xs sm:text-sm rounded-xl transition-all shadow-sm flex items-center gap-2">
          <i class="fa-solid fa-plus"></i> Add Meal Entry
        </button>
      </div>

      <!-- Meal & Expense Summary Cards -->
      <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-5">

        <!-- Card 1 -->
        <div class="bg-white dark:bg-zinc-900 p-5 rounded-2xl border border-slate-100 dark:border-zinc-800/80 shadow-sm flex items-center justify-between">
          <div>
            <p class="text-xs font-medium text-slate-500 dark:text-zinc-400">Total Today's Meals</p>
            <h3 class="text-2xl font-bold text-slate-900 dark:text-white mt-1">18.5</h3>
            <span class="text-[11px] font-medium text-brand-700 dark:text-brand-500 inline-flex items-center gap-1 mt-1">
              <i class="fa-solid fa-arrow-up text-[9px]"></i> +2.5 from yesterday
            </span>
          </div>
          <div class="w-12 h-12 rounded-xl bg-brand-50 dark:bg-zinc-800 text-brand-800 dark:text-brand-500 flex items-center justify-center text-xl">
            <i class="fa-solid fa-bowl-food"></i>
          </div>
        </div>

        <!-- Card 2 -->
        <div class="bg-white dark:bg-zinc-900 p-5 rounded-2xl border border-slate-100 dark:border-zinc-800/80 shadow-sm flex items-center justify-between">
          <div>
            <p class="text-xs font-medium text-slate-500 dark:text-zinc-400">Current Meal Rate</p>
            <h3 class="text-2xl font-bold text-slate-900 dark:text-white mt-1">৳ 52.40</h3>
            <span class="text-[11px] font-medium text-amber-600 dark:text-amber-500 inline-flex items-center gap-1 mt-1">
              Estimated Rate
            </span>
          </div>
          <div class="w-12 h-12 rounded-xl bg-amber-50 dark:bg-zinc-800 text-amber-600 dark:text-amber-500 flex items-center justify-center text-xl">
            <i class="fa-solid fa-calculator"></i>
          </div>
        </div>

        <!-- Card 3 -->
        <div class="bg-white dark:bg-zinc-900 p-5 rounded-2xl border border-slate-100 dark:border-zinc-800/80 shadow-sm flex items-center justify-between">
          <div>
            <p class="text-xs font-medium text-slate-500 dark:text-zinc-400">Total Deposit</p>
            <h3 class="text-2xl font-bold text-slate-900 dark:text-white mt-1">৳ 24,500</h3>
            <span class="text-[11px] font-medium text-brand-700 dark:text-brand-500 inline-flex items-center gap-1 mt-1">
              8 Members Paid
            </span>
          </div>
          <div class="w-12 h-12 rounded-xl bg-blue-50 dark:bg-zinc-800 text-blue-600 dark:text-blue-400 flex items-center justify-center text-xl">
            <i class="fa-solid fa-wallet"></i>
          </div>
        </div>

        <!-- Card 4 -->
        <div class="bg-white dark:bg-zinc-900 p-5 rounded-2xl border border-slate-100 dark:border-zinc-800/80 shadow-sm flex items-center justify-between">
          <div>
            <p class="text-xs font-medium text-slate-500 dark:text-zinc-400">Total Bazar Cost</p>
            <h3 class="text-2xl font-bold text-slate-900 dark:text-white mt-1">৳ 14,280</h3>
            <span class="text-[11px] font-medium text-slate-500 dark:text-zinc-400 inline-flex items-center gap-1 mt-1">
              12 Bazaar Entries
            </span>
          </div>
          <div class="w-12 h-12 rounded-xl bg-purple-50 dark:bg-zinc-800 text-purple-600 dark:text-purple-400 flex items-center justify-center text-xl">
            <i class="fa-solid fa-cart-shopping"></i>
          </div>
        </div>

      </div>

      <!-- Graph Section & Meal Stats -->
      <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-5">

        <!-- Graph (2 Cols) -->
        <div class="lg:col-span-2 bg-white dark:bg-zinc-900 p-6 rounded-2xl border border-slate-100 dark:border-zinc-800/80 shadow-sm">
          <div class="flex items-center justify-between mb-4">
            <h2 class="text-base font-bold text-slate-900 dark:text-white">Monthly Meal & Cost Overview</h2>
            <span class="text-xs text-slate-500 dark:text-zinc-400">Current Month</span>
          </div>
          <div class="h-64 sm:h-72">
            <canvas id="mealChart"></canvas>
          </div>
        </div>

        <!-- Right Side: Today's Meal Quick View -->
        <div class="bg-white dark:bg-zinc-900 p-6 rounded-2xl border border-slate-100 dark:border-zinc-800/80 shadow-sm">
          <h2 class="text-base font-bold text-slate-900 dark:text-white mb-4">Meal Breakdown (Today)</h2>

          <div class="space-y-3">
            <div class="flex justify-between items-center p-3 rounded-xl bg-slate-50 dark:bg-zinc-800/50">
              <div class="flex items-center gap-3">
                <div class="p-2 bg-amber-100 text-amber-700 rounded-lg text-xs"><i class="fa-solid fa-sun"></i></div>
                <div>
                  <p class="text-xs font-semibold text-slate-800 dark:text-zinc-200">Lunch</p>
                  <p class="text-[10px] text-slate-500">12 Members active</p>
                </div>
              </div>
              <span class="font-bold text-sm text-slate-900 dark:text-white">12.0</span>
            </div>

            <div class="flex justify-between items-center p-3 rounded-xl bg-slate-50 dark:bg-zinc-800/50">
              <div class="flex items-center gap-3">
                <div class="p-2 bg-indigo-100 text-indigo-700 rounded-lg text-xs"><i class="fa-solid fa-moon"></i></div>
                <div>
                  <p class="text-xs font-semibold text-slate-800 dark:text-zinc-200">Dinner</p>
                  <p class="text-[10px] text-slate-500">6 Members active</p>
                </div>
              </div>
              <span class="font-bold text-sm text-slate-900 dark:text-white">6.5</span>
            </div>
          </div>

          <div class="mt-6 pt-4 border-t border-slate-100 dark:border-zinc-800">
            <p class="text-xs text-slate-500 dark:text-zinc-400 mb-2">Today's Manager</p>
            <div class="flex items-center gap-3">
              <img src="https://ui-avatars.com/api/?name=Hridoy&background=22c55e&color=fff" class="w-8 h-8 rounded-lg object-cover" alt="Manager">
              <div>
                <p class="text-xs font-semibold text-slate-800 dark:text-zinc-200">Hridoy Ahmed</p>
                <p class="text-[10px] text-slate-500">Bazaar Manager</p>
              </div>
            </div>
          </div>
        </div>

      </div>

      <!-- User Meal Status Table -->
      <div class="bg-white dark:bg-zinc-900 rounded-2xl border border-slate-100 dark:border-zinc-800/80 shadow-sm overflow-hidden">
        <div class="p-6 border-b border-slate-100 dark:border-zinc-800 flex items-center justify-between">
          <h2 class="text-base font-bold text-slate-900 dark:text-white">Member Meal Info</h2>
          <a href="#" class="text-xs font-semibold text-brand-800 dark:text-brand-500 hover:underline">View All Members</a>
        </div>

        <div class="overflow-x-auto">
          <table class="w-full text-left text-xs text-slate-600 dark:text-zinc-400">
            <thead class="bg-slate-50 dark:bg-zinc-800/50 text-slate-700 dark:text-zinc-300 font-semibold uppercase tracking-wider text-[10px]">
              <tr>
                <th class="px-6 py-3.5">Member</th>
                <th class="px-6 py-3.5">Today's Meal</th>
                <th class="px-6 py-3.5">Total Meal</th>
                <th class="px-6 py-3.5">Deposit</th>
                <th class="px-6 py-3.5">Balance</th>
                <th class="px-6 py-3.5">Status</th>
              </tr>
            </thead>
            <tbody class="divide-y divide-slate-100 dark:divide-zinc-800/80">

              <!-- User Row 1 -->
              <tr class="hover:bg-slate-50/50 dark:hover:bg-zinc-800/30 transition-colors">
                <td class="px-6 py-4 flex items-center gap-3">
                  <img src="https://ui-avatars.com/api/?name=Shakhawat+Hosen&background=166534&color=fff" class="w-8 h-8 rounded-lg" alt="User">
                  <div>
                    <p class="font-semibold text-slate-800 dark:text-zinc-200">Shakhawat Hosen</p>
                    <p class="text-[10px] text-slate-400">shakhawat@dev.com</p>
                  </div>
                </td>
                <td class="px-6 py-4 font-medium text-slate-800 dark:text-zinc-200">2.0</td>
                <td class="px-6 py-4">42.5</td>
                <td class="px-6 py-4 text-slate-800 dark:text-zinc-200 font-medium">৳ 3,000</td>
                <td class="px-6 py-4 font-semibold text-brand-700 dark:text-brand-500">+ ৳ 773</td>
                <td class="px-6 py-4">
                  <span class="px-2.5 py-1 rounded-full text-[10px] font-medium bg-brand-50 text-brand-900 border border-brand-200 dark:bg-zinc-800 dark:text-brand-400 dark:border-zinc-700">Active</span>
                </td>
              </tr>

              <!-- User Row 2 -->
              <tr class="hover:bg-slate-50/50 dark:hover:bg-zinc-800/30 transition-colors">
                <td class="px-6 py-4 flex items-center gap-3">
                  <img src="https://ui-avatars.com/api/?name=Sazid&background=0284c7&color=fff" class="w-8 h-8 rounded-lg" alt="User">
                  <div>
                    <p class="font-semibold text-slate-800 dark:text-zinc-200">Sazid Ahmed</p>
                    <p class="text-[10px] text-slate-400">sazid@dev.com</p>
                  </div>
                </td>
                <td class="px-6 py-4 font-medium text-slate-800 dark:text-zinc-200">1.0</td>
                <td class="px-6 py-4">38.0</td>
                <td class="px-6 py-4 text-slate-800 dark:text-zinc-200 font-medium">৳ 2,000</td>
                <td class="px-6 py-4 font-semibold text-red-600 dark:text-red-400">- ৳ 91</td>
                <td class="px-6 py-4">
                  <span class="px-2.5 py-1 rounded-full text-[10px] font-medium bg-amber-50 text-amber-800 border border-amber-200 dark:bg-zinc-800 dark:text-amber-400 dark:border-zinc-700">Low Balance</span>
                </td>
              </tr>

              <!-- User Row 3 -->
              <tr class="hover:bg-slate-50/50 dark:hover:bg-zinc-800/30 transition-colors">
                <td class="px-6 py-4 flex items-center gap-3">
                  <img src="https://ui-avatars.com/api/?name=Atik&background=7c3aed&color=fff" class="w-8 h-8 rounded-lg" alt="User">
                  <div>
                    <p class="font-semibold text-slate-800 dark:text-zinc-200">Atik Hasan</p>
                    <p class="text-[10px] text-slate-400">atik@dev.com</p>
                  </div>
                </td>
                <td class="px-6 py-4 font-medium text-slate-800 dark:text-zinc-200">0.0</td>
                <td class="px-6 py-4">25.0</td>
                <td class="px-6 py-4 text-slate-800 dark:text-zinc-200 font-medium">৳ 2,500</td>
                <td class="px-6 py-4 font-semibold text-brand-700 dark:text-brand-500">+ ৳ 1,190</td>
                <td class="px-6 py-4">
                  <span class="px-2.5 py-1 rounded-full text-[10px] font-medium bg-slate-100 text-slate-700 border border-slate-200 dark:bg-zinc-800 dark:text-zinc-400 dark:border-zinc-700">Meal Off</span>
                </td>
              </tr>

            </tbody>
          </table>
        </div>
      </div>
@endsection
