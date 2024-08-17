<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

      protected $fillable = [
        'employee_id',
        'title',
        'description',
        'duration_days',
        'status_id',
        'accepted_at',
    ];
    
    protected $casts = [
        'accepted_at' => 'datetime',
    ];
    

    public function employee()
    {
        return $this->belongsTo(User::class);
    }

       public function status()
    {
        return $this->belongsTo(Status::class, 'status_id');
    }
}
