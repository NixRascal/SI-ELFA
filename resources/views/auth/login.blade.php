@extends('layouts.app')

@section('content')
<div class="min-h-screen flex bg-gray-50">
    <!-- Left Side - Login Form -->
    <div class="w-full lg:w-1/2 flex items-center justify-center px-8 py-12 sm:px-12 lg:px-16">
        <div class="w-full max-w-md">
            <div class="bg-white w-full max-w-2xl mx-auto p-6 sm:p-8 rounded-xl shadow-sm border border-gray-200">
            <div class="flex justify-center lg:hidden mb-8">
                <img src="{{ asset('images/unib-logo.webp') }}" alt="Logo" class="h-16 w-auto">
            </div>
            
            <h2 class="text-3xl font-bold text-gray-900 justify-center text-center">
                Sistem Evaluasi Fakultas<br>
                <span class="text-blue-600">Universitas Bengkulu</span>
            </h2>

            <form class="mt-8 space-y-6" action="{{ route('login.submit') }}" method="POST">
                @csrf
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700">
                        Email
                    </label>
                    <div class="mt-1">
                        <input id="email" name="email" type="email" required
                            class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                            value="{{ old('email') }}">
                        @error('email')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700">
                        Password
                    </label>
                    <div class="mt-1">
                        <input id="password" name="password" type="password" required
                            class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                    </div>
                </div>

                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <input id="remember" name="remember" type="checkbox"
                            class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                        <label for="remember" class="ml-2 block text-sm text-gray-700">
                            Ingat saya
                        </label>
                    </div>
                </div>

                <button type="submit"
                    class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    Masuk
                </button>
            </form>
        </div>
        </div>
    </div>

    <!-- Right Side - Image -->
    <div class="hidden lg:block lg:w-2/2 relative">
        <div class="absolute inset-0 flex items-center justify-center bg-blue-900/20 backdrop-blur-sm">
            <div class="text-center">
                <img src="{{ asset('images/unib-logo.webp') }}" alt="Logo" class="h-32 w-auto mx-auto mb-6">
                <h1 class="text-4xl font-bold text-white mb-2">SI-ELFA</h1>
                <p class="text-2xl font-semibold text-white">Sistem Informasi Evaluasi Fakultas</p>
            </div>
        </div>
        <img src="{{ asset('images/bg-campus.webp') }}" 
             alt="Background" 
             class="h-full w-full object-cover"
             onerror="this.src='{{ asset('images/unib-logo.webp') }}'">
    </div>
</div>
@endsection