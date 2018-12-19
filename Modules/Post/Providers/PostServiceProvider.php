<?php

namespace Modules\Post\Providers;

use Modules\Yasna\Services\YasnaProvider;

/**
 * Class PostServiceProvider
 *
 * @package Modules\Post\Providers
 */
class PostServiceProvider extends YasnaProvider
{
    /**
     * This will be automatically loaded in the app boot sequence if the module is active.
     *
     * @return void
     */
    public function index()
    {
        module('manage')
             ->service('sidebar')
             ->add('posts')
             ->blade('post::layouts.sidebar')
             ->order(40)
        ;
        $this->relations();
    }



    public function relations()
    {
        $this->addModelTrait("UserPostsTrait","User");
    }
}
