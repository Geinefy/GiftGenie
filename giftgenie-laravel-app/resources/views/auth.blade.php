@extends('layouts.app')

@section('content')
<div class="min-h-screen flex items-center justify-center bg-gray-50 py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-md w-full space-y-8">
        <div>
            <div class="mx-auto h-12 w-12 flex items-center justify-center rounded-full bg-blue-100">
                <i data-lucide="gift" class="w-8 h-8 text-blue-600"></i>
            </div>
            <h2 class="mt-6 text-center text-3xl font-extrabold text-gray-900">
                Welcome to GiftGenius
            </h2>
            <p class="mt-2 text-center text-sm text-gray-600">
                Sign in to your account or create a new one
            </p>
        </div>

        <!-- Tab Navigation -->
        <div class="flex border-b border-gray-200">
            <button class="w-1/2 py-2 px-4 text-center border-b-2 border-blue-500 text-blue-600 font-medium" 
                    onclick="showTab('login')">
                Sign In
            </button>
            <button class="w-1/2 py-2 px-4 text-center border-b-2 border-transparent text-gray-500 hover:text-gray-700" 
                    onclick="showTab('register')">
                Sign Up
            </button>
        </div>

        <!-- Login Form -->
        <div id="loginTab" class="space-y-6">
            <form class="mt-8 space-y-6" action="/login" method="POST">
                @csrf
                <div class="space-y-4">
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700">Email address</label>
                        <input id="email" name="email" type="email" required 
                               class="mt-1 appearance-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-md focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                               placeholder="Enter your email">
                    </div>
                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                        <input id="password" name="password" type="password" required 
                               class="mt-1 appearance-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-md focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                               placeholder="Enter your password">
                    </div>
                </div>

                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <input id="remember-me" name="remember" type="checkbox" 
                               class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                        <label for="remember-me" class="ml-2 block text-sm text-gray-900">
                            Remember me
                        </label>
                    </div>
                    <div class="text-sm">
                        <a href="#" class="font-medium text-blue-600 hover:text-blue-500">
                            Forgot your password?
                        </a>
                    </div>
                </div>

                <div>
                    <button type="submit" 
                            class="group relative w-full flex justify-center py-2 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        Sign in
                    </button>
                </div>
            </form>
        </div>

        <!-- Register Form -->
        <div id="registerTab" class="space-y-6 hidden">
            <form class="mt-8 space-y-6" action="/register" method="POST">
                @csrf
                <div class="space-y-4">
                    <div>
                        <label for="reg-name" class="block text-sm font-medium text-gray-700">Full Name</label>
                        <input id="reg-name" name="name" type="text" required 
                               class="mt-1 appearance-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-md focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                               placeholder="Enter your full name">
                    </div>
                    <div>
                        <label for="reg-email" class="block text-sm font-medium text-gray-700">Email address</label>
                        <input id="reg-email" name="email" type="email" required 
                               class="mt-1 appearance-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-md focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                               placeholder="Enter your email">
                    </div>
                    <div>
                        <label for="reg-password" class="block text-sm font-medium text-gray-700">Password</label>
                        <input id="reg-password" name="password" type="password" required 
                               class="mt-1 appearance-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-md focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                               placeholder="Enter your password">
                    </div>
                    <div>
                        <label for="reg-password-confirm" class="block text-sm font-medium text-gray-700">Confirm Password</label>
                        <input id="reg-password-confirm" name="password_confirmation" type="password" required 
                               class="mt-1 appearance-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-md focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                               placeholder="Confirm your password">
                    </div>
                </div>

                <div>
                    <button type="submit" 
                            class="group relative w-full flex justify-center py-2 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        Create Account
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function showTab(tabName) {
    const loginTab = document.getElementById('loginTab');
    const registerTab = document.getElementById('registerTab');
    const tabs = document.querySelectorAll('button[onclick^="showTab"]');
    
    // Hide all tabs
    loginTab.classList.add('hidden');
    registerTab.classList.add('hidden');
    
    // Remove active styling from all tab buttons
    tabs.forEach(tab => {
        tab.classList.remove('border-blue-500', 'text-blue-600');
        tab.classList.add('border-transparent', 'text-gray-500');
    });
    
    // Show selected tab
    if (tabName === 'login') {
        loginTab.classList.remove('hidden');
        tabs[0].classList.add('border-blue-500', 'text-blue-600');
        tabs[0].classList.remove('border-transparent', 'text-gray-500');
    } else {
        registerTab.classList.remove('hidden');
        tabs[1].classList.add('border-blue-500', 'text-blue-600');
        tabs[1].classList.remove('border-transparent', 'text-gray-500');
    }
}
</script>
@endsection
