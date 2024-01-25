<?php

namespace Marol\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Marol\Models\Scopes\OrderByTimeScope;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;

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

    /**
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function image(): MorphMany {
        return $this->morphMany(ImagePolymorphic::class, 'imageable');
    }

    /**
     * 封面图
     */
    public function cover_img(): morphOne {
        return $this->image()->where('use_as','cover')->one();
    }

    /**
     * 详情图
     */
    public function detail_img(): MorphMany {
        return $this->image()->where('use_as','detail');
    }

    /**
     * Get the category for the product.
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function category(): BelongsToMany
    {
        return $this->belongsToMany(ProductCategory::class,'relation_products','product_id','product_category_id');
    }                                                       

    /**
     * Get all of the price for the Product
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function price(): HasMany
    {
        return $this->hasMany(ProductPrice::class, 'product_id', 'id');
    }
}
