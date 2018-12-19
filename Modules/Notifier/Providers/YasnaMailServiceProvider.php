<?php

namespace Modules\Notifier\Providers;

use App\Models\Notifier;
use Illuminate\Mail\MailServiceProvider;

class YasnaMailServiceProvider extends MailServiceProvider
{
    /**
     * @inheritdoc
     */
    public function register()
    {
        if (module()->isInitialized() and module("notifier")->getStatus() and notifier()->hasField('id')) {
            $this->setConfigFromDatabase();
        }

        parent::register();
    }



    /**
     * set config from database
     *
     * @return void
     */
    protected function setConfigFromDatabase()
    {
        $notifier = notifier()::locateDefaultDriverOf("mail");
        if (!$notifier->exists) {
            return;
        }

        config(["mail" => $this->loadConfigFromDatabase($notifier)]);
    }



    /**
     * load config from database
     *
     * @param Notifier $notifier
     *
     * @return array
     */
    protected function loadConfigFromDatabase($notifier)
    {
        return [
             'driver'     => $notifier->driver,
             'host'       => $notifier->getData('host'),
             'port'       => $notifier->getData('port'),
             'from'       => [
                  'address' => $notifier->getData('from-address'),
                  'name'    => $notifier->getData('from-name'),
             ],
             'encryption' => $notifier->getData('encryption'),
             'username'   => $notifier->getData('username'),
             'password'   => $notifier->getData('password'),
             'sendmail'   => config("mail.sendmail"),
             'markdown'   => [
                  "theme" => config("mail.markdown.theme"), //@TODO: prepare some themes, for rtl and ltr languages.
                  "paths" => config("mail.markdown.paths"),
             ],
        ];
    }
}
