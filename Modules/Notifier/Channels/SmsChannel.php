<?php

namespace Modules\Notifier\Channels;

use App\Models\User;
use Illuminate\Notifications\Notification;
use Modules\Notifier\Exceptions\NotificationFailed;

class SmsChannel
{
    protected $config;



    /**
     * send sms via Asanak Panel
     *
     * @param User         $notifiable
     * @param Notification $notification
     */
    public function send($notifiable, $notification)
    {
        $this->config = $this->loadConfig();
        $destination  = $this->getDestination($notifiable);
        $message      = $this->getMessage($notifiable, $notification);
        $response     = $this->curl($message, $destination);

        $this->throwErrorIfFailed($response);
    }



    /**
     * throw error if notification fails.
     *
     * @param string $response
     *
     * @throws NotificationFailed
     */
    protected function throwErrorIfFailed($response)
    {
        if (is_json($response)) {
            $response_array = json_decode($response, true);
            if (isset($response_array['status'])) {
                throw NotificationFailed::submissionError($response_array['status']);
            }

            return;
        }

        throw NotificationFailed::connectionError();
    }



    /**
     * trigger Asanak system to send message.
     *
     * @param string $message
     * @param string $destination
     *
     * @return mixed
     */
    protected function curl(string $message, string $destination)
    {
        $curl = curl_init();

        curl_setopt($curl, CURLOPT_HTTPHEADER, ['Accept: application/json']);
        curl_setopt($curl, CURLOPT_URL, $this->config['url']);
        curl_setopt($curl, CURLOPT_POST, 1);
        curl_setopt($curl, CURLOPT_POSTFIELDS,
             http_build_query([
                  'username'    => $this->config['username'],
                  'password'    => $this->config['password'],
                  'source'      => $this->config['source'],
                  'destination' => $destination,
                  'message'     => $message,
             ]));
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

        $response = curl_exec($curl);
        curl_close($curl);

        return $response;
    }



    /**
     * load config from the config system.
     *
     * @return array
     */
    protected function loadConfig(): array
    {
        $notifier = notifier()::locate("sms","asanak");
        return [
             "username" => $notifier->getData("username"),
             "password" => $notifier->getData("password"),
             "source"   => $notifier->getData("source"),
             "url"      => $notifier->getData("url"),
        ];
    }



    /**
     * get phone number from the notifier instance.
     *
     * @param $notifiable
     *
     * @return string
     */
    protected function getDestination($notifiable): string
    {
        return $notifiable->mobile;
    }



    /**
     * get message from the notification instance.
     *
     * @param              $notifiable
     * @param Notification $notification
     *
     * @return string
     */
    protected function getMessage($notifiable, $notification): string
    {
        return urlencode(trim($notification->toSms($notifiable)));
    }
}
