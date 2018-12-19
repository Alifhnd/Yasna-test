<?php
namespace Modules\Yasna\Services;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\ValidationException;
use Modules\Yasna\Providers\ValidationServiceProvider;
use Illuminate\Contracts\Validation\Validator;
use Modules\Yasna\Services\ModuleTraits\ModuleRecognitionsTrait;
use Symfony\Component\HttpFoundation\JsonResponse;

abstract class YasnaRequest extends FormRequest
{
    use ModuleRecognitionsTrait;

    /**
     * Keeps the automatic-retrieved model row.
     * This is automatically filled and you don't need to override its definition.
     * Made public to be available in the Controller level as well.
     *
     * @link https://github.com/mhrezaei/yasna-core/wiki/D.-YasnaRequest#automatic-model-recognition
     * @var bool|YasnaModel|mixed
     */
    public $model = false;

    /**
     * Keeps the automatic-retrieved model id.
     * This is automatically filled and you don't need to override.
     * Made public to be available in the Controller level as well.
     *
     * @link https://github.com/mhrezaei/yasna-core/wiki/D.-YasnaRequest#automatic-model-recognition
     * @var bool|YasnaModel|mixed
     */
    public $model_id;

    /**
     * Keeps the automatic-retrieved model hashid.
     * This is automatically filled and you don't need to override.
     * Made public to be available in the Controller level as well.
     *
     * @link https://github.com/mhrezaei/yasna-core/wiki/D.-YasnaRequest#automatic-model-recognition
     * @var bool|YasnaModel|mixed
     */
    public $model_hashid;

    /**
     * The model name. override this to let YasnaRequest select the row, corresponding to the `id` or `hashid` received
     * among the request data
     *
     * @link https://github.com/mhrezaei/yasna-core/wiki/D.-YasnaRequest#automatic-model-recognition
     * @var string
     */
    protected $model_name = null;

    /**
     * Indicates if the automatic model selection should include the trashed data.
     *
     * @link https://github.com/mhrezaei/yasna-core/wiki/D.-YasnaRequest#automatic-model-recognition
     * @var bool
     */
    protected $model_with_trashed = true;

    /**
     * Indicates which responder should be used to convey error messages in case of validation or authentication
     * failure.
     * `default` will let Laravel handle the job, and any other thing will use the corresponding standard.
     * "white-house" is the only custom standard, available for the time being.
     *
     * @link https://github.com/mhrezaei/yasna-core/wiki/C.-API-Responder
     * @var string
     */
    protected $responder = 'default';

    /**
     * Indicates which error code should be conveyed, when the authorization fails.
     * This is api-dependant and works only on white-house responder.
     *
     * @link https://github.com/mhrezaei/yasna-core/wiki/C.-API-Responder
     * @var int
     */
    protected $error_code_when_authorization_fails = 1001;


    /**
     * Indicates which error code should be conveyed, when the validation fails.
     * This is api-dependant and works only on white-house responder.
     *
     * @link https://github.com/mhrezaei/yasna-core/wiki/C.-API-Responder
     * @var int
     */
    protected $error_code_when_validation_fails = 1002;

    /**
     * Responsible to keep the data during the validation process.
     * Do not override the definition, but feel free to finger its content, if you need some corrections on data.
     *
     * @link https://github.com/mhrezaei/yasna-core/wiki/D.-YasnaRequest#data-manipulation
     * @var array
     */
    protected $data;

    /**
     * Responsible to keep the purification rules.
     * Do not override this.
     *
     * @link https://github.com/mhrezaei/yasna-core/wiki/D.-YasnaRequest#data-purification
     * @var array
     */
    protected $purifiers;

    /**
     * Purification rules to be applied automatically on all received data
     * Override this, if you feel necessary.
     *
     * @link https://github.com/mhrezaei/yasna-core/wiki/D.-YasnaRequest#automatic-purification
     * @var string
     */
    protected $automatic_purification_rules = 'trim | stripArabic';



    /**
     * Tries to find the model in question, using $this->model_name and the submitted id/hashid.
     *
     * @deprecated : use $this->loadModel() instead
     * @return bool|YasnaModel|mixed
     */
    protected function model()
    {
        /*-----------------------------------------------
        | Bypass ...
        */
        if (!$this->model_name) {
            return false;
        }

        /*-----------------------------------------------
        | Find ...
        */
        if (!isset($this->data['id'])) {
            $this->data['id'] = 0;
        }

        $this->data['model'] = $this->model = model($this->model_name, $this->data['id'], $this->model_with_trashed);
        $this->refillRequestHashid();
        $this->failIfModelNotExist();

        return true;
    }



    /**
     * Tries to find the model in question, using $this->model_name and the submitted id/hashid.
     *
     * @param string|int $id_or_hashid
     *
     * @return void
     */
    protected function loadRequestedModel($id_or_hashid = false)
    {
        if (!$this->model_name) {
            return;
        }

        $this->data['id']    = $this->getRequestedModelId($id_or_hashid);
        $this->data['model'] = $this->model = model($this->model_name, $this->data['id'], $this->model_with_trashed);
        $this->refillRequestHashid();
        $this->failIfModelNotExist();
    }



