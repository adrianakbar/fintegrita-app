<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProjectMilestone extends Model
{
    use HasFactory;

    protected $fillable = [
        'project_id',
        'title',
        'description',
        'due_date',
        'completed_at',
        'payment_percentage',
        'amount',
        'status',
    ];

    protected $casts = [
        'due_date' => 'date',
        'completed_at' => 'datetime',
        'amount' => 'decimal:2',
    ];

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function deliverables()
    {
        return $this->hasMany(ProjectDeliverable::class);
    }
}
