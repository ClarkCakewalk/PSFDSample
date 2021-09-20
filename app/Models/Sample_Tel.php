<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sample_Tel extends Model
{
    use HasFactory;
    protected $table = 'sample_tel';
    protected $fillable = ['sampleId','category', 'number', 'note'];
}
