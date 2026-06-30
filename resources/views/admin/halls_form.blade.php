{{-- resources/views/admin/halls_form.blade.php --}}
@extends('admin.dashboard')
@section('admin-content')
<div class="card max-w-md mx-auto">
    <h1 class="text-xl font-bold mb-4">{{ isset($hall) ? 'Редактировать зал' : 'Новый зал' }}</h1>
    <form method="POST" action="{{ isset($hall) ? route('admin.halls.update', $hall->id) : route('admin.halls.store') }}">
        @csrf
        <div class="form-group"><label>Название зала</label><input type="text" name="name" value="{{ $hall->name ?? '' }}" required></div>
        <div class="form-row">
            <div class="form-group w-1/2"><label>Рядов</label><input type="number" name="rows" value="{{ $hall->rows ?? 8 }}" required></div>
            <div class="form-group w-1/2"><label>Мест в ряду</label><input type="number" name="seats_per_row" value="{{ $hall->seats_per_row ?? 10 }}" required></div>
        </div>
        <button type="submit" class="btn btn-primary">Сохранить</button>
        <a href="{{ route('admin.halls') }}" class="btn">Отмена</a>
    </form>
</div>
@endsection