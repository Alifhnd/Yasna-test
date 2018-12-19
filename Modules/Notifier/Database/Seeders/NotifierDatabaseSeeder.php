<?php

namespace Modules\Notifier\Database\Seeders;

use Illuminate\Database\Seeder;

class NotifierDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(SettingsTableSeeder::class);
        $this->call(NotifiersTableSeeder::class);
    }
}
