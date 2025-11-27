<aside class="w-64 bg-white shadow-sm fixed left-0 top-0 bottom-0 overflow-y-auto z-50 transform transition-transform duration-300 flex flex-col lg:translate-x-0"
    :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'">
    <!-- Logo & Brand -->
    <div class="p-6 border-b border-gray-200 flex items-center justify-between">
        <div class="flex items-center">
            <div class="w-10 h-10 rounded-lg flex items-center justify-center mr-3">
                <img src="{{ asset('images/unib-logo.webp') }}" alt="logo" class="w-10">
            </div>
            <div>
                <h1 class="text-xl font-bold text-gray-900">SI-ELFA</h1>
                <p class="text-xs text-gray-500">Admin Panel</p>
            </div>
        </div>
        <!-- Close Button (Mobile) -->
        <button @click="sidebarOpen = false" class="lg:hidden text-gray-500 hover:text-gray-700 focus:outline-none">
            <i class="fas fa-times text-xl"></i>
        </button>
    </div>

    <!-- Main Navigation -->
    <nav class="flex-1 p-4">
        <ul class="space-y-2">
            <li>
                <a href="{{ route('dashboard.index') }}" 
                   class="flex items-center px-4 py-3 text-gray-700 {{ request()->routeIs('dashboard.index') ? 'bg-blue-50 border-l-4 border-blue-600' : 'hover:bg-gray-50' }} rounded-r transition-colors">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                    </svg>
                    Dashboard
                </a>
            </li>
            <li>
                <a href="{{ route('dashboard.kuesioner.index') }}" 
                   class="flex items-center px-4 py-3 text-gray-700 {{ request()->routeIs('dashboard.kuesioner.*') ? 'bg-blue-50 border-l-4 border-blue-600' : 'hover:bg-gray-50' }} rounded-r transition-colors">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    Kuesioner
                </a>
            </li>
            <li>
                <a href="{{ route('dashboard.laporan.index') }}" 
                   class="flex items-center px-4 py-3 text-gray-700 {{ request()->routeIs('dashboard.laporan.*') ? 'bg-blue-50 border-l-4 border-blue-600' : 'hover:bg-gray-50' }} rounded-r transition-colors">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                    </svg>
                    Laporan
                </a>
            </li>
            <li>
                <a href="{{ route('dashboard.admin.index') }}" 
                   class="flex items-center px-4 py-3 text-gray-700 {{ request()->routeIs('dashboard.admin.*') ? 'bg-blue-50 border-l-4 border-blue-600' : 'hover:bg-gray-50' }} rounded-r transition-colors">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                    </svg>
                    Manajemen Admin
                </a>
            </li>
        </ul>
    </nav>

    <!-- Bottom Navigation (Profil & Logout) -->
    <div class="border-t border-gray-200 p-4">
        <ul class="space-y-2">
            <li>
                <a href="{{ route('dashboard.profile.index') }}" 
                   class="flex items-center px-4 py-3 text-gray-700 {{ request()->routeIs('dashboard.profile.*') ? 'bg-blue-50 border-l-4 border-blue-600' : 'hover:bg-gray-50' }} rounded-r transition-colors">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5.121 17.804A13.937 13.937 0 0112 16c2.5 0 4.847.655 6.879 1.804M15 10a3 3 0 11-6 0 3 3 0 016 0zm6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <div class="flex-1">
                        <div class="text-sm font-medium">{{ auth()->user()->nama }}</div>
                        <div class="text-xs text-gray-500">Profil</div>
                    </div>
                </a>
            </li>
            <li>
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="w-full flex items-center px-4 py-3 text-red-600 hover:bg-red-50 rounded transition-colors">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                        </svg>
                        Logout
                    </button>
                </form>
            </li>
        </ul>
    </div>
</aside>