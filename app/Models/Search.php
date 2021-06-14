<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Search extends Model
{
    use HasFactory;
    protected $table = 'sample';
    protected $primaryKey = 'sampleId';

    public function Adds () {
        return $this->hasMany(Sample_Add::class, 'sampleId');
    }
}
