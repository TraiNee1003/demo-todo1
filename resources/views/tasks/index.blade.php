<!-- resoureces/tasks/index.blade -->

@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="h1 mb-4 text-center border-bottom">
        <h1 class="text-center text-primary-dark">TASKS DETAILS</h1>
    </div>

    <div class="table-responsive shadow-sm rounded bg-light">
        <table class="table align-middle mb-0 bg-white">
            <thead class="thead-light">
                <tr class="text-center">
                    <th>#</th>
                    <th class="text-left">Title</th>
                    @if(Auth::user()->role === 1)
                    <th>Assigned For</th>
                    @endif          
                    <th>Status</th>          
                    <th>Assigned At</th>
                    <th>Accepted At</th>
                    <th>Set Due</th>
                    <th>Due In (Days)</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($tasks as $index => $task)
                <tr id="task-row-{{ $task->id }}" class="
                    @if($task->status->name === 'pending') table-warning
                    @elseif($task->status->name === 'processing') table-light
                    @elseif($task->status->name === 'completed') table-light
                    @elseif($task->status->name === 'rejected') table-danger
                    @else table-secondary
                    @endif
                    text-dark
                    ">
                    <td class="text-center font-weight-bold">{{ $index + 1 }}</td>
                    <td>{{ $task->title }}</td>
                    @if(Auth::user()->role === 1)
                    <td class="text-center">{{ $task->employee->name }}</td>
                    @endif
                    <td class="text-center">
                        <span id="task-status-{{ $task->id }}" class="badge
                            @if($task->status->name === 'pending') badge-warning
                            @elseif($task->status->name === 'processing') badge-info
                            @elseif($task->status->name === 'completed') badge-success
                            @elseif($task->status->name === 'rejected') badge-danger
                            @else badge-secondary
                            @endif
                            ">{{ ucfirst($task->status->name) }}</span>
                    </td>
                    <td class="text-center">{{ $task->created_at->format('Y-m-d') }}</td>
                    <td class="text-center">{{ $task->accepted_at ? $task->accepted_at->format('Y-m-d') : 'N/A' }}</td>
                    <td class="text-center">{{ $task->duration_days }}</td>
                    <td class="text-center">{{ $task->accepted_at ? number_format($task->duration_days - $task->accepted_at->diffInDays(now()), 0) : number_format($task->duration_days, 0) }}</td>
                    <td class="text-center" id="task-actions-{{ $task->id }}">
                        @if(Auth::user()->role === 1)
                            <a href="{{ route('tasks.show', $task) }}" class="btn btn-outline-info btn-sm">
                                <i class="fas fa-eye"></i> View
                            </a>
                        @else
                            @if($task->status->name === 'pending')
                                <button class="btn btn-outline-success btn-sm" onclick="handleTaskAction('accept', {{ $task->id }})">
                                    <i class="fas fa-check"></i> Accept
                                </button>
                                <button class="btn btn-outline-danger btn-sm" onclick="handleTaskAction('reject', {{ $task->id }})">
                                    <i class="fas fa-times"></i> Reject
                                </button>
                            @elseif($task->status->name === 'processing')
                                <button class="btn btn-outline-warning btn-sm" onclick="handleTaskAction('complete', {{ $task->id }})">
                                    <i class="fas fa-clipboard-check"></i> Complete
                                </button>
                            @elseif($task->status->name === 'completed')
                                <span class="badge badge-success"><i class="fas fa-check-circle"></i> Completed</span>
                            @endif
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<script>
    // Pass the CSRF token and routes to the external JS file
    window.taskRoutes = {
        csrfToken: '{{ csrf_token() }}',
        accept: '{{ route('tasks.accept', ':id') }}',
        reject: '{{ route('tasks.reject', ':id') }}',
        complete: '{{ route('tasks.complete', ':id') }}',
    };
</script>

<script src="{{ asset('js/task_actions.js') }}"></script>

@endsection
