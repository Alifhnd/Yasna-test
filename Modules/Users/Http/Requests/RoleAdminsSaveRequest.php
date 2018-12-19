<?php

namespace Modules\Users\Http\Requests;

use Modules\Yasna\Services\YasnaRequest;

class RoleAdminsSaveRequest extends YasnaRequest
{
    protected $model_name = "Role";



    /**
     * @inheritdoc
     */
    public function corrections()
    {
        $this->data['modules']     = $this->model->convertModulesInputToJson($this->data['modules']);
        $this->data['status_rule'] = $this->model->convertStatusRulesToArray($this->data['status_rule']);
    }
}
