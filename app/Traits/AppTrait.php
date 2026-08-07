<?php

namespace App\Traits;

use App\Scopes\hasAccessRawScope;
use App\Scopes\hasPermissionScope;
use App\Scopes\IsadminScope;

trait AppTrait
{
    public function scopeIsAdmin($query,$key = 'user_id', $value = null)
    {
        $value = $value ?? auth()->id();
        return $query->withGlobalScope('isadmin', new IsadminScope($key, $value));
    }
      public function scopeHasPermission($query,$permission, $key = 'user_id', $value = null)
    {
        $value = $value ?? auth_user_id();
        return $query->withGlobalScope('isadmin', new hasPermissionScope($permission,$key, $value));
    }
      public function scopeHasAccessRaw($query,$operator, array $checks,$permission='nnmadnmasd34')
    {
        $value = $value ?? auth_user_id();
        return $query->withGlobalScope('isadmin', new hasAccessRawScope($operator, $checks,$permission));
    }
}
