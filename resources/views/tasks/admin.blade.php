<!-- admin.blade -->

@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h1 class="mb-4">All Tasks</h1>

    <div class="table-responsive">
        <table class="table table-striped table-bordered">
            <thead class="table-primary">
                <tr>
                    <th>Title</th>
                    <th>Description</th>
                    <th>Employee</th>
                    <th>Status</th>
                    <th>Duration (Days)</th>
                    <th>Completed At</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($tasks as $task)
                    <tr>
                        <td>{{ $task->title }}</td>
                        <td>{{ $task->description }}</td>
                        <td>{{ $task->employee->name }}</td>
                        <td>{{ $task->status->name }}</td>
                        <td>{{ $task->duration_days }}</td>
                        <td>{{ $task->completed_at ? $task->completed_at->format('Y-m-d') : 'N/A' }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
