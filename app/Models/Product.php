<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id',
        'name',
        'slug',
        'type',
        'headline',
        'description',
        'features',
        'target_audience',
        'price',
        'sale_price',
        'is_digital_download',
        'is_recurring',
        'license_terms',
        'status',
        'image_url',
        'demo_url',
        'sort_order',
    ];

    protected $casts = [
        'features' => 'array',
        'price' => 'decimal:2',
        'sale_price' => 'decimal:2',
        'is_digital_download' => 'boolean',
        'is_recurring' => 'boolean',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function files()
    {
        return $this->hasMany(ProductFile::class);
    }

    public function licenses()
    {
        return $this->hasMany(License::class);
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }
}
