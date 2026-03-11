<?php
// app/Models/Product.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'slug', 'description', 'price', 'category_id',
        'image_url', 'cloudinary_public_id', 'stock', 'status'
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'stock' => 'integer'
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function scopeAvailable($query)
    {
        return $query->where('status', 'active')->where('stock', '>', 0);
    }

    public function getFormattedPriceAttribute()
    {
        return '₹' . number_format($this->price, 2);
    }

    public function getStockStatusAttribute()
    {
        if ($this->stock > 10) return 'In Stock';
        if ($this->stock > 0) return 'Only ' . $this->stock . ' left';
        return 'Out of Stock';
    }

    public function getStockColorAttribute()
    {
        if ($this->stock > 10) return 'success';
        if ($this->stock > 0) return 'warning';
        return 'danger';
    }
}