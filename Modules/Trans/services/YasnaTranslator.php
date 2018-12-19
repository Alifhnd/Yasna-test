<?php
/**
 * Created by PhpStorm.
 * User: parsa
 * Date: 7/8/18
 * Time: 5:06 PM
 */

namespace Modules\Trans\services;

use Illuminate\Translation\Translator as LaravelTranslator;

class YasnaTranslator extends LaravelTranslator
{
    /**
     * override laravel trans()
     *
     * @param string $key
     * @param array  $replace
     * @param null   $locale
     * @param bool   $fallback
     *
     * @return array|mixed|null|string
     */
    public function get($key, array $replace = [], $locale = null, $fallback = true)
    {
        if (str_contains($key, 'dynamic.')) {
            return dynamicTrans($key);
        }
        $result = parent::get($key, $replace, $locale, $fallback);
        if ($result !== $key) {
            return $result;
        } else {
            return dynamicTrans($key);
        }
    }

}
