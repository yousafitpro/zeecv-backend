<?php
namespace App\Scopes;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;

class hasPermissionScope implements Scope
{
/**
* Apply the scope to a given Eloquent query builder.
*
* @param  \Illuminate\Database\Eloquent\Builder  $builder
* @param  \Illuminate\Database\Eloquent\Model  $model
* @return void
*/
protected $key;
protected $permission;
protected $value;

public function __construct($permission,$key, $value)
{
    $this->permission = $permission;
    $this->key = $key;
    $this->value = $value;
}
public function apply(Builder $builder, Model $model)
{
    $builder->when(!is_has_permission($this->permission), function ($query) {
        $query->where($this->key, '=', $this->value);
    });
}
}
