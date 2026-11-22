<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class NewResidenceReport extends Model
{
    use HasFactory;

    protected $primaryKey = 'new_residence_id';

    protected $table = 'new_residence_reports';

    public $timestamps = true;

    #[Fillable([
        'user_id', 'nik', 'nama', 'nomor_telepon', 'alamat', 'status',
    ])]
    protected $fillable = [
        'user_id', 'nik', 'nama', 'nomor_telepon', 'alamat', 'status',
    ];

    protected function casts(): array
    {
        return [
            'status' => 'string',
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }
}