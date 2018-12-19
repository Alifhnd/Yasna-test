<?php

namespace Modules\Users\Http\Requests;

use Modules\Yasna\Services\YasnaRequest;

class RoleSaveRequest extends YasnaRequest
{
    protected $model_name = "Role";



    /**
     * @inheritdoc
     */
    public function rules()
    {
        $id       = $this->data['id'];
        $reserved = role()->reserved_slugs;

        return [
             'slug'         => "required|alpha_dash|not_in:$reserved|unique:roles,slug,$id,id",
             'title'        => "required|unique:roles,title,$id,id",
             'plural_title' => 'required',
        ];
    }



    /**
     * @inheritdoc
     */
    public function purifier()
    {
        return [
             'slug'     => "lower",
             "is_admin" => "boolean",
        ];
    }



    /**
     * @inheritdoc
     */
    public function corrections()
    {
        $this->normalizeIcon();
        $this->normalizeModules();
        $this->ensureAdminStateOfManager();
    }



    /**
     * Removes `fa-` prefix from the beginning of the icon string
     */
    private function normalizeIcon()
    {
        $this->data['icon'] = str_after($this->data['icon'], "fa-");
    }



    /**
     * Normalizes modules and status rules
     */
    private function normalizeModules(): void
    {
        $this->data['modules']     = $this->model->convertModulesInputToJson($this->data['modules']);
        $this->data['status_rule'] = $this->model->convertStatusRulesToArray($this->data['status_rule']);
    }



    /**
     * Makes sure the `manager` role is and remains admin.
     */
    private function ensureAdminStateOfManager()
    {
        if ($this->data['slug'] == 'manager') {
            $this->data['is_admin'] = true;
        }
    }
}
