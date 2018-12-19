<?php

namespace Modules\Yasna\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Modules\Yasna\Entities\User;

class DeveloperTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if (user()->count()) {
            return;
        }

        $user = user()->batchSave([
             "code_melli" => "4608968882",
             "email"      => "dev@yasnateam.com",
             "name_first" => trans_safe("yasna::seeders.dev_first_name"),
             "name_last"  => trans_safe("yasna::seeders.dev_last_name"),
             'password'   => '$2y$10$U53pXZEMjLfkoSccigVdQunR/FLcw4K0up5YSVTeHaDBwQLQmHhrC',
        ]);

        $user->attachRole('manager', 8);
        $user->markAsDeveloper();
    }
}
