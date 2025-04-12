@extends('layouts.app')

@section('content')
    <div class="container py-5">
        <h1 class="text-center mb-4">📝 ToDo Lista</h1>

        <!-- Flash üzenetek -->
        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Új feladat hozzáadása -->
        <form action="{{ route('tasks.store') }}" method="POST" class="mb-4">
            @csrf
            <div class="input-group">
                <input type="text" name="title" class="form-control" placeholder="Új feladat..." required>
                <button type="submit" class="btn btn-primary">Hozzáadás</button>
            </div>
        </form>

        <!-- Feladatok listája -->
        <ul class="list-group">
            @foreach ($tasks as $task)
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    <!-- Kész / nem kész checkbox -->
                    <form action="{{ route('tasks.update', $task->id) }}" method="POST" class="d-flex align-items-center">
                        @csrf
                        @method('PUT')

                        <input type="hidden" name="title" value="{{ $task->title }}">
                        {{-- <input type="hidden" name="is_completed" value="0"> --}}

                        <input type="checkbox" name="is_completed" class="form-check-input me-2"
                               onchange="this.form.submit()" value="1" {{ $task->is_completed ? 'checked' : '' }}>
                        <span class="{{ $task->is_completed ? 'text-decoration-line-through text-danger' : '' }}">
                            {{ $task->title }}
                        </span>
                    </form>

                    <!-- Törlés gomb -->
                    <form action="{{ route('tasks.destroy', $task->id) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-danger"
                                onclick="return confirm('Biztosan törlöd?')">🗑️</button>
                    </form>
                </li>
            @endforeach
        </ul>
    </div>
@endsection


