<?php

namespace Modules\Yasna\Entities\Traits;

/**
 * Class RoleDefaceTrait
 *
 * @property $pivot
 * @package Modules\Yasna\Entities\Traits
 */
trait RoleDefaceTrait
{
    private $permit_alpha = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMfNOPQRSTUVWXYZ1234567890-!@#%^&*()_+~[]|;,.{}:<>?';
    private $permit_coder = '~jFCQ?U0y&rvYp8<b9{Ew[V#N;7tx,M51]L(Bq@!^fa|2Z}XgD+lT4Ie>sJmP.huod:*Kkz3nHR-G_f)6iW%cAOS';



    /**
     * Defaces the permission string
     *
     * @param string $text
     *
     * @return string
     */
    public function defaceString($text)
    {
        return strtr($text, $this->permit_alpha, $this->permit_coder);
    }



    /**
     * Reverts the defaced permission string
     *
     * @param string $text
     *
     * @return string
     */
    public function adornString($text)
    {
        return strtr($text, $this->permit_coder, $this->permit_alpha);
    }



    /**
     * apply deface revert on $this->pivot, if it is defined
     *
     * @return $this
     */
    public function adorn()
    {
        if ($this->pivot) {
            $this->pivot->permissions = $this->adornString($this->pivot->permissions);
        }

        return $this;
    }



    /**
     * apply deface on $this->pivot, if it is defined
     *
     * @return $this
     */
    public function deface()
    {
        if ($this->pivot) {
            $this->pivot->permissions = $this->adornString($this->pivot->permissions);
        }

        return $this;
    }
}
