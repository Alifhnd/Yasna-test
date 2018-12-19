<?php

namespace Modules\Users\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Modules\Yasna\Providers\YasnaServiceProvider;

class SettingsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
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
                  'slug'          => 'combine_admin_roles_on_manage_sidebar',
                  'title'         => trans_safe("users::seeders.fold-admins-title"),
                  'category'      => 'upstream',
                  'order'         => '91',
                  'data_type'     => 'boolean',
                  'default_value' => '0',
                  'hint'          => '',
             ],
        ];
    }



    /**
     * @return string
     */
    private function defaultPermits()
    {
        $array = [
             "activate: فعال‌سازی",
             "bin: زباله‌دان",
             "block: مسدودسازی",
             "browse: پیمایش",
             "category: دسته‌بندی",
             "create: افزودن",
             "delete: حذف",
             "edit: ویرایش",
             "files: فایل منیجر",
             "permit: سطح دسترسی",
             "print: چاپ",
             "process: اقدام",
             "publish: انتشار",
             "report: گزارش",
             "search: جست‌وجو",
             "send: ارسال ایمیل/پیامک",
             "settings: تنظیمات",
             "view: نمایش",
        ];

        return implode(LINE_BREAK, $array);
    }
}
