<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SampleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('sample')->insert([
            'sampleId' => '9990020',
            'quesName' => 'RR2022',
            'name' => '陳怡文',
            'gender' => '2',
            'birthYear' => '1975',
            'birthMonth' => '5',
            'status' => '1',
            'mail' => '1',
            'mode' => '1',
            'liCode' => '65000110034',
            'mainAdd' => '6'
        ]);
        DB::table('sample_add')->insert([
            'id' => '6',
            'sampleId' => '9990020',
            'category' => '1',
            'add' => '新北市汐止區福德里仁愛路115號'
        ]);
    }
}
