<?php
/**
 * Created by PhpStorm.
 * User: emitis
 * Date: 10/23/18
 * Time: 11:38 AM
 */

namespace Modules\Manage\Services\Support;

use Carbon\Carbon;
use GuzzleHttp\Client as GuzzleClient;
use Modules\Yasna\Services\ModuleTraits\ModuleRecognitionsTrait;

class SupportHandler
{
    use ModuleRecognitionsTrait;
    /**
     * The Token to be used in the whole request
     *
     * @var string|null
     */
    protected static $token;
    /**
     * An Array of Ticket Types
     *
     * @var array
     */
    protected static $ticket_types = [];
    /**
     * An Array of Flags
     *
     * @var array
     */
    protected static $flags = [];



    /**
     * Returns the token.
     *
     * @return null|string
     */
    public function getToken()
    {
        if (!static::$token) {
            static::$token = $this->provideToken();
        }

        return static::$token;
    }



    /**
     * Provides a token.
     *
     * @return null|string
     */
    protected function provideToken()
    {
        $session_token = $this->sessionToken();

        if ($session_token) {
            return $session_token;
        }

        return $this->requestToken();
    }



    /**
     * Returns a valid token from session if it exists.
     *
     * @return null|string
     */
    protected function sessionToken()
    {
        if ($this->hasNotSessionToken()) {
            return null;
        }

        if ($this->sessionTokenIsNotReliable()) {
            return null;
        }

        return $this->getSessionTokenValue();
    }



    /**
     * Whether there is a token stored in the session.
     *
     * @return bool
     */
    protected function hasSessionToken()
    {
        return session()->has($this->sessionTokenName());
    }



    /**
     * Whether there is no token stored in the session.
     *
     * @return bool
     */
    protected function hasNotSessionToken()
    {
        return !$this->hasSessionToken();
    }



    /**
     * Whether the token is reliable.
     *
     * @return bool
     */
    protected function sessionTokenIsReliable()
    {
        $expiration_key = $this->sessionTokenName() . '.' . $this->sessionTokenExpirationKey();

        if (!session()->has($expiration_key)) {
            return false;
        }

        $expiration_time = session()->get($expiration_key);

        return Carbon::parse($expiration_time)->greaterThanOrEqualTo(now());
    }



    /**
     * Whether the token is not reliable.
     *
     * @return bool
     */
    protected function sessionTokenIsNotReliable()
    {
        return !$this->sessionTokenIsReliable();
    }



    /**
     * Returns the name of the session which stores the token.
     *
     * @return string
     */
    protected function sessionTokenName()
    {
        return $this->runningModule()->getConfig('support.session');
    }



    /**
     * Returns the value of the token stored in the session.
     *
     * @return string|null
     */
    protected function getSessionTokenValue()
    {
        return session()->get(
             $this->sessionTokenName()
             . '.'
             . $this->tokenSessionValueKey()
        );
    }



    /**
     * Requests a token from API and returns it.
     *
     * @return string|null
     */
    protected function requestToken()
    {
        $client         = $this->authClientObject();
        $username_field = $this->getYasnaConfig('username_field');
        $username       = $this->getYasnaConfig('username');
        $password       = $this->getYasnaConfig('password');

        $response = $client->post('login', [
             'form_params' => [
                  $username_field => $username,
                  'password'      => $password,
             ],
        ]);

        $response_array = (json_decode($response->getBody(), true) ?? []);

        return $this->setTokenInSession($response_array);
    }



    /**
     * Sets the token and its expiration time in the session
     * and returns the set token.
     *
     * @param array $response_array An array version of the response received from the login action.
     *
     * @return string|null
     */
    protected function setTokenInSession(array $response_array)
    {
        $token      = ($response_array['access_token'] ?? null);
        $expiration = ($response_array['expires_in'] ?? null);

        if (!$token or !$expiration) {
            return null;
        }

        session()->put($this->sessionTokenName(), [
             $this->tokenSessionValueKey()      => $token,
             $this->sessionTokenExpirationKey() => now()->addSeconds($expiration)->toDateTimeString(),
        ]);

        return $token;
    }



    /**
     * Returns the key of the value of the token in the session.
     *
     * @return string
     */
    protected function tokenSessionValueKey()
    {
        return 'token';
    }



    /**
     * Returns the key of the expiration time of the token in the session.
     *
     * @return string
     */
    protected function sessionTokenExpirationKey()
    {
        return 'expires_at';
    }



    /**
     * Returns a part of the Yasna supporting configs.
     *
     * @param string $config_name
     *
     * @return string
     */
    protected function getYasnaConfig(string $config_name)
    {
        return $this->runningModule()->getConfig("support.yasna.$config_name");
    }



    /**
     * Whether the support section is authorized.
     *
     * @return bool
     */
    public function isAuthorized()
    {
        return boolval($this->getToken());
    }



