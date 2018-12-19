<?php

namespace Modules\Yasna\Entities\Traits;

trait AuthorizationTrait
{
    use AuthorizationTraitKey;
    use AuthorizationTraitChain;
    use AuthorizationTraitRolesQuery;
    use AuthorizationTraitRolesCheck;
    use AuthorizationTraitRolesAttachment;
    use AuthorizationTraitCan;
    use AuthorizationTraitStatus;
    use AuthorizationTraitPermissions;
    use AuthorizationTraitDomains;
    use AuthorizationTraitTouch;
    use AuthorizationTraitFirstRole;
    use AuthorizationTraitUsers;
}
