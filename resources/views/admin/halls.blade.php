{{-- resources/views/admin/halls.blade.php --}}
@extends('admin.dashboard')
@section('admin-content')
<div class="flex justify-between items-center mb-4">
    <h1 class="text-2xl font-bold">Залы</h1>
    <a href="{{ route('admin.halls.create') }}" class="btn btn-primary">+ Добавить зал</a>
</div>
<div class="card">
    <table class="table">
        <thead><tr><th>Название</th><th>Рядов</th><th>Мест в ряду</th><th></th></tr></thead>
        <tbody>
            @foreach($halls as $hall)
            <tr>
                <td>{{ $hall->name }}</td>
                <td>{{ $hall->rows }}</td>
                <td>{{ $hall->seats_per_row }}</td>
                <td><a href="{{ route('admin.halls.edit', $hall->id) }}" class="btn">✏️</a>
                    <a href="{{ route('admin.halls.delete', $hall->id) }}" class="btn btn-danger" onclick="return confirm('Удалить зал?')">🗑️</a></td>
            </tr>
            @endforeach
        </tbody>
    </table>
    {{ $halls->links() }}
</div>
@endsection