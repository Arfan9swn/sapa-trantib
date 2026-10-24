<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RepsMedia extends Model
{
    use HasFactory;

    protected $primaryKey = 'media_id';

    public $timestamps = false;

    #[Fillable(['report_id', 'media_url', 'media_type', 'uploaded_at'])]
    protected $fillable = ['report_id', 'media_url', 'media_type', 'uploaded_at'];

    
    public function report(): BelongsTo
    {
        return $this->belongsTo(Reps::class, 'report_id', 'report_id');
    }
}