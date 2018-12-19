<?php
namespace Modules\Yasna\Services\Responders;

interface ApiResponseInterface
{
    /**
     * get a suitable array to dispatch a 400 response
     *
     * @param     $error_code
     *
     * @return array
     */
    public function errorArray($error_code);



    /**
     * dispatch a 400 response
     *
     * @param $error_code
     *
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
     */
    public function clientErrorRespond($error_code);



    /**
     * dispatch a 500 response
     *
     * @param     $error_code
     *
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
     */
    public function serverErrorRespond($error_code);



    /**
     * get a suitable array to dispatch a 200 response
     *
     * @param $data
     * @param $metadata
     *
     * @return array
     */
    public function successArray($results, $metadata);



    /**
     * dispatch a 200 response
     *
     * @param $results
     * @param $metadata
     *
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
     */
    public function successRespond($results = [], $metadata = []);



    /**
     * set the desired standard
     *
     * @param $standard
     *
     * @return void
     */
    public static function setStandard($standard);



    /**
     * set the desired module name (useful in odd cases where cannot be automatically detected)
     *
     * @param $path
     */
    public static function setModuleName($module_name);



    /**
     * get the module name
     *
     * @return string
     */
    public static function getModuleName();



    /**
     * get the module alias
     *
     * @return string
     */
    public function getModuleAlias();



    /**
     * check if the code is in a particular module
     *
     * @param $module_name
     *
     * @return $this
     */
    public function inModule($module_name);
}
