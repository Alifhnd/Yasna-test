<?php

namespace Modules\Yasna\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class SettingsTableSeeder extends Seeder
{
    /**
     * @inheritdoc
     */
    public function run()
    {
        yasna()->seed('settings', $this->mainData());
    }



    /**
     * Gets an array of settings entries to be seeded in the database
     *
     * @return array
     */
    public function mainData()
    {
        return
             [
                  [
                       'slug'          => "site_title",
                       'title'         => trans_safe("yasna::seeders.site_title"),
                       'order'         => "1",
                       'category'      => "upstream",
                       'data_type'     => "text",
                       'default_value' => trans_safe("yasna::seeders.site_title_default"),
                       'is_localized'  => "1",
                  ],
                  [
                       'slug'          => "site_locales",
                       'title'         => trans_safe("yasna::seeders.site_locales"),
                       'order'         => "3",
                       'category'      => "upstream",
                       'data_type'     => "array",
                       'default_value' => "fa" . HTML_LINE_BREAK . "en",
                       'is_localized'  => "0",
                       'css_class'     => "ltr",
                  ],
                  [
                       'slug'          => "site_activeness",
                       'title'         => trans_safe("yasna::seeders.site_activeness"),
                       'order'         => "2",
                       'category'      => "template",
                       'data_type'     => "boolean",
                       'default_value' => '1',
                       'is_localized'  => "1",
                  ],
                  [
                       'slug'          => "overall_activeness",
                       'title'         => trans_safe("yasna::seeders.overall_activeness"),
                       'order'         => "2",
                       'category'      => "upstream",
                       'data_type'     => "boolean",
                       'default_value' => '1',
                       'is_localized'  => "0",
                  ],
                  [
                       'slug'          => "ssl_available",
                       'title'         => trans_safe("yasna::seeders.ssl_available"),
                       'order'         => "11",
                       'category'      => "upstream",
                       'data_type'     => "boolean",
                       'default_value' => '0',
                       'is_localized'  => "0",
                  ],
                  [
                       'slug'          => "currency",
                       'title'         => trans_safe("yasna::seeders.currency"),
                       'order'         => "21",
                       'category'      => "database",
                       'data_type'     => "text",
                       'default_value' => trans_safe("yasna::seeders.currency_default"),
                       'is_localized'  => "1",
                  ],
                  [
                       'slug'          => "site_logo",
                       'title'         => trans_safe("yasna::seeders.site_logo"),
                       'order'         => "10",
                       'category'      => "template",
                       'data_type'     => "photo",
                       'default_value' => 'assets/images/yasnateam-logo.png',
                       'is_localized'  => "1",
                  ],
                  [
                       'slug'          => "address",
                       'title'         => trans_safe("yasna::seeders.address"),
                       'order'         => "22",
                       'category'      => "contact",
                       'data_type'     => "textarea",
                       'default_value' => trans_safe("yasna::seeders.address_default"),
                       'is_localized'  => "1",
                  ],
                  [
                       'slug'          => "telephone",
                       'title'         => trans_safe("yasna::seeders.telephone"),
                       'order'         => "20",
                       'category'      => "contact",
                       'data_type'     => "array",
                       'default_value' => "+98(21)22505661",
                       'is_localized'  => "0",
                       'css_class'     => "ltr",
                  ],
                  [
                       'slug'          => "email",
                       'title'         => trans_safe("yasna::seeders.email"),
                       'order'         => "21",
                       'category'      => "contact",
                       'data_type'     => "array",
                       'default_value' => "hello@yasnateam.com",
                       'is_localized'  => "0",
                       'css_class'     => "ltr",
                  ],
                  [
                       'slug'          => "telegram_link",
                       'title'         => trans_safe("yasna::seeders.telegram_link"),
                       'order'         => "31",
                       'category'      => "socials",
                       'data_type'     => "text",
                       'default_value' => 'http://telegram.me/account',
                       'is_localized'  => "0",
                       'css_class'     => "ltr",
                  ],
                  [
                       'slug'          => "twitter_link",
                       'title'         => trans_safe("yasna::seeders.twitter_link"),
                       'order'         => "31",
                       'category'      => "socials",
                       'data_type'     => "text",
                       'default_value' => 'http://twitter.com/account',
                       'is_localized'  => "0",
                       'css_class'     => "ltr",
                  ],
                  [
                       'slug'          => "facebook_link",
                       'title'         => trans_safe("yasna::seeders.facebook_link"),
                       'order'         => "31",
                       'category'      => "socials",
                       'data_type'     => "text",
                       'default_value' => 'http://fb.com/account',
                       'is_localized'  => "0",
                       'css_class'     => "ltr",
                  ],
                  [
                       'slug'          => "instagram_link",
                       'title'         => trans_safe("yasna::seeders.instagram_link"),
                       'order'         => "31",
                       'category'      => "socials",
                       'data_type'     => "text",
                       'default_value' => 'http://instagram.com/account',
                       'is_localized'  => "0",
                       'css_class'     => "ltr",
                  ],
                  [
                       'slug'          => "location",
                       'title'         => trans_safe("yasna::seeders.location"),
                       'order'         => "41",
                       'category'      => "contact",
                       'data_type'     => "array",
                       'default_value' => "35.7448" . HTML_LINE_BREAK . "51.3753",
                       'is_localized'  => "0",
                       'css_class'     => "ltr",
                  ],
                  [
                       'slug'          => "password_token_expire_time",
                       'title'         => trans_safe("yasna::seeders.password_token_expire_time"),
                       'order'         => "31",
                       'category'      => "upstream",
                       'data_type'     => "text",
                       'default_value' => '30',
                       'is_localized'  => "0",
                  ],
                  [
                       'slug'          => "site_url",
                       'title'         => trans_safe("yasna::seeders.site_url"),
                       'order'         => "31",
                       'category'      => "upstream",
                       'data_type'     => "text",
                       'default_value' => url(''),
                       'is_localized'  => "0",
                       'css_class'     => "ltr",
                  ],
                  [
                       'slug'          => 'notifications_intervals',
                       'title'         => trans_safe("yasna::seeders.notifications_intervals"),
                       'category'      => 'upstream',
                       'order'         => '12',
                       'data_type'     => 'text',
                       'default_value' => '30',
                       'hint'          => trans_safe("yasna::seeders.notifications_intervals_hint"),
                       'css_class'     => 'ltr',
                       'is_localized'  => '0',
                  ],
                  [
                       'slug'          => "captcha_site_key",
                       'title'         => trans_safe("yasna::seeders.captcha_site_key"),
                       'order'         => "40",
                       'category'      => "upstream",
                       'data_type'     => "text",
                       'default_value' => '6LfzW0QUAAAAAEuV8ZUa8tvVLWCVy7-6IkH5Mvcy',
                       'is_localized'  => "0",
                       'hint'          => trans_safe("yasna::seeders.captcha_hint"),
                  ],
                  [
                       'slug'          => "captcha_secret_key",
                       'title'         => trans_safe("yasna::seeders.captcha_secret_key"),
                       'order'         => "41",
                       'category'      => "upstream",
                       'data_type'     => "text",
                       'default_value' => '6LfzW0QUAAAAAPXQr16nvN6nY1O3KC1D0_fn9OKw',
                       'is_localized'  => "0",
                       'hint'          => trans_safe("yasna::seeders.captcha_hint"),
                  ],
                  [
                       "slug"          => "app_key",
                       "title"         => trans_safe("yasna::seeders.app_key"),
                       "category"      => "upstream",
                       "order"         => "6",
                       "data_type"     => "text",
                       "default_value" => encrypt(1),
                  ],
                  [
                       'slug'         => 'optional_front_script',
                       'title'        => trans_safe("yasna::seeders.optional_front_script.title"),
                       'category'     => 'template',
                       'order'        => '11',
                       'data_type'    => 'textarea',
                       'hint'         => trans_safe("yasna::seeders.optional_front_script.hint"),
                       'is_localized' => '0',
                  ],
                  [
                       'slug'         => 'favicon',
                       'title'        => trans_safe("yasna::seeders.favicon.title"),
                       'category'     => 'template',
                       'order'        => '6',
                       'data_type'    => 'file',
                       'is_localized' => '0',
                  ],
                  [
                       "slug"          => "active_modules",
                       'title'         => trans_safe("yasna::seeders.active_modules"),
                       "default_value" => "Yasna|Manage",
                       "category"      => "upstream",
                       "order"         => "6",
                       "data_type"     => "text",
                       'is_localized'  => '0',
                  ],

             ];
    }
}
