<header class="bg-white shadow-sm fixed top-0 left-0 right-0 z-50">
    <div class="flex items-center justify-between px-6 py-4">
        <div class="flex items-center">
            <img src="{{ asset('images/unib-logo.webp') }}" alt="Logo" class="h-10 w-auto" />
            <span class="text-xl font-bold ml-3 text-gray-800">SI-ELFA</span>
        </div>
        
        <div class="flex items-center space-x-4">
            <span class="text-sm text-gray-600 hidden md:block">{{ Auth::user()->nama }}</span>
            <form action="{{ route('logout') }}" method="POST" class="inline">
                @csrf
                <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 text-sm transition-colors">
                    Logout
                </button>
            </form>
        </div>
    </div>
</header>