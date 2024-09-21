<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Category model for categories and subcategories.
 */
class Category extends Model
{
    protected $fillable = [
        'name_lv', 'name_en', 'name_ru',
        'slug_lv', 'slug_en', 'slug_ru',
        'parent_id'
    ];

    /**
     * Get the parent category (if this is a subcategory).
     *
     * @return BelongsTo
     */
    public function parent(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }

    /**
     * Get the subcategories (children) for this category.
     *
     * @return HasMany
     */
    public function children(): HasMany
    {
        return $this->hasMany(Category::class, 'parent_id');
    }
}
