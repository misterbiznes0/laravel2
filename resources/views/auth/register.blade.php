@extends('layouts.app')

@section('title', 'Регистрация')

@section('content')
<div class="container max-w-md">
    <div class="card p-6">
        <h1 class="text-2xl font-semibold mb-2">Регистрация</h1>
        <p class="text-gray-400 text-sm mb-6">Создайте аккаунт, чтобы бронировать билеты</p>

        <form method="POST" action="{{ route('register') }}">
            @csrf

            <div class="form-group mb-4">
                <label class="block text-gray-300 mb-1">Имя</label>
                <input type="text" name="name" value="{{ old('name') }}" required class="w-full bg-gray-900 border border-gray-700 rounded-lg px-4 py-2 text-white focus:border-purple-500">
                @error('name')
                    <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                @enderror
            </div>

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

            <div class="form-group mb-6">
                <label class="block text-gray-300 mb-1">Подтверждение пароля</label>
                <input type="password" name="password_confirmation" required class="w-full bg-gray-900 border border-gray-700 rounded-lg px-4 py-2 text-white focus:border-purple-500">
            </div>

            <button type="submit" class="btn-solid w-full py-2">Зарегистрироваться</button>
        </form>

        <div class="text-center mt-6">
            <span class="text-gray-400">Уже есть аккаунт?</span>
            <a href="{{ route('login') }}" class="text-purple-400 hover:underline ml-2">Войти</a>
        </div>
    </div>
</div>
@endsection