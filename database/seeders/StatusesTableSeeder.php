<?php

namespace Database\Seeders;

use App\Models\Status;
use Illuminate\Database\Seeder;

class StatusesTableSeeder extends Seeder
{
    public function run(): void
    {
        $statuses = ['pending', 'processing', 'completed', 'rejected'];

        foreach ($statuses as $status) {
            Status::create(['name' => $status]);
        }
    }
}
