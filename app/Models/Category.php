<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Category model for categories and subcategories.
 *
 * @property string $name_lv
 * @property string $name_en
 * @property string $name_ru
 * @property string $slug_lv
 * @property string $slug_en
 * @property string $slug_ru
 * @property int|null $parent_id
 */
class Category extends Model
{
    protected $fillable = [
        'name_lv',
        'name_en',
        'name_ru',
        'slug_lv',
        'slug_en',
        'slug_ru',
        'parent_id'
    ];

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
    }

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

    /**
     * Get the icon path for the category.
     *
     * @return string
     */
    public function getIconPath(): string
    {
        return "svg/categories/{$this->slug_en}.svg";
    }

    /**
     * Get the localized slug based on the current application locale.
     *
     * @return string
     */
    public function getSlug(): string
    {
        return $this->{'slug_' . app()->getLocale()} ?? $this->{'slug_' . config('app.fallback_locale')};
    }

    /**
     * Get the localized URL for the category.
     *
     * @return string
     */
    public function getUrl(): string
    {
        return route('categories.show', ['slug' => $this->getSlug()]);
    }
}
