<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Dashboard') - SI-ELFA</title>
    
    <!-- Font Awesome CDN -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50">
    <div class="min-h-screen flex">
        @include('layouts.sidebar')
        
        <!-- Main Content Wrapper -->
        <div class="flex-1 lg:ml-64 flex flex-col min-h-screen">
            <!-- Main Content -->
            <main id="main-content" class="flex-1 p-6 transition-all duration-300">
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
