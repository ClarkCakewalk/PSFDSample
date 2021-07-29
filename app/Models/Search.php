<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Search extends Model
{
    use HasFactory;
    protected $table = 'sample';
    protected $primaryKey = 'sampleId';
    public $incrementing = false;

    public function Adds () {
        return $this->hasMany(Sample_Add::class, 'sampleId');
    }

    public function Emails () {
        return $this->hasMany(Sample_Email::class,'sampleId');
    }

    public function Tels () {
        return $this->hasMany(Sample_Tel::class, 'sampleId');
    }

    public function Results () {
        return $this->hasMany(Sample_Result::class, 'sampleId');
    }

    public function Ims () {
        return $this->hasMany(Sample_Im::class, 'sampleId');
    }

    public function Liname () {
        return $this->hasOne(li::class, 'licode', 'liCode');
    }
}