    /**
     * Tries to get the requested id, via:
     * 1. direct developer ask;
     * 2. Submitted data (hashid in the request package);
     * 3. Passed `hashid` in the standard RESTFUL api url
     *
     * @param $id_or_hashid
     *
     * @return int
     */
    protected function getRequestedModelId($id_or_hashid): int
    {
        if ($id_or_hashid !== false) {
            return hashid_number($id_or_hashid);
        }

        if (isset($this->data['hashid'])) {
            return hashid_number($this->data['hashid']);
        }

        if (isset($this->data['id'])) {
            return hashid_number($this->data['id']);
        }

        if ($this->route()->parameter('hashid')) {
            return (int)hashid($this->route()->parameter('hashid'));
        }

        return 0;
    }



    /**
     * Make sure $this->hashid contains a valid hashid, based on the retrieved model
     *
     * @return void
     */
    protected function refillRequestHashid()
    {
        if ($this->model->exists) {
            $this->data['hashid'] = $this->model->hashid;
        } else {
            $this->data['hashid'] = hashid(0);
        }

        $this->model_hashid = $this->data['hashid'];
        $this->model_id     = $this->model->id;
    }



    /**
     * Fails if the requested model cannot be found
     *
     * @return void
     */
    protected function failIfModelNotExist()
    {
        $given_id     = hashid_number($this->data['id']);
        $given_hashid = $this->data['hashid'];

        if ($given_hashid == hashid(0)) {
            $given_hashid = false;
        }

        $requested_something = (boolval($given_id) or boolval($given_hashid));

        if ($requested_something and !$this->model->id) {
            $this->failedAuthorization();
        }
    }



    /**
     * @inheritdoc
     */
    protected function passesAuthorization()
    {
        $this->initRequestSequence();

        return parent::passesAuthorization();
    }



    /**
     * init the request sequence by loading necessary data and models, before first steps of validation.
     *
     * @return void
     */
    private function initRequestSequence()
    {
        $this->data = parent::all();
        $this->injectionGuard();
        $this->handleHashids();
        $this->loadRequestedModel();
        $this->purifierRun();
        $this->corrections();
    }



    /**
     * run the guard against injecting unplanned data in the form submit.
     *
     * @return void
     */
    private function injectionGuard()
    {
        $this->preventGuardedFieldSubmits();
        $this->preventUnfillableFieldSubmits();
    }



    /**
     * prevent guarded fields from being submitted among the request.
     *
     * @return void
     */
    private function preventGuardedFieldSubmits()
    {
        $supplied_fields = array_keys($this->data);
        $guarded_fields  = $this->guardedFields();

        if (!count($guarded_fields)) {
            return;
        }

        foreach ($supplied_fields as $field) {
            if (in_array($field, $guarded_fields)) {
                $this->failedAuthorization();
            }
        }
    }



    /**
     * prevent fields not mentioned in $this->fillableFields from being submitted among the request.
     *
     * @return void
     */
    private function preventUnfillableFieldSubmits()
    {
        $supplied_fields = array_keys($this->data);
        $fillable_fields = $this->fillableFields();

        if ($fillable_fields == ['ALL']) {
            return;
        }

        foreach ($supplied_fields as $field) {
            if ($field[0] == '_' or $field == 'id' or $field == 'hashid') {
                continue;
            }

            if (!in_array($field, $fillable_fields)) {
                $this->failedAuthorization();
            }
        }
    }



    /**
     * run the purifier system.
     *
     * @return void
     */
    private function purifierRun()
    {
        $this->data = ValidationServiceProvider::purifier(
             $this->data,
             $this->purifier(),
             $this->automatic_purification_rules
        );
    }



    /**
     * @inheritdoc
     */
    public function all($keys = null)
    {
        return $this->data;
    }



    /**
     * Checks all `*_id` fields and converts hashid if the content is string.
     * In strict mode, for additional safety, unsets if the field is already an id.
     * This method is to be called on demand in correction() method.
     *
     * @param  bool $strict
     *
     * @return void
     */
    protected function hashidsConverter($strict = true): void
    {
        foreach ($this->data as $key => $value) {
            if (str_contains($key, 'id') and !str_contains($key, 'hashid')) {
                if (is_string($value)) {
                    $this->data[$key] = hashid($value);
                } elseif ($strict) {
                    unset($this->data[$key]);
                }
            }
        }
    }



    /**
     * an array of the data purification rules
     *
     * @link https://github.com/mhrezaei/yasna-core/wiki/D.-YasnaRequest
     * @return array
     */
    public function purifier()
    {
        return [];
    }



    /**
     * a good place to apply any changes to the data, before they are submitted to the validation process.
     *
     * @link https://github.com/mhrezaei/yasna-core/wiki/D.-YasnaRequest
     * @return void
     */
    public function corrections()
    {
        return;
    }



