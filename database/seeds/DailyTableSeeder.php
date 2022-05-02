<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DailyTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        
        $dv = $this->getDailyVerses();
        foreach($dv as $v) {

            $data = $v;
            $data['today']  = false;
            $data['used']   = false;
            DB::table('dailyverses')->insert(
                $data
            );
            unset($data);
        }
    }

    private function getDailyVerses() {
        
        $dv = array(
            0 => array('book'=> 'mt', 'chapter' => '18', 'verses' => '21-22'),
            1 => array('book'=> '2co', 'chapter' => '13', 'verses' => '4-7'),
            2 => array('book'=> 'jo', 'chapter' => '14', 'verses' => '6'),
            3 => array('book'=> 'pv', 'chapter' => '3', 'verses' => '5'),
            4 => array('book'=> 'gl', 'chapter' => '5', 'verses' => '22'),
            5 => array('book'=> 'js', 'chapter' => '1', 'verses' => '9'),
            6 => array('book'=> 'sl', 'chapter' => '27', 'verses' => '14'),
            7 => array('book'=> 'lm', 'chapter' => '3', 'verses' => '22-23'),
            8 => array('book'=> 'sl', 'chapter' => '57', 'verses' => '8'),
            9 => array('book'=> '1pe', 'chapter' => '5', 'verses' => '7'),
            10 => array('book'=> 'mc', 'chapter' => '9', 'verses' => '23'),
            11 => array('book'=> 'sl', 'chapter' => '68', 'verses' => '19'),
            12 => array('book'=> '2cr', 'chapter' => '32', 'verses' => '7'),
            13 => array('book'=> 'na', 'chapter' => '1', 'verses' => '7'),
            14 => array('book'=> 'rm', 'chapter' => '15', 'verses' => '13'),
            15 => array('book'=> 'sl', 'chapter' => '16', 'verses' => '5'),
            16 => array('book'=> 'sl', 'chapter' => '30', 'verses' => '5'),
            17 => array('book'=> 'jr', 'chapter' => '29', 'verses' => '11'),
            18 => array('book'=> 'rm', 'chapter' => '8', 'verses' => '37'),
            19 => array('book'=> 'is', 'chapter' => '41', 'verses' => '10'),
            20 => array('book'=> '2ts', 'chapter' => '3', 'verses' => '3'),
            21 => array('book'=> 'sl', 'chapter' => '55', 'verses' => '22'),
            22 => array('book'=> '1jo', 'chapter' => '1', 'verses' => '9'),
            23 => array('book'=> 'mt', 'chapter' => '19', 'verses' => '26'),
            24 => array('book'=> 'is', 'chapter' => '40', 'verses' => '31'),
            25 => array('book'=> 'jo', 'chapter' => '16', 'verses' => '33'),
            26 => array('book'=> 'sl', 'chapter' => '37', 'verses' => '5'),
            27 => array('book'=> 'lc', 'chapter' => '2', 'verses' => '29-32'),
        );
        return $dv;
    }
}
