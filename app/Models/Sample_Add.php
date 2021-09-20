<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sample_Add extends Model
{
    use HasFactory;
    protected $table = 'sample_add';
    protected $columns = ['id', 'sampleId', 'category', 'add', 'note', 'GPS'];
    protected $fillable = ['sampleId', 'category', 'add', 'note'];
}
