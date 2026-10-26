<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RepsComment extends Model
{
    use HasFactory;

    protected $primaryKey = 'comment_id';

    public $timestamps = false;

    #[Fillable(['report_id', 'body', 'created_at'])]
    protected $fillable = ['report_id', 'body', 'created_at'];

    
    public function report(): BelongsTo
    {
        return $this->belongsTo(Reps::class, 'report_id', 'report_id');
    }
}