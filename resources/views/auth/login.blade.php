@extends('layouts.app')

@section('title', 'Вход')

@section('content')
<div class="container max-w-md">
    <div class="card p-6">
        <h1 class="text-2xl font-semibold mb-2">Вход</h1>
        <p class="text-gray-400 text-sm mb-6">Войдите в свой аккаунт, чтобы бронировать билеты</p>

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <div class="form-group mb-4">
                <label class="block text-gray-300 mb-1">Email</label>
                <input type="email" name="email" value="{{ old('email') }}" required class="w-full bg-gray-900 border border-gray-700 rounded-lg px-4 py-2 text-white focus:border-purple-500">
                @error('email')
                    <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group mb-4">
                <label class="block text-gray-300 mb-1">Пароль</label>
                <input type="password" name="password" required class="w-full bg-gray-900 border border-gray-700 rounded-lg px-4 py-2 text-white focus:border-purple-500">
                @error('password')
                    <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                @enderror
            </div>

            <div class="flex items-center justify-between mb-6">
                <label class="flex items-center">
                    <input type="checkbox" name="remember" class="mr-2">
                    <span class="text-sm text-gray-400">Запомнить меня</span>
                </label>
                <a href="{{ route('password.request') }}" class="text-sm text-purple-400 hover:underline">Забыли пароль?</a>
            </div>

            <button type="submit" class="btn-solid w-full py-2">Войти</button>
        </form>

        <div class="text-center mt-6">
            <span class="text-gray-400">Нет аккаунта?</span>
            <a href="{{ route('register') }}" class="text-purple-400 hover:underline ml-2">Зарегистрироваться</a>
        </div>
    </div>
</div>
@endsection