<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OtpVerification extends Model
{
    use HasFactory;

    protected $primaryKey = 'otp_id';

    protected $table = 'email_verifications';

    public $timestamps = false;

    #[Fillable(['email', 'otp_code', 'expires_at', 'used_at', 'created_at'])]
    protected $fillable = ['email', 'otp_code', 'expires_at', 'used_at', 'created_at'];

    protected function casts(): array
    {
        return [
            'expires_at' => 'datetime',
            'used_at' => 'datetime',
            'created_at' => 'datetime',
        ];
    }

    public function isValid(): bool
    {
        return $this->used_at === null && now()->before($this->expires_at);
    }
}