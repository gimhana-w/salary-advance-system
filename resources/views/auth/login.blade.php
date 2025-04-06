@extends('layouts.app')

@section('title', 'Login')

@section('content')
<div class="min-h-screen w-full flex items-center justify-center bg-gradient-to-br from-blue-600 to-purple-700 p-4 sm:p-6 md:p-8 lg:p-10">
    <div class="max-w-md w-full bg-white bg-opacity-80 rounded-lg shadow-xl p-8">
        <div class="text-center mb-8">
            @if(file_exists(public_path('images/comprelilogo-01.png')))
                <img src="{{ asset('images/comprelilogo-01.png') }}" alt="Comporeli Logo" class="h-24 mx-auto mb-4">
            @else
                <!-- For debugging -->
                <div class="text-sm text-gray-500 mb-4">
                    Logo not found at: {{ public_path('images/comprelilogo-01.png') }}
                </div>
            @endif


        </div>

        @if($errors->any())
            <div class="mb-4 bg-red-50 border border-red-200 text-red-600 px-4 py-3 rounded relative" role="alert">
                <ul class="list-disc list-inside">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('login') }}" class="space-y-6">
            @csrf
             
            <div>
                <label for="email" class="block text-sm font-medium text-gray-700">Email Address</label>
                <input id="email" name="email" type="email" required autocomplete="email" value="{{ old('email') }}"
                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-purple-500 focus:border-purple-500">
            </div>

            <div>
                <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                <input id="password" name="password" type="password" required autocomplete="current-password"
                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-purple-500 focus:border-purple-500">
            </div>

            <div class="flex items-center justify-between">
                <div class="flex items-center">
                    <input id="remember" name="remember" type="checkbox" class="h-4 w-4 text-purple-600 focus:ring-purple-500 border-gray-300 rounded">
                    <label for="remember" class="ml-2 block text-sm text-gray-700">Remember me</label>
                </div>

                @if(Route::has('password.request'))
                    <a href="{{ route('password.request') }}" class="text-sm text-purple-600 hover:text-purple-500">
                        Forgot your password?
                    </a>
                @endif
            </div>

            <button type="submit" class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-purple-600 hover:bg-purple-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500 transition duration-150 ease-in-out">
                Sign in
            </button>
        </form>
    </div>
</div>
@endsection