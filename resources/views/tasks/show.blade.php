<!-- show.blade -->

@extends('layouts.app')

@section('content')
<div class="modal show" tabindex="-1" role="dialog" style="display: block;">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">{{ $task->title }}</h5>
        <a href="{{ route('admin.tasks') }}">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
        </a>
      </div>
      <div class="modal-body">
        <div class="table-responsive">
            <table class="table table-bordered">
                <tbody>
                    <tr>
                        <th>Description</th>
                        <td>{{ $task->description }}</td>
                    </tr>
                    <tr>
                        <th>Duration (Days)</th>
                        <td>{{ $task->duration_days }}</td>
                    </tr>
                    <tr>
                        <th>Status</th>
                        <td>{{ $task->status->name }}</td>
                    </tr>
                    @if($task->status->name === 'completed')
                    <tr>
                        <th>Completion Status</th>
                        <td class="text-success">Task Completed!</td>
                    </tr>
                    @endif
                </tbody>
            </table>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
