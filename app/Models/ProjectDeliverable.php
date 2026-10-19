<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProjectDeliverable extends Model
{
    use HasFactory;

    protected $fillable = [
        'project_milestone_id',
        'title',
        'file_path',
        'notes',
        'status',
    ];

    public function milestone()
    {
        return $this->belongsTo(ProjectMilestone::class, 'project_milestone_id');
    }
}