    /**
     * Goes through all hashids of the request array to create the equivalent `id` key for each one.
     *
     * @deprecated
     * @return void
     */
    protected function handleHashids()
    {
        foreach ($this->data as $key => $value) {
            if (str_contains($key, 'hashid')) {
                if ($key == 'hashid') {
                    $this->data['id'] = hashid($value);
                } else {
                    $new_key              = str_before($key, '_hashid');
                    $this->data[$new_key] = hashid($value);
                    unset($this->data[$key]);
                }
            }
        }
    }



    /**
     * Provides a convenient way to call any "folanRules" method and merge their results, to form a central rules array
     *
     * @return array
     */
    public function rules()
    {
        $methods     = get_class_methods($this);
        $rules_array = [];

        foreach ($methods as $method) {
            if ((str_contains($method, "rules") or str_contains($method, "Rules")) and $method != 'rules') {
                $rules_array = $this->ruleMerger($rules_array, $this->$method());
            }
        }

        return $rules_array;
    }



    /**
     * Safely merges incoming array into the existing one and returns the enriched existing array.
     *
     * @param array $existing
     * @param array $incoming
     *
     * @return array
     */
    private function ruleMerger(array $existing, $incoming): array
    {
        if (!is_array($incoming)) {
            return $existing;
        }

        foreach ($incoming as $key => $item) {
            if (array_has($existing, $key)) {
                $existing[$key] .= "|$item";
            } else {
                $existing[$key] = $item;
            }
        }

        return $existing;
    }



    /**
     * Returns an array of errors, just like how Laravel does in the background.
     *
     * @param Validator $validator
     *
     * @return array
     */
    public function getErrors(Validator $validator)
    {
        $array  = [];
        $errors = $validator->errors();

        foreach ($errors->keys() as $key) {
            $array[$key] = [$errors->get($key)];
        }

        return $array;
    }



    /**
     * Handle a failed authorization attempt.
     *
     * @return void
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    protected function failedAuthorization()
    {
        if ($this->responder == 'default') {
            parent::failedAuthorization();
        }

        $this->customFailedAuthorization();
    }



    /**
     * Implements WhiteHouse standard system, regardless of what has provided in $this->responder
     *
     * @return void
     * @throws \Illuminate\Validation\ValidationException
     */
    private function customFailedAuthorization()
    {
        $content  = $this->jsonContentForFailedAuthorization();
        $response = new JsonResponse($content, 400);

        throw (new ValidationException($this->getValidatorInstance(), $response));
    }



    /**
     * Prepares array content for failed authorization
     *
     * @return array
     */
    private function jsonContentForFailedAuthorization()
    {
        $error_code = $this->error_code_when_authorization_fails;

        return api()->inModule($this->runningModuleName())->errorArray($error_code);
    }



    /**
     * Handle a failed validation attempt.
     *
     * @param  \Illuminate\Contracts\Validation\Validator $validator
     *
     * @return void
     * @throws \Illuminate\Validation\ValidationException
     */
    protected function failedValidation(Validator $validator)
    {
        if ($this->responder == 'default') {
            parent::failedValidation($validator);
        }

        $this->customFailedValidation($validator);
    }



    /**
     * Implements WhiteHouse standard system, regardless of what has provided in $this->responder
     *
     * @param Validator $validator
     *
     * @return void
     * @throws \Illuminate\Validation\ValidationException
     */
    private function customFailedValidation(Validator $validator)
    {
        $content  = $this->jsonContentForFailedValidation($validator);
        $response = new JsonResponse($content, 400);

        throw (new ValidationException($validator, $response));
    }



    /**
     * Prepares array content for failed validation
     *
     * @param Validator $validator
     *
     * @return array
     */
    private function jsonContentForFailedValidation(Validator $validator)
    {
        $error_code = $this->error_code_when_validation_fails;

        return api()
             ->inModule($this->runningModuleName())
             ->withErrors($this->getErrors($validator))
             ->errorArray($error_code)
             ;
    }



    /**
     * Authorization rule
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }



    /**
     * @inheritdoc
     */
    public function messages()
    {
        return [];
    }



    /**
     * get an array of guarded fields, which are not supposed to appear in the request submit.
     *
     * @return array
     */
    public function guardedFields()
    {
        return [];
    }



    /**
     * get an array of fillable fields, which are the only ones allowed to appear in the request submit.
     * allow the ones started with an underscore (ex. _label, _token)
     *
     * @return array
     */
    public function fillableFields()
    {
        return ['ALL'];
    }



    /**
     * Safely converts the submitted data into a key-value array
     *
     * @return array
     */
    public function toArray()
    {
        $array = $this->data;
        unset($array['model']);
        return $array;
    }



    /**
     * gets the array of all not-going-to-be-escaped fields
     *
     * @return array
     */
    public function getMainFieldsArray(): array
    {
        $array  = $this->toArray();
        $result = [];

        foreach ($array as $key => $value) {
            if (substr($key, 0, 1) != '_') {
                $result[$key] = $value;
            }
        }

        return $result;
    }
}
