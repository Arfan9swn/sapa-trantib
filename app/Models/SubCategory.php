<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class SubCat extends Model
{
    use HasFactory;

    protected $primaryKey = 'sub_category_id';

    public $timestamps = false;

    #[Fillable(['category_id', 'name'])]
    protected $fillable = ['category_id', 'name'];

    
    public function category(): BelongsTo
    {
        return $this->belongsTo(Cat::class, 'category_id', 'category_id');
    }

    public function reports(): HasMany
    {
        return $this->hasMany(Reps::class, 'sub_category_id', 'sub_category_id');
    }
}