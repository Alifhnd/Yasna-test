<?php

namespace Modules\Users\Http\Controllers;

use App\Models\Role;
use Illuminate\Database\Eloquent\Builder;
use Modules\Yasna\Services\YasnaController;

class DepartmentsBrowseController extends YasnaController
{
    protected $base_model  = "role";
    protected $view_folder = "users::downstream.departments";



    /**
     * return the prefix for supportive roles.
     *
     * @return string
     */
    public static function supportRolesPrefix()
    {
        return Role::$support_role_prefix;
    }



    /**
     * return a query builder to select supportive roles.
     *
     * @return Builder
     */
    public static function modelQueryBuilder()
    {
        return (new static)
             ->model()
             ->withTrashed()
             ->where('slug', 'like', static::supportRolesPrefix() . '-_%')
             ->orderByDesc('created_at')
             ;

    }



    /**
     * find models to be shown in the grid.
     *
     * @return \Illuminate\Contracts\Pagination\Paginator
     */
    protected static function findModels()
    {
        return static::modelQueryBuilder()->simplePaginate(20);
    }



    /**
     * render the view for the supportive roles in the downstream.
     *
     * @return array
     */
    public static function downstream()
    {
        // View File
        $variables['view_file'] = (new static)->view_folder . '.index';

        // Models
        $variables['models'] = static::findModels();

        return $variables;
    }



    /**
     * do the action to reload the grid.
     *
     * @return \Illuminate\Support\Facades\View|\Symfony\Component\HttpFoundation\Response
     */
    public function grid()
    {
        $models = static::findModels();

        return $this->view('grid', compact('models'));
    }
}
