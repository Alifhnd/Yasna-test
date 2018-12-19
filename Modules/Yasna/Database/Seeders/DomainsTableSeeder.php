<?php

namespace Modules\Yasna\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class DomainsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
             [
                  'slug'       => "global",
                  'title'      => "سراسری",
                  'created_at' => \Carbon\Carbon::now()->toDateTimeString(),
             ],
        ];

        yasna()->seed('domains', $data);
    }
}
