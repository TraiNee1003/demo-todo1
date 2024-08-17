<?php

namespace App\Http\Controllers;

use App\Models\Status;
use App\Models\Task;
use App\Models\User;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    // For employees
    public function index()
    {
        // Get the ID for the 'rejected' status
        $rejectedStatusId = Status::where('name', 'rejected')->first()->id;

        // Fetch tasks that are not rejected
        $tasks = Task::where('employee_id', auth()->id())
            ->where('status_id', '!=', $rejectedStatusId) // Exclude rejected tasks
            ->get();

        return view('tasks.index', compact('tasks'));
    }

    // For admins
    public function adminIndex()
    {
        $tasks = Task::all();
        return view('tasks.index', compact('tasks'));
    }

    public function create()
    {
        $employees = User::where('role', 0)->get(); // Assuming '0' is for employees
        return view('tasks.create', compact('employees'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'employee_id' => 'required|exists:users,id',
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'duration_days' => 'required|integer|min:1',
        ]);

        // Get the ID for the 'pending' status
        $pendingStatusId = Status::where('name', 'pending')->first()->id;

        Task::create([
            'employee_id' => $request->employee_id,
            'title' => $request->title,
            'description' => $request->description,
            'duration_days' => $request->duration_days,
            'status_id' => $pendingStatusId, // Set status to 'pending'
        ]);

        return redirect()->route('tasks.create')->with('success', 'Task created successfully.');
    }

    public function show(Task $task)
    {
        return view('tasks.show', compact('task'));
    }

    public function accept(Task $task)
    {
        // Get the ID for the 'processing' status
        $processingStatusId = Status::where('name', 'processing')->first()->id;
        $pendingStatusId = Status::where('name', 'pending')->first()->id;

        if ($task->employee_id === auth()->id() && $task->status_id === $pendingStatusId) {
            $task->update(['status_id' => $processingStatusId, 'accepted_at' => now()]);
            return response()->json(['success' => true]);
        }
        return response()->json(['success' => false, 'message' => 'Unable to accept task.'], 403);
    }

    public function reject(Task $task)
    {
        // Get the ID for the 'rejected' status
        $rejectedStatusId = Status::where('name', 'rejected')->first()->id;
        $pendingStatusId = Status::where('name', 'pending')->first()->id;

        if ($task->employee_id === auth()->id() && $task->status_id === $pendingStatusId) {
            $task->update(['status_id' => $rejectedStatusId]);
            return response()->json(['success' => true]);
        }
        return response()->json(['success' => false, 'message' => 'Unable to reject task.'], 403);
    }

    public function complete(Task $task)
    {
        // Get the ID for the 'completed' status
        $completedStatusId = Status::where('name', 'completed')->first()->id;
        $processingStatusId = Status::where('name', 'processing')->first()->id;

        if ($task->employee_id === auth()->id() && $task->status_id === $processingStatusId) {
            $task->update(['status_id' => $completedStatusId]);
            return response()->json(['success' => true]);
        }
        return response()->json(['success' => false, 'message' => 'Unable to complete task.'], 403);
    }
}
