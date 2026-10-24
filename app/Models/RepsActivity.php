<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RepsActivity extends Model
{
    use HasFactory;

    protected $primaryKey = 'activity_id';

    protected $table = 'report_activity';

    public $timestamps = false;

    #[Fillable(['report_id', 'user_id', 'action', 'old_value', 'new_value', 'created_at'])]
    protected $fillable = ['report_id', 'user_id', 'action', 'old_value', 'new_value', 'created_at'];

    
    public function report(): BelongsTo
    {
        return $this->belongsTo(Reps::class, 'report_id', 'report_id');
    }

    
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }
}