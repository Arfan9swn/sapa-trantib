<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RT extends Model
{
    use HasFactory;

    protected $table = 'rts';
    protected $fillable = ['rt_number', 'head_name', 'population', 'reports_reported', 'report_type'];
}
 
