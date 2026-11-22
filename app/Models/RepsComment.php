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

    protected $table = 'report_comments';

    public $timestamps = false;

    #[Fillable(['report_id', 'body', 'created_at', 'user_id'])]
    protected $fillable = ['report_id', 'body', 'created_at', 'user_id'];

    
    public function report(): BelongsTo
    {
        return $this->belongsTo(Reps::class, 'report_id', 'report_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }
}