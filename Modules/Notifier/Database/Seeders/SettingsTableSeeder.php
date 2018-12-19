<?php

namespace Modules\Notifier\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class SettingsTableSeeder extends Seeder
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
                  'slug'          => notifier()::DEFAULT_SETTING_SLUG,
                  'title'         => trans("notifier::general.setting_seeder"),
                  'category'      => "upstream",
                  'order'         => 12,
                  'data_type'     => "text",
                  'default_value' => "mail:smtp",
             ],
        ];

        yasna()::seed("settings", $data);
    }
}
