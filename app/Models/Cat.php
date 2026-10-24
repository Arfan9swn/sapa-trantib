<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Cat extends Model
{
    use HasFactory;

    protected $primaryKey = 'category_id';

    protected $table = 'categories';

    public $timestamps = false;

    #[Fillable(['name'])]
    protected $fillable = ['name'];

    public function subCategories(): HasMany
    {
        return $this->hasMany(SubCat::class, 'category_id', 'category_id');
    }

    public function reports(): HasMany
    {
        return $this->hasMany(Reps::class, 'category_id', 'category_id');
    }
}