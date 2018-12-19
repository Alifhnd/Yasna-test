<?php
/**
 * Created by PhpStorm.
 * User: emitis
 * Date: 9/3/18
 * Time: 6:03 PM
 */

namespace Modules\Yasna\Services\ModuleTraits;


use Nwidart\Modules\Exceptions\InvalidAssetPath;
use Nwidart\Modules\Facades\Module;

trait StuffTrait
{
    /**
     * Returns the path of a blade in this module.
     *
     * @return string
     */
    public function getBladePath($sub_path)
    {
        return $this->getAlias() . '::' . $sub_path;
    }



    /**
     * Returns the path of an asset in this module.
     *
     * @param string $sub_path
     *
     * @return string
     */
    public function getAssetPath(string $sub_path): string
    {
        return $this->getAlias() . ':' . $sub_path;
    }



    /**
     * Returns the asset in this module.
     *
     * @param string $sub_path
     *
     * @return string
     * @throws InvalidAssetPath
     */
    public function getAsset(string $sub_path): string
    {
        return Module::asset($this->getAssetPath($sub_path));
    }



    /**
     * Returns the path of a trans in this module.
     *
     * @param string $sub_path
     *
     * @return string
     */
    public function getTransPath(string $sub_path): string
    {
        return $this->getAlias() . '::' . $sub_path;
    }



    /**
     * Returns the requested trans of this module.
     *
     * @param string $sub_path
     * @param array  $replace
     * @param string $locale
     *
     * @return string|array|null
     */
    public function getTrans(string $sub_path, $replace = [], $locale = null)
    {
        return trans($this->getTransPath($sub_path), $replace, $locale);
    }



    /**
     * Returns the path of a config in this module.
     *
     * @param string $sub_path
     *
     * @return string
     */
    public function getConfigPath($sub_path): string
    {
        return $this->getAlias() . '.' . $sub_path;
    }



    /**
     * Return the config in this module.
     *
     * @param string $sub_path
     * @param mixed  $default
     *
     * @return mixed
     */
    public function getConfig(string $sub_path, $default = null)
    {
        return config($this->getConfigPath($sub_path), $default);
    }



    /**
     * Sets configs of module.
     *
     * @param array $configs
     *
     * @return \Illuminate\Config\Repository|mixed
     */
    public function setConfig(array $configs)
    {
        $absolute = [];
        foreach ($configs as $key => $value) {
            $absolute_key            = $this->getConfigPath($key);
            $absolute[$absolute_key] = $value;
        }

        return config($absolute);
    }
}
