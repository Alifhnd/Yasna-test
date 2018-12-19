<?php

namespace Modules\Users\Http\Controllers;

use Illuminate\Routing\Controller;
use Modules\Users\Http\Requests\RoleTitlesSaveRequest;
use App\Models\Role;
use Illuminate\Http\Request;
use Modules\Manage\Traits\ManageControllerTrait;
use Modules\Users\Database\Seeders\SettingsTableSeeder;
use Modules\Users\Http\Requests\RoleAdminsSaveRequest;
use Modules\Users\Http\Requests\RoleSaveRequest;

class UpstreamController extends Controller
{
    use ManageControllerTrait;



    /**
     * Saves dynamic trans
     *
     * @deprecated
     * @return mixed
     */
    public function loadPermitTransSettings()
    {
        $setting = model('setting')->grabSlug('permits');
        if (!$setting or !$setting->exists) {
            $seeder = new SettingsTableSeeder();
            $seeder->run();
            $setting = model('setting')->grabSlug('permits');
        }


        return $setting;
    }
}
