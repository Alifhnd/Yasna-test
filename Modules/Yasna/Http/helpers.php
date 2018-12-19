<?php

use Carbon\Carbon;
use Illuminate\Contracts\Encryption\DecryptException;

define("SPACE", " ");
define("TAB", SPACE . SPACE . SPACE . SPACE);
define("MODELS_NAMESPACE", "App\\Models\\");
define("JSVOID", "javascript:void(0)");
define("HTML_LINE_BREAK", "\r\n");
define("LINE_BREAK", "
");

/*
|--------------------------------------------------------------------------
| Language Helpers
|--------------------------------------------------------------------------
|
*/

if (!function_exists("trans_safe")) {
    /**
     * translates, using Laravel builtin trans(), but returns the last part if not found.
     *
     * @param null  $key
     * @param array $replace
     * @param null  $locale
     *
     * @return string
     */
    function trans_safe($key = null, $replace = [], $locale = null)
    {
        return yasna()->transSafe($key, $replace, $locale);
    }
}

if (!function_exists("getLocale")) {

    /**
     * A shortcut to the original Laravel's locale detector.
     *
     * @return string
     */
    function getLocale()
    {
        return app()->getLocale();
    }
}

if (!function_exists("pd")) {

    /**
     * Converts English digits to Persian digits and some Arabic notation letters to Persian notation letters
     *
     * @param $string
     *
     * @return mixed
     */
    function pd($string)
    {
        $farsi_chars = ['۰', '۱', '۲', '۳', '۴', '۵', '۶', '۷', '۸', '۹', '۴', '۵', '۶', 'ی', 'ک', 'ک',];
        $latin_chars = ['0', '1', '2', '3', '4', '5', '6', '7', '8', '9', '٤', '٥', '٦', 'ي', 'ك', 'ك',];
        return str_replace($latin_chars, $farsi_chars, $string);
    }
}

if (!function_exists("ed")) {

    /**
     * Converts Persian digits to English digits
     *
     * @param $string
     *
     * @return mixed
     */
    function ed($string)
    {
        $farsi_chars = ['۰', '۱', '۲', '۳', '۴', '۵', '۶', '۷', '۸', '۹', '٤', '٥', '٦'];
        $latin_chars = ['0', '1', '2', '3', '4', '5', '6', '7', '8', '9', '4', '5', '6'];
        return str_replace($farsi_chars, $latin_chars, $string);
    }
}

if (!function_exists("ad")) {


    /**
     * Smart converting of the digits depending on site locale
     *
     * @param $string
     *
     * @return mixed
     */
    function ad($string, $default_language = false)
    {
        if (isLangRtl($default_language)) {
            return pd($string);
        } else {
            return ed($string);
        }
    }
}

if (!function_exists("isLangRtl")) {


    /**
     * Determines if the determined language is of a right-to-left type.
     *
     * @param bool $language
     *
     * @return bool
     */
    function isLangRtl($language = false)
    {
        $rtl_languages = ['fa', 'ar'];
        if (!$language) {
            $language = getLocale();
        }
        if (in_array($language, $rtl_languages)) {
            return true;
        } else {
            return false;
        }
    }
}


if (!function_exists("isLangLtr")) {

    /**
     * determines if desired language is of a left-to-right type.
     *
     * @param bool $language
     *
     * @return bool
     */
    function isLangLtr($language = false)
    {
        return !isLangRtl($language);
    }
}

if (!function_exists("array_default")) {

    /*
    |--------------------------------------------------------------------------
    | Array Helpers
    |--------------------------------------------------------------------------
    |
    */


    /**
     * Compares a given key-value array, with a reference one to fill the non-existing keys, according to the given
     * reference.
     *
     * @param array $array
     * @param array $reference
     *
     * @return array
     */
    function array_default(array $array, array $reference)
    {
        foreach ($reference as $key => $value) {
            if (!array_has($array, $key)) {
                $array[$key] = $value;
            }
        }
        return $array;
    }

}

if (!function_exists("array_normalize")) {

    /**
     * Compares a given key-value array, with a reference one to fill the non-existing keys, and unset the extra ones,
     * according to the given reference.
     *
     * @param array $array
     * @param array $reference
     *
     * @return array
     */
    function array_normalize(array $array, array $reference)
    {
        $result = [];
        foreach ($reference as $key => $value) {
            if (!array_has($array, $key)) {
                $result[$key] = $value;
            } else {
                $result[$key] = $array[$key];
            }
        }
        return $result;
    }
}

if (!function_exists("array_remove")) {

    /**
     * removes a certain item from a given single-layer array.
     *
     * @param $array
     * @param $item
     *
     * @return array
     */
    function array_remove(array $array, $item)
    {
        array_splice($array, array_search($item, $array), 1);
        //unset($array[$key]);
        return $array;
    }

}

if (!function_exists("array_normalize_keep_originals")) {

    /**
     * Normalizes the given $array with the provided $reference, by filling unset ones.
     * This functions keeps extra entries.
     *
     * @deprecated
     *
     * @param $array
     * @param $reference
     *
     * @return array
     */
    function array_normalize_keep_originals($array, $reference)
    {
        return array_default($array, $reference);
    }
}

if (!function_exists("array_maker")) {

    /**
     * Generates a key-value array from a string, using the delimiters respectively.
     *
     * @param string $string
     * @param string $first_delimiter
     * @param string $second_delimiter
     *
     * @return array
     */
    function array_maker($string, $first_delimiter = '-', $second_delimiter = '=')
    {
        $array = explode($first_delimiter, str_replace(' ', null, $string));
        foreach ($array as $key => $switch) {
            $switch = explode($second_delimiter, $switch);
            unset($array[$key]);
            if (sizeof($switch) < 2) {
                continue;
            }
            $array[$switch[0]] = $switch[1];
        }
        return $array;
    }
}

if (!function_exists("array_has_required")) {


    /**
     * Checks if the given key-value array has the required key(s).
     *
     * @param string|array $required_keys
     * @param array        $array
     *
     * @return bool
     */
    function array_has_required($required_keys, $array)
    {
        $required_keys = (array)$required_keys;
        foreach ($required_keys as $required_field) {
            if (!isset($array[$required_field]) or !$array[$required_field]) {
                return false;
            }
        }
        return true;
    }
}

if (!function_exists("explode_not_empty")) {

    /**
     * Explodes and removes empty items from result
     *
     * @param string $delimiter
     * @param string $string
     *
     * @return array
     */
    function explode_not_empty($delimiter, $string)
    {
        return array_values(array_filter(explode($delimiter, $string)));
    }
}

if (!function_exists("not_in_array")) {

    /**
     * Checks if a value does not exist in an array
     *
     * @param       $needle
     * @param array $haystack
     * @param bool  $strict
     *
     * @return bool
     */
    function not_in_array($needle, array $haystack, $strict = false)
    {
        return !in_array($needle, $haystack, $strict);
    }
}

if (!function_exists("arrayHasRequired")) {


    /**
     * @deprecated
     *
     * @param $required
     * @param $array
     *
     * @return bool
     */
    function arrayHasRequired($required, $array)
    {
        return array_has_required($required, $array);
    }
}

if (!function_exists("model")) {


    /*
    |--------------------------------------------------------------------------
    | CMS Shortcuts
    |--------------------------------------------------------------------------
    |
    */
    /**
     * @param      $class_name
     * @param int  $id
     * @param bool $with_trashed
     *
     * @return \Modules\Yasna\Services\YasnaModel
     */
    function model($class_name, $id = 0, $with_trashed = false)
    {
        return yasna()->model($class_name, $id, $with_trashed);
    }
}
if (!function_exists("user")) {


    /**
     * @param int $id
     *
     * @return \App\Models\User
     */
    function user($id = 0)
    {
        return yasna()->user($id);
    }
}

if (!function_exists("login")) {

    /**
     * @param $id
     *
     * @return string: the full name of the logged-in user.
     */
    function login($id)
    {
        Auth::loginUsingId($id);
        return user()->full_name;
    }
}

if (!function_exists("findUser")) {

    /**
     * @TODO: Ensure safe-working in YasnaWeb3, and update Wiki if required.
     *
     * @param        $username
     * @param null   $as_role
     * @param string $username_field
     *
     * @return \App\Models\User
     */
    function findUser($username, $as_role = null, $username_field = 'auto')
    {
        return userFinder($username, $as_role, $username_field);
    }
}

if (!function_exists("userFinder")) {

    /**
     * @TODO: Ensure safe-working in YasnaWeb3, and update Wiki if required.
     *
     * @param        $username
     * @param null   $as_role
     * @param string $username_field
     *
     * @return \App\Models\User
     */
    function userFinder($username, $as_role = null, $username_field = 'auto')
    {
        return model('user')::finder($username, $as_role, $username_field);
    }
}

if (!function_exists("getSetting")) {

    /**
     * Easier way to call settings with super-minimal parameters (language=auto, cache=on, default=no etc.)
     *
     * @param $slug
     *
     * @return array|bool|mixed
     */
    function getSetting($slug)
    {
        return setting($slug)->gain();
    }
}

if (!function_exists("setting")) {

    /**
     * A shortcut to fire a chain command to receive setting value
     *
     * @param $slug
     *
     * @return \Modules\Yasna\Entities\Setting
     */
    function setting($slug = null)
    {
        if ($slug) {
            return \Modules\Yasna\Entities\Setting::builder($slug);
        } else {
            return new \Modules\Yasna\Entities\Setting();
        }
    }
}

if (!function_exists("v0")) {

    /**
     * @return string
     */
    function v0()
    {
        return "javascript:void(0)";
    }
}

if (!function_exists("ss")) {

    /**
     * Says $anything in an acceptable array format, for the debugging purposes.
     *
     * @param $anything
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    function ss($anything)
    {
        echo view('yasna::layouts.say', ['array' => $anything]);
        return null;
    }

}

if (!function_exists("module")) {

    /**
     * @param null $module_name
     *
     * @return \Modules\Yasna\Services\ModuleHelper
     */
    function module($module_name = null)
    {
        return new \Modules\Yasna\Services\ModuleHelper($module_name);
    }
}

if (!function_exists("service")) {


    /**
     * @param $module_service_combination (separated by `:`)
     *
     * @return \Modules\Yasna\Services\ModuleHelper
     */
    function service($module_service_combination)
    {
        return module(str_before($module_service_combination, ':'))->service(str_after($module_service_combination,
             ':'));
    }
}

if (!function_exists("customValidation")) {

    /**
     * Returns custom validation as a string
     *
     * @return mixed
     * @deprecated
     */
    function customValidation()
    {
        return Yasna::customValidation();
    }
}

if (!function_exists("carbon")) {


    /**
     * @return Carbon
     */
    function carbon()
    {
        return Carbon::class;
    }
}

if (!function_exists("yasna")) {


    /**
     * Shortcut to YasnaServiceProvider
     *
     * @return \Modules\Yasna\Providers\YasnaServiceProvider
     */
    function yasna()
    {
        return new \Modules\Yasna\Providers\YasnaServiceProvider(app());
    }
}

if (!function_exists("dummy")) {

    /**
     * Shortcut to Dummy ServiceProvider
     *
     * @return \Modules\Yasna\Providers\DummyServiceProvider
     */
    function dummy()
    {
        return \Modules\Yasna\Providers\DummyServiceProvider::class;
    }
}

if (!function_exists("makeDateTimeString")) {


    /*
    |--------------------------------------------------------------------------
    | Date and Time Helpers
    |--------------------------------------------------------------------------
    |
    */
    /**
     * Returns date and time string
     *
     * @param     $date
     * @param int $hour
     * @param int $minute
     * @param int $second
     *
     * @return string
     */
    function makeDateTimeString($date, $hour = 0, $minute = 0, $second = 0)
    {
        $date   = "$date $hour:$minute:$second";
        $carbon = new Carbon($date);
        return $carbon->toDateTimeString();
    }
}

if (!function_exists("echoDate")) {

    /**
     * @param        $date
     * @param string $format
     * @param string $language
     * @param bool   $pd
     *
     * @return string
     */
    function echoDate($date, $format = 'default', $language = 'auto', $pd = false)
    {
        /*-----------------------------------------------
        | Safety Bypass ...
        */
        if (in_array($date, [null, '0000-00-00 00:00:00', '0000-00-00'])) {
            return '-';
        }
        //if (!(DateTime::createFromFormat('Y-m-d G:i:s', $date) !== false)) {
        //    return '-';
        //}
        /*-----------------------------------------------
        | Process ...
        */
        if ($format == 'default') {
            $format = 'j F Y [H:m]';
        }
        if ($language == 'auto') {
            $language = getLocale();
        }
        if (!($date instanceof Carbon)) {
            $date = Carbon::parse($date);
        }

        switch ($language) {
            case 'fa':
                $date = jDate::forge($date)->format($format);
                break;
            case 'en':
                $date = $date->format($format);
                break;
            default:
                $date = $date->format($format);
        }
        if ($pd) {
            return pd($date);
        } else {
            return $date;
        }
    }

}

if (!function_exists("jalaliArray")) {

    /**
     * @param $carbon_string
     *
     * @return array
     */
    function jalaliArray($carbon_string)
    {
        $format = "Y-m-d-H-i-s";
        $string = echoDate($carbon_string, $format, 'fa');
        $array  = explode('-', $string);

        return [
             "year"   => intval($array[0]),
             "month"  => intval($array[1]),
             "day"    => intval($array[2]),
             "hour"   => intval($array[3]),
             "minute" => intval($array[4]),
             "second" => intval($array[5]),
        ];
    }
}

if (!function_exists("hashid_encrypt")) {

    /*
    |--------------------------------------------------------------------------
    | hash_id
    |--------------------------------------------------------------------------
    |
    */
    /**
     * Encrypts the $id according to the $connection
     *
     * @param        $id
     * @param string $connection
     *
     * @return mixed
     */
    function hashid_encrypt($id, $connection = 'main')
    {
        return Hashids::connection($connection)->encode($id);
    }
}

if (!function_exists("hashid_decrypt")) {

    /**
     * Decrypts the $hash according to the $connection
     *
     * @param        $hash
     * @param string $connection
     *
     * @deprecated since 96/8/1
     * @return mixed
     */
    function hashid_decrypt($hash, $connection = 'main')
    {
        return Hashids::connection($connection)->decode($hash);
    }
}


if (!function_exists("hashid_decrypt0")) {

    /**
     * Decrypts the $hash according to the $connection and returns the first result
     *
     * @param        $hash
     * @param string $connection
     *
     * @deprecated since 96/8/1
     * @return bool
     */
    function hashid_decrypt0($hash, $connection = 'main')
    {
        $result = hashid_decrypt($hash, $connection);
        if (isset($result[0])) {
            return $result[0];
        } else {
            return false;
        }
    }
}

if (!function_exists("hashid")) {

    /**
     * Smart decryption/encryption, according to the connection
     *
     * @param        $string
     * @param string $connection
     *
     * @return int|string|array
     */
    function hashid($string, $connection = 'ids')
    {
        if (is_array($string)) {
            $array = $string;
            foreach ($array as $key => $item) {
                $array[$key] = hashid($item, $connection);
            }
            return $array;
        } else {
            if (is_numeric($string)) {
                return hashid_encrypt($string, $connection);
            } else {
                return hashid_decrypt0($string, $connection);
            }
        }
    }
}

if (!function_exists("hashid_number")) {


    /**
     * Converts hashid string/integer to an equivalent integer
     *
     * @param  string|int $phrase
     * @param string      $connection
     *
     * @return int
     */
    function hashid_number($phrase, string $connection = 'ids'): int
    {
        if (is_numeric($phrase)) {
            return (int)$phrase;
        }

        return (int)hashid($phrase, $connection);
    }
}

if (!function_exists("hashid_string")) {

    /**
     * Converts hashid string/integer to an equivalent encrypted string
     *
     * @param  string|int $phrase
     * @param string      $connection
     *
     * @return string
     */
    function hashid_string($phrase, string $connection = 'ids'): string
    {
        if (!is_numeric($phrase)) {
            return (string)$phrase;
        }

        return (string)hashid($phrase, $connection);
    }
}

if (!function_exists("dev")) {

    /**
     * Checks if the user is developer
     *
     * @return mixed
     */
    function dev()
    {
        return user()->isDeveloper();
    }
}


if (!function_exists("debugMode")) {


    /**
     * Checks if app is in debug mode.
     *
     * @return boolean
     */
    function debugMode()
    {
        return config('app.debug');
    }
}

if (!function_exists("is_closure")) {


    /**
     * Returns true if the $variable is a closure, and returns false if not
     *
     * @param $variable
     *
     * @return bool
     */
    function is_closure($variable)
    {
        return isClosure($variable);
    }
}

if (!function_exists("isClosure")) {

    /**
     * @param $variable
     *
     * @return bool
     */
    function isClosure($variable)
    {
        return is_object($variable) && ($variable instanceof Closure);
    }
}


if (!function_exists("isJson")) {

    /**
     * Returns true if $string is Json and returns false if not.
     *
     * @param $string
     *
     * @return bool
     */
    function isJson($string)
    {
        json_decode($string);
        return (json_last_error() == JSON_ERROR_NONE);
    }
}

if (!function_exists("is_json")) {

    /**
     * @param $string
     *
     * @return bool
     */
    function is_json($string)
    {
        return isJson($string);
    }
}

if (!function_exists("usernameField")) {

    /**
     * @return string
     */
    function usernameField()
    {
        return config('auth.providers.users.field_name');
    }
}

if (!function_exists("safeDecrypt")) {

    /**
     * @param string $value
     * @param string $safe_return
     *
     * @return string
     */
    function safeDecrypt($value, $safe_return = null)
    {
        try {
            $decrypted = decrypt($value);
        } catch (DecryptException $e) {
            $decrypted = $safe_return;
        }

        return $decrypted;
    }
}

if (!function_exists("previousException")) {

    /**
     * Supposed to provide the previous exception, to be used in throw methods.
     *
     * @TODO: It just returns an instance of ErrorException, not the real previous exception for the time being.
     * @return ErrorException
     */
    function previousException()
    {
        $e = new ErrorException();
        return $e;
    }
}
