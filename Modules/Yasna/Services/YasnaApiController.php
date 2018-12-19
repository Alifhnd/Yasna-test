<?php namespace Modules\Yasna\Services;

use Illuminate\Routing\Controller;
use Modules\Yasna\Services\GeneralTraits\ClassRecognitionsTrait;
use Modules\Yasna\Services\ModuleTraits\ModuleRecognitionsTrait;

abstract class YasnaApiController extends Controller
{
    use ModuleRecognitionsTrait;
    use ClassRecognitionsTrait;

    /**
     * keep the model name of this controller
     *
     * @var string
     */
    protected $model_name;



    /**
     * dispatch a 200 http status with the given white-house-compatible set of data
     *
     * @param array $results
     * @param array $metadata
     *
     * @return array
     */
    protected function success($results = [], $metadata = [])
    {
        return api()->inModule($this->runningModuleName())->successArray($results, $metadata);
    }



    /**
     * dispatch a 500 status with the given white-house-compatible set of error messages
     *
     * @param int $error_code
     *
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
     */
    protected function serverError($error_code)
    {
        return api()->inModule($this->runningModuleName())->serverErrorRespond($error_code);
    }



    /**
     * dispatch a 400 status with the given white-house-compatible set of error messages
     *
     * @param $error_code
     *
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
     */
    protected function clientError($error_code)
    {
        return api()->inModule($this->runningModuleName())->clientErrorRespond($error_code);
    }



    /**
     * find the model by id/hashid/slug and return the instance
     *
     * @param string|int $identifier
     * @param bool       $with_trashed
     *
     * @return YasnaModel|mixed
     */
    protected function findModel($identifier, bool $with_trashed = false)
    {
        if (!$this->model_name) {
            return model($this->model_name);
        }

        $model = model($this->model_name, $identifier, $with_trashed);

        return $model->spreadMeta();
    }



    /**
     * find the model by id/hashid/slug and return the instance
     *
     * @param string|int $identifier
     * @param bool       $with_trashed
     *
     * @return YasnaModel|mixed
     */
    protected function findOrFailModel($identifier, bool $with_trashed = false)
    {
        $model = $this->findModel($identifier, $with_trashed);

        if($model->isNotSet()) {
            dd("ERROR");
            // TODO: A standard whitehouse-compatible error instance is to be thrown.
        }

        return $model;
    }
}
