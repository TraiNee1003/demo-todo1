<!-- create.blade -->

@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h1 class="h1 mb-4 text-center border-bottom">Create Task</h1>

    <form method="POST" action="{{ route('tasks.store') }}">
        @csrf

        <div class="mb-3 row">
            <label for="employee_id" class="form-label col-2">Employee</label>
            <select class="form-select col-10 rounded" name="employee_id" id="employee_id" required>
                @foreach ($employees as $employee)
                    <option value="{{ $employee->id }}">{{ $employee->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="row">
            <div class="mb-3 col-6">
                <div class="row">
                    <label for="title" class="form-label col-4 pt-2">Title</label>
                    <input type="text" class="form-control rounded col-8" id="title" name="title" required>
                </div>
            </div>

            <div class="mb-3 col-6">
                <div class="row">
                    <label for="duration_days" class="form-label col-4 pt-2 text-center">Duration (Days)</label>
                    <input type="number" class="form-control col-8 rounded" id="duration_days" name="duration_days" min="1" required>
                </div>
            </div>
        </div>

        <div class="mb-3 row">
            <label for="description" class="form-label col-2">Description</label>
            <textarea style="min-height: 42px; max-height: 42px;" id="description" min-row="2" max-row="4" class="form-control col-10 rounded" name="description" required></textarea>
        </div>
        
        <div class="text-center">
            <button type="submit" class="btn btn-primary col-10 text-center">Create Task</button>
        </div>
    </form>
</div>

@if(session('success'))
<script>
    Swal.fire({
        title: 'Success!',
        text: '{{ session('success') }}',
        icon: 'success',
        confirmButtonText: 'OK'
    });
</script>
@endif

@endsection
