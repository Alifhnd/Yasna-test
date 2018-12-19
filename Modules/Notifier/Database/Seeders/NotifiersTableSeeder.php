<?php

namespace Modules\Notifier\Database\Seeders;

use Illuminate\Database\Seeder;

class NotifiersTableSeeder extends Seeder
{
    protected $data = [];



    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->prepareDataForSmtp();
        $this->prepareDataForAsanak();

        yasna()::seed("notifiers", $this->data);
    }



    /**
     * Prepare $this->data for Asanak SMS driver
     *
     * @return void
     */
    protected function prepareDataForAsanak()
    {
        $this->data[] = [
             "channel"              => $channel = "sms",
             "driver"               => $driver = "asanak",
             "slug"                 => notifier()::generateSlug($channel, $driver),
             "title"                => notifier()::generateTitle($channel, $driver),
             "available_for_admins" => "0",
             "meta-data"            => [
                  "username" => env("ASANAK_SMS_USERNAME"),
                  "password" => env("ASANAK_SMS_PASSWORD"),
                  "source"   => env("ASANAK_SMS_SOURCE"),
                  "url"      => env("ASANAK_SMS_URL"),
             ],
        ];
    }



    /**
     * Prepare $this->data for SMTP driver
     *
     * @return void
     */
    protected function prepareDataForSmtp()
    {
        $this->data[] = [
             "channel"              => $channel = "mail",
             "driver"               => $driver = "smtp",
             "slug"                 => notifier()::generateSlug($channel, $driver),
             "title"                => notifier()::generateTitle($channel, $driver),
             "available_for_admins" => "0",
             "meta-data"            => [
                  "username"     => env("MAIL_USERNAME"),
                  "password"     => env("MAIL_PASSWORD"),
                  "host"         => "smtp.yasna.team",
                  "port"         => "587",
                  "from-address" => "no-reply@yasna.team",
                  "from-name"    => "Yasnateam Notifier",
                  "encryption"   => null,
                  //"sendmail"       => "",
                  //"markdown-theme" => "",
                  //"markdown-paths" => "",
             ],
        ];
    }
}
