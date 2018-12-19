<?php

namespace Modules\Users\Http\Requests;

use App\Models\Role;
use Modules\Users\Providers\DepartmentsServiceProvider;
use Modules\Yasna\Services\YasnaRequest;

class DepartmentSaveRequest extends RoleSaveRequest
{
    /**
     * correct the slug field.
     */
    protected function correctSlug()
    {
        $slug = ($this->data['slug'] ?? null);

        if (!$slug) {
            return;
        }

        $tmp_model = new Role(['slug' => $slug]);

        if ($tmp_model->isSupportRole()) {
            return;
        } else {
            $this->data['slug'] = DepartmentsServiceProvider::roleSlug($slug);
        }
    }



    /**
     * remove `fa-` prefix from the beginning of the icon string
     */
    protected function normalizeIcon()
    {
        $this->data['icon'] = str_after($this->data['icon'], "fa-");
    }



    /**
     * @inheritdoc
     */
    public function corrections()
    {
        $this->correctSlug();
        $this->normalizeIcon();
    }



    /**
     * @inheritdoc
     */
    public function authorize()
    {
        $model = $this->model;

        return ($model->not_exists or $model->isSupportRole());
    }
}
