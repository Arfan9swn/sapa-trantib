<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Storage;

class RepsMedia extends Model
{
    use HasFactory;

    protected $primaryKey = 'media_id';

    protected $table = 'report_media';

    public $timestamps = false;

    #[Fillable(['report_id', 'media_url', 'media_type', 'uploaded_at'])]
    protected $fillable = ['report_id', 'media_url', 'media_type', 'uploaded_at'];

    public function getUrlAttribute(): string
    {
        return asset('storage/' . $this->media_url);
    }

    public function getPathAttribute(): string
    {
        return $this->media_url;
    }

    public function report(): BelongsTo
    {
        return $this->belongsTo(Reps::class, 'report_id', 'report_id');
    }
}