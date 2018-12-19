<?php

namespace Modules\Manage\Database\Seeders;

use Illuminate\Database\Seeder;

class SettingTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        yasna()->seed('settings', $this->mainData());
    }



    /**
     * @return array
     */
    public function mainData()
    {
        return [
             [
                  'slug'      => 'site_logo_tiny',
                  'title'     => trans_safe("yasna::seeders.site_logo_tiny"),
                  'category'  => 'upstream',
                  'order'     => '7',
                  'data_type' => 'photo',
             ],
             [
                  'slug'          => 'default-avatar',
                  'title'         => trans_safe("yasna::seeders.default-avatar"),
                  'category'      => 'upstream',
                  'order'         => '20',
                  'data_type'     => 'photo',
                  'default_value' => 'nAyBx',
             ],
             [
                  'slug'          => 'manage-small-logo',
                  'title'         => trans_safe('manage::settings.seeder.manage_small_logo'),
                  'category'      => 'template',
                  'order'         => '7',
                  'data_type'     => 'photo',
                  'default_value' => '',
                  'hint'          => '',
                  'css_class'     => '',
                  'is_localized'  => '0',
             ],
             [
                  'slug'          => 'manage-large-logo',
                  'title'         => trans_safe('manage::settings.seeder.manage_large_logo'),
                  'category'      => 'template',
                  'order'         => '7',
                  'data_type'     => 'photo',
                  'default_value' => '',
                  'hint'          => '',
                  'css_class'     => '',
                  'is_localized'  => '1',
             ],
             [
                  'slug'          => 'manage-default-theme',
                  'title'         => trans_safe('manage::settings.seeder.manage_default_theme'),
                  'category'      => 'template',
                  'order'         => '8',
                  'data_type'     => 'text',
                  'default_value' => 'theme-a',
                  'hint'          => trans_safe('manage::settings.seeder.manage_default_theme_hint'),
                  'css_class'     => '',
                  'is_localized'  => '0',
             ],
             [
                  'slug'          => 'weather_providers',
                  'title'         => trans_safe("manage::dashboard.weather.providers"),
                  'category'      => 'upstream',
                  'order'         => '0',
                  'data_type'     => 'array',
                  'default_value' => 'Yahoo|OpenWeatherMap',
                  'hint'          => '',
             ],

        ];
    }
}
