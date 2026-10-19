<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_id',
        'project_code',
        'name',
        'type',
        'scope_summary',
        'budget',
        'contract_value',
        'start_date',
        'target_date',
        'actual_completion_date',
        'status',
        'pm_id',
        'repo_url',
        'staging_url',
        'production_url',
    ];

    protected $casts = [
        'budget' => 'decimal:2',
        'contract_value' => 'decimal:2',
        'start_date' => 'date',
        'target_date' => 'date',
        'actual_completion_date' => 'date',
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function projectManager()
    {
        return $this->belongsTo(User::class, 'pm_id');
    }

    public function milestones()
    {
        return $this->hasMany(ProjectMilestone::class);
    }

    public function costs()
    {
        return $this->hasMany(ProjectCost::class);
    }
}
