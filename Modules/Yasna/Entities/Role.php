<?php

namespace Modules\Yasna\Entities;

use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Yasna\Entities\Traits\RoleAdminsTrait;
use Modules\Yasna\Entities\Traits\RoleCompatibilityTrait;
use Modules\Yasna\Entities\Traits\RoleDefaceTrait;
use Modules\Yasna\Entities\Traits\RoleDomainsTrait;
use Modules\Yasna\Entities\Traits\RoleHelperTrait;
use Modules\Yasna\Entities\Traits\RoleModulesTrait;
use Modules\Yasna\Entities\Traits\RoleStatusTrait;
use Modules\Yasna\Entities\Traits\RoleSupportTrait;
use Modules\Yasna\Entities\Traits\RoleTitlesTrait;
use Modules\Yasna\Services\YasnaModel;

class Role extends YasnaModel
{
    use SoftDeletes;
    use RoleDomainsTrait;
    use RoleDefaceTrait;
    use RoleTitlesTrait;
    use RoleCompatibilityTrait;
    use RoleSupportTrait;
    use RoleHelperTrait;
    use RoleModulesTrait;
    use RoleAdminsTrait;
    use RoleStatusTrait;

    public static $reserved_slugs        = 'root,super,user,all,dev,developer,admin';
    public static $available_field_types = ['text', 'textarea', 'date', 'boolean', 'photo', 'file'];

    protected $casts = [
         'is_manager' => "boolean",
         'meta'       => "array",
    ];



    /**
     * get main Meta Fields.
     * (Method name is so chosen to keep the compatibility with the previous versions).
     *
     * @return array
     */
    public function getSignatureMetaFields(): array
    {
        return ['icon', 'fields', 'status_rule', 'locale_titles', 'min_active_status', 'is_privileged'];
    }



    /**
     * get a builder of all the relative users.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function users()
    {
        return $this->belongsToMany(MODELS_NAMESPACE . 'User')->withTimestamps();
    }



    /**
     * regenerate the cached roles data
     *
     * @return void
     */
    public function cacheRegenerate(): void
    {
        cache()->forget("admin_roles");
        cache()->forget("admin_roles-");
        cache()->forget("support_roles");
    }
}
