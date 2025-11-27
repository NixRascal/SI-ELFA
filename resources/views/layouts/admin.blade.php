<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Dashboard') - SI-ELFA</title>
    
    <!-- Font Awesome CDN -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50">
    <div class="min-h-screen flex bg-gray-50" x-data="{ sidebarOpen: false }">
        <!-- Mobile Sidebar Overlay -->
        <div x-show="sidebarOpen" @click="sidebarOpen = false" x-transition:enter="transition-opacity ease-linear duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="transition-opacity ease-linear duration-300" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" class="fixed inset-0 bg-gray-900/80 z-40 lg:hidden" style="display: none;"></div>

        <!-- Sidebar -->
        @include('layouts.sidebar')
        
        <!-- Main Content Wrapper -->
        <div class="flex-1 lg:ml-64 flex flex-col min-h-screen transition-all duration-300">
            <!-- Mobile Header -->
            <div class="sticky top-0 z-30 flex items-center justify-between px-4 py-3 bg-white border-b border-gray-200 lg:hidden shadow-sm">
                <div class="flex items-center gap-3">
                    <button @click="sidebarOpen = true" class="text-gray-500 hover:text-gray-700 focus:outline-none">
                        <i class="fas fa-bars text-xl"></i>
                    </button>
                    <span class="text-lg font-bold text-gray-900">SI-ELFA</span>
                </div>
                <div class="flex items-center gap-3">
                    <div class="w-8 h-8 rounded-full bg-blue-100 flex items-center justify-center text-blue-700 font-bold text-xs">
                        {{ substr(auth()->user()->nama ?? 'A', 0, 2) }}
                    </div>
                </div>
            </div>

            <!-- Main Content -->
            <main id="main-content" class="flex-1 p-4 sm:p-6 lg:p-8">
                <div class="max-w-7xl mx-auto">
                    @yield('content')
                </div>
            </main>
            
            <!-- Footer -->
            <footer class="mt-auto pt-6 pb-4 border-t border-gray-200">
                <div class="max-w-7xl mx-auto px-6">
                    <div class="flex flex-col md:flex-row items-center justify-center text-sm text-gray-600">
                        <div class="mb-4 md:mb-0">
                            <p>&copy; {{ date('Y') }} SI-ELFA. All rights reserved.</p>
                        </div>
                    </div>
                </div>
            </footer>
        </div>
    </div>
</body>
</html>
