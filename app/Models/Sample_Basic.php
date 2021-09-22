<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Sample_Tel;
use App\Models\Sample_Add;
use App\Models\Sample_Email;
use App\Models\Sample_Im;

class Sample_Basic extends Model
{
    use HasFactory;
    protected $table = 'sample';
    protected $primaryKey = 'sampleId';
    public function Telephone () {
        return $this->hasMany(Sample_Tel::class, 'sampleId');
    }
    
    public function Address () {
        return $this->hasMany(Sample_Add::class, 'sampleId');
    }

    public function Email () {
        return $this->hasMany(Sample_Email::class, 'sampleId');
    }

    public function Massanger () {
        return $this->hasMany(Sample_Im::class, 'sampleId');
    }
}
