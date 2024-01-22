<?php

namespace Marol\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class ImagePolymorphic extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'image_polymorphic';

    public $guarded = [];

    public function imageable(): MorphTo{
        return $this->morphTo();
    }
}
