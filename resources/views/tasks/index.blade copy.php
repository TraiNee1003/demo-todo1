@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h1 class="mb-4">Tasks</h1>

    <div class="table-responsive">
        <table class="table table-striped table-bordered">
            <thead class="table-primary">
                <tr>
                    <th>#</th>
                    <th>Title</th>
                    <th>Description</th>
                    <th>Assigned For</th>
                    <th>Status</th>
                    <th>Assigned At</th>
                    <th>Accepted At</th>
                    <th>Due In (Days)</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
    @foreach($tasks as $index => $task)
        <tr id="task-{{ $task->id }}"> <!-- Unique ID for each task row -->
            <td>{{ $index + 1 }}</td>
            <td>{{ $task->title }}</td>
            <td>{{ $task->description }}</td>
            <td>{{ $task->employee->name }}</td>
            <td>{{ ucfirst($task->status) }}</td>
            <td>{{ $task->created_at->format('Y-m-d') }}</td>
            <td>{{ $task->accepted_at ? $task->accepted_at->format('Y-m-d') : 'N/A' }}</td>
            <td>{{ $task->accepted_at ? $task->duration_days - $task->accepted_at->diffInDays(now()) : $task->duration_days }}</td>
            <td>
                @if(Auth::user()->role === 1)
                    <a href="{{ route('tasks.show', $task) }}" class="btn btn-info btn-sm">View Details</a>
                @else
                    @if($task->status === 'pending')
                        <button class="btn btn-success btn-sm" onclick="handleTaskAction('accept', {{ $task->id }})">Accept</button>
                        <button class="btn btn-danger btn-sm" onclick="handleTaskAction('reject', {{ $task->id }})">Reject</button>
                    @elseif($task->status === 'processing')
                        <button class="btn btn-warning btn-sm" onclick="handleTaskAction('complete', {{ $task->id }})">Complete</button>
                    @endif
                @endif
            </td>
        </tr>
    @endforeach
</tbody>
        </table>
    </div>
</div>

<!-- //in dex.blade.php -->

<script>
function handleTaskAction(action, taskId) {
    let url;
    switch(action) {
        case 'accept':
            url = `{{ route('tasks.accept', ':id') }}`.replace(':id', taskId);
            break;
        case 'reject':
            url = `{{ route('tasks.reject', ':id') }}`.replace(':id', taskId);
            break;
        case 'complete':
            url = `{{ route('tasks.complete', ':id') }}`.replace(':id', taskId);
            break;
    }

    $.ajax({
        url: url,
        type: 'PATCH',
        data: {
            _token: '{{ csrf_token() }}'
        },
        success: function(response) {
            if (response.success) {
                if (action === 'reject') {
                    $(`#task-${taskId}`).remove(); // Remove the rejected task from the table
                } else {
                    location.reload();
                }
            } else {
                alert(response.message);
            }
        },
        error: function(response) {
            alert('An error occurred while performing the action.');
        }
    });
}
</script>

@endsection
