<?php 

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateTasksTableForStatus extends Migration
{
    public function up(): void
    {
        Schema::table('tasks', function (Blueprint $table) {
            // Remove the status column
            $table->dropColumn('status');

            // Add a foreign key to the statuses table
            $table->foreignId('status_id')->constrained('statuses')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::table('tasks', function (Blueprint $table) {
            // Restore the status column
            $table->enum('status', ['pending', 'processing', 'completed', 'rejected'])->default('pending');

            // Remove the status_id column
            $table->dropForeign(['status_id']);
            $table->dropColumn('status_id');
        });
    }
}