    /**
     * Whether the support section is not authorized.
     *
     * @return bool
     */
    public function isNotAuthorized()
    {
        return !$this->isAuthorized();
    }



    /**
     * Returns an instance of the `GuzzleHttp\Client` class
     *
     * @param string $additive_url An string to be appended to the base URL.
     * @param array  $options
     *
     * @return GuzzleClient
     */
    public function clientObject(string $additive_url = '', array $options = [])
    {
        $options = array_merge_recursive($this->defaultRequestOptions($additive_url), $options);

        return new GuzzleClient($options);
    }



    /**
     * Returns the basic request options.
     *
     * @param string $additive_url An string to be appended to the base URL.
     *
     * @return array
     */
    protected function defaultRequestOptions(string $additive_url)
    {
        return [
             'base_uri'    => $this->generalBaseUrl() . $additive_url,
             'http_errors' => false,
        ];
    }



    /**
     * Returns an instance of the `GuzzleHttp\Client` class
     * to be used for authentication/authorization request.
     *
     * @return GuzzleClient
     */
    protected function authClientObject()
    {
        return $this->clientObject('api/');
    }



    /**
     * Returns an instance of the `GuzzleHttp\Client` class
     * to be used for request which need authorization.
     *
     * @param string $additive_url An string to be appended to the base URL.
     * @param array  $options
     *
     * @return GuzzleClient
     */
    public function authorizedClientObject(string $additive_url = '', array $options = [])
    {
        $options = array_merge_recursive([
             'headers' => [
                  'Authorization' => 'Bearer ' . $this->getToken(),
             ],
        ], $options);

        return $this->clientObject($additive_url, $options);
    }



    /**
     * Returns the general base url for all request.
     *
     * @return string
     */
    protected function generalBaseUrl()
    {
        return $this->runningModule()->getConfig('support.yasna.domain') . '/';
    }



    /**
     * Returns an array of ticket types if API is acceptable.
     *
     * @return array
     */
    public function getTicketTypes()
    {
        if (!static::$ticket_types) {

            $response = $this->authorizedClientObject('tickets/api/v1/')
                             ->get('types')
            ;

            $response_array = json_decode($response->getBody(), true);

            static::$ticket_types = ($response_array['results'] ?? []);
        }

        return static::$ticket_types;
    }



    /**
     * Returns an array of sidebar submenus.
     *
     * @return array
     */
    public function sidebarSubmenus()
    {
        $types = yasnaSupport()->getTicketTypes();

        if (empty($types)) {
            return [];
        }

        $manage_url = url('manage') . '/';
        $submenus   = [
             [
                  'link'    => str_after(route('manage.support.new'), $manage_url),
                  'caption' => trans('manage::support.new-ticket'),
             ],
        ];

        foreach ($types as $type) {
            $submenus[] = [
                 'link'    => str_after(
                      route('manage.support.list', ['type' => $type['slug']]),
                      $manage_url
                 ),
                 'caption' => $type['title'],
            ];
        }

        return $submenus;
    }



    /**
     * Returns information of a ticket type.
     *
     * @param string $slug
     *
     * @return array|null
     */
    public function getTicketTypeInfo(string $slug)
    {
        return collect($this->getTicketTypes())
             ->filter(function ($type) use ($slug) {
                 return ($type['slug'] == $slug);
             })->first()
             ;
    }



    /**
     * Returns an array of flags.
     *
     * @return array
     */
    public function getFlags()
    {

        if (!static::$flags) {

            $response = $this->authorizedClientObject('tickets/api/v1/')
                             ->get('flags')
            ;

            $response_array = json_decode($response->getBody(), true);

            static::$flags = ($response_array['results'] ?? []);
        }

        return static::$flags;
    }



    /**
     * Returns information of a flag.
     *
     * @param static $slug
     *
     * @return array|null
     */
    public function getFlagInfo($slug)
    {
        return collect($this->getFlags())
             ->filter(function ($type) use ($slug) {
                 return ($type['slug'] == $slug);
             })->first()
             ;
    }



    /**
     * Whether all configs are needed available.
     *
     * @return bool
     */
    public function allConfigsAreAvailable()
    {
        if (!$this->getYasnaConfig('domain')) {
            return false;
        }

        if (!$this->getYasnaConfig('username_field')) {
            return false;
        }

        if (!$this->getYasnaConfig('username')) {
            return false;
        }

        if (!$this->getYasnaConfig('password')) {
            return false;
        }

        return true;
    }



    /**
     * Whether the support section is available.
     *
     * @return bool
     */
    public function isAvailable()
    {
        return ($this->allConfigsAreAvailable() and $this->isAuthorized());
    }



    /**
     * Whether the support section is not available.
     *
     * @return bool
     */
    public function isNotAvailable()
    {
        return !$this->isAvailable();
    }
}
