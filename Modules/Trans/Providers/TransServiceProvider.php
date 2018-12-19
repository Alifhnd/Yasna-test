<?php

namespace Modules\Trans\Providers;

use Illuminate\Support\Facades\Validator;
use Modules\Yasna\Services\YasnaProvider;

/**
 * Class TransServiceProvider
 *
 * @package Modules\Trans\Providers
 */
class TransServiceProvider extends YasnaProvider
{
    /**
     * provider methods
     */
    public function index()
    {
        $this->addProvider(TranslationServiceProvider::class);
        $this->registerDownstream();
        $this->registerExcelValidator();
    }



    /**
     * add tab in setting for dynamic trans
     */
    protected function registerDownstream()
    {
        module('manage')
             ->service('downstream')
             ->add('dynamic-trans')
             ->link('trans')
             ->trans('trans::downstream.title')
             ->method('trans:TransController@downstreamTab')
             ->order(42)
        ;
    }



    /**
     * Register excel validator
     */
    protected function registerExcelValidator()
    {
        Validator::extend('excel', function ($attribute, $value, $parameters, $validator) {
            $file      = request()->file($attribute);
            $mimes     = [
                 'application/vnd.ms-excel',
                 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            ];
            $file_mime = $file->getMimeType();
            return (in_array($file_mime, $mimes)) ? true : false;
        });
    }


}
