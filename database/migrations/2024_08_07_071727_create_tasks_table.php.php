<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTasksTable extends Migration
{
    public function up(): void
{
    Schema::create('tasks', function (Blueprint $table) {
        $table->id();
        $table->foreignId('employee_id')->constrained()->onDelete('cascade');
        $table->string('title');
        $table->text('description');
        $table->integer('duration_days'); // Duration in days
        $table->enum('status', ['pending', 'processing', 'completed', 'rejected'])->default('pending');
        $table->timestamp('accepted_at')->nullable();
        $table->timestamps();
    });
}

    public function down(): void
    {
        Schema::dropIfExists('tasks');
    }
}
