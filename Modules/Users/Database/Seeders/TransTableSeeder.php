<?php

namespace Modules\Users\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class TransTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        yasna()->seed("translations", $this->dataArray());
    }



    /**
     * get data array, ready to be seeded
     *
     * @return array
     */
    private function dataArray(): array
    {
        $array = [];
        foreach ($this->transArray() as $slug => $trans) {
            $array[] = [
                 "slug"   => $slug,
                 "locale" => "fa",
                 "value"  => $trans,
            ];
        }

        return $array;
    }



    /**
     * get translations array
     *
     * @return array
     */
    private function transArray()
    {
        return (array)trans("users::seeders.dynamic");
    }
}
