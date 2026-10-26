<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Reps extends Model
{
    use HasFactory;

    protected $primaryKey = 'report_id';

    protected $table = 'reports';

    public $timestamps = false;

    #[Fillable([
        'reference_code', 'title', 'description', 'category_id', 'sub_category_id',
        'status', 'reporter_name', 'reporter_phone_number', 'reporter_location',
        'reporter_rt', 'latitude', 'longitude', 'boosts', 'assigned_to',
        'submitted_at', 'resolved_at', 'resolution_note',
    ])]
    protected $fillable = [
        'reference_code', 'title', 'description', 'category_id', 'sub_category_id',
        'status', 'reporter_name', 'reporter_phone_number', 'reporter_location',
        'reporter_rt', 'latitude', 'longitude', 'boosts', 'assigned_to',
        'submitted_at', 'resolved_at', 'resolution_note',
    ];

    protected function casts(): array
    {
        return [
            'status' => 'string',
            'latitude' => 'decimal',
            'longitude' => 'decimal',
            'boosts' => 'integer',
            'submitted_at' => 'datetime',
            'resolved_at' => 'datetime',
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
        ];
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Cat::class, 'category_id', 'category_id');
    }

    public function subCategory(): BelongsTo
    {
        return $this->belongsTo(SubCat::class, 'sub_category_id', 'sub_category_id');
    }

    public function assignedUser(): BelongsTo
    {
        return $this->belongsTo(User::class, 'assigned_to', 'user_id');
    }

    public function media(): HasMany
    {
        return $this->hasMany(RepsMedia::class, 'report_id', 'report_id');
    }

    public function comments(): HasMany
    {
        return $this->hasMany(RepsComment::class, 'report_id', 'report_id');
    }

    public function activities(): HasMany
    {
        return $this->hasMany(RepsActivity::class, 'report_id', 'report_id');
    }
}
?>

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Reps extends Model
{
    use HasFactory;

    protected $primaryKey = 'report_id';

    protected $table = 'reports';
    protected $table = 'reports';
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Reps extends Model
{
    use HasFactory;

    protected $primaryKey = 'report_id';

    #[Fillable([
        'reference_code', 'title', 'description', 'category_id', 'sub_category_id',
        'status', 'reporter_name', 'reporter_phone_number', 'reporter_location',
        'reporter_rt', 'latitude', 'longitude', 'boosts', 'assigned_to',
        'submitted_at', 'resolved_at', 'resolution_note',
    ])]
    protected $fillable = [
        'reference_code', 'title', 'description', 'category_id', 'sub_category_id',
        'status', 'reporter_name', 'reporter_phone_number', 'reporter_location',
        'reporter_rt', 'latitude', 'longitude', 'boosts', 'assigned_to',
        'submitted_at', 'resolved_at', 'resolution_note',
    ];

    
    protected function casts(): array
    {
        return [
            'status' => 'string',
            'latitude' => 'decimal',
            'longitude' => 'decimal',
            'boosts' => 'integer',
            'submitted_at' => 'datetime',
            'resolved_at' => 'datetime',
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
        ];
    }

    
    public function category(): BelongsTo
    {
        return $this->belongsTo(Cat::class, 'category_id', 'category_id');
    }

    
    public function subCat(): BelongsTo
    {
        return $this->belongsTo(SubCat::class, 'sub_category_id', 'sub_category_id');
    }

    
    public function assignedUser(): BelongsTo
    {
        return $this->belongsTo(User::class, 'assigned_to', 'user_id');
    }

    
    public function media(): HasMany
    {
        return $this->hasMany(RepsMedia::class, 'report_id', 'report_id');
    }

    
    public function comments(): HasMany
    {
        return $this->hasMany(RepsComment::class, 'report_id', 'report_id');
    }

    
    public function activities(): HasMany
    {
        return $this->hasMany(RepsActivity::class, 'report_id', 'report_id');
    }
}