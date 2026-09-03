<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="light">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Dashboard - {{ config('app.name', 'Laravel') }}</title>

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

  <!-- Alpine.js (Dropdown & Sidebar toggles) -->
  <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

  <!-- Chart.js -->
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

  <style>
    body { font-family: 'Inter', sans-serif }
  </style>
</head>
<body class="bg-slate-50 dark:bg-zinc-950 text-slate-800 dark:text-zinc-100 min-h-screen antialiased flex transition-colors duration-300" x-data="{ sidebarOpen: false }">

  <!-- Backdrop for Mobile Sidebar -->
  <div x-show="sidebarOpen" @click="sidebarOpen = false" x-transition.opacity class="fixed inset-0 z-40 bg-slate-900/50 backdrop-blur-sm lg:hidden"></div>

  <!-- Left Sidebar -->
    @include('layouts.admin.sidebar')

  <!-- Main Content Area -->
  <div class="flex-1 flex flex-col min-w-0 overflow-x-hidden">

    <!-- Top Navigation Bar -->
    @include('layouts.admin.topnav')

    <!-- Main Dashboard Content -->
    <main class="flex-1 overflow-y-auto p-4 sm:p-6 lg:p-8">
      @yield('content')
    </main>

  </div>

  <script>
    // Theme Management via LocalStorage
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
      updateChartColors(isDark);
    });

    // Chart.js Graph Initialization (if element exists)
    const mealChartEl = document.getElementById('mealChart');
    let mealChart = null;

    if (mealChartEl) {
      const ctx = mealChartEl.getContext('2d');
      let isDarkMode = htmlEl.classList.contains('dark');

      mealChart = new Chart(ctx, {
        type: 'line',
        data: {
          labels: ['Week 1', 'Week 2', 'Week 3', 'Week 4'],
          datasets: [{
            label: 'Total Meals',
            data: [120, 145, 130, 160],
            borderColor: '#166534',
            backgroundColor: 'rgba(22, 101, 52, 0.1)',
            fill: true,
            tension: 0.4,
            borderWidth: 2
          },
          {
            label: 'Cost (৳)',
            data: [6000, 7200, 6800, 8100],
            borderColor: '#0284c7',
            backgroundColor: 'transparent',
            tension: 0.4,
            borderWidth: 2,
            yAxisID: 'y1'
          }]
        },
        options: {
          responsive: true,
          maintainAspectRatio: false,
          plugins: {
            legend: {
              labels: {
                color: isDarkMode ? '#a1a1aa' : '#475569',
                font: { family: 'Inter' }
              }
            }
          },
          scales: {
            x: {
              grid: { color: isDarkMode ? '#27272a' : '#f1f5f9' },
              ticks: { color: isDarkMode ? '#a1a1aa' : '#64748b' }
            },
            y: {
              grid: { color: isDarkMode ? '#27272a' : '#f1f5f9' },
              ticks: { color: isDarkMode ? '#a1a1aa' : '#64748b' }
            },
            y1: {
              position: 'right',
              grid: { drawOnChartArea: false },
              ticks: { color: isDarkMode ? '#a1a1aa' : '#64748b' }
            }
          }
        }
      });
    }

    function updateChartColors(isDark) {
      if (!mealChart) return;
      mealChart.options.plugins.legend.labels.color = isDark ? '#a1a1aa' : '#475569';
      mealChart.options.scales.x.grid.color = isDark ? '#27272a' : '#f1f5f9';
      mealChart.options.scales.x.ticks.color = isDark ? '#a1a1aa' : '#64748b';
      mealChart.options.scales.y.grid.color = isDark ? '#27272a' : '#f1f5f9';
      mealChart.options.scales.y.ticks.color = isDark ? '#a1a1aa' : '#64748b';
      mealChart.options.scales.y1.ticks.color = isDark ? '#a1a1aa' : '#64748b';
      mealChart.update();
    }
  </script>
</body>
</html>
