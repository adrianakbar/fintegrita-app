<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProjectCost extends Model
{
    use HasFactory;

    protected $fillable = [
        'project_id',
        'cost_category',
        'amount',
        'description',
        'receipt_path',
        'incurred_at',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'incurred_at' => 'date',
    ];

    public function project()
    {
        return $this->belongsTo(Project::class);
    }
}
