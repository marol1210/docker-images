<?php

namespace Marol\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Marol\Models\Scopes\OrderByTimeScope;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Product extends Model
{
    use SoftDeletes;
    use HasFactory;

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    // protected $casts = [
    //     'created_at' => 'datetime:Y-m-d H:i:s',
    //     'updated_at' => 'datetime:Y-m-d H:i:s'
    // ];


    /**
     * The "booted" method of the model.
     */
    protected static function booted(): void
    {
        static::addGlobalScope(new OrderByTimeScope);
    }


    public function image(): MorphOne{
        return $this->morphOne(ImagePolymorphic::class, 'imageable');
    }


    /**
     * Get the comments for the blog post.
     */
    public function category(): BelongsToMany
    {
        return $this->belongsToMany(ProductCategory::class,'relation_products','product_id','product_category_id');
    }                                                       
}
