<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sample_Email extends Model
{
    use HasFactory;
    protected $table = 'sample_email';
    protected $fillable = ['email', 'note'];
}
