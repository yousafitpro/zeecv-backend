<?php
namespace App\Scopes;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;

class hasAccessRawScope implements Scope
{
/**
* Apply the scope to a given Eloquent query builder.
*
* @param  \Illuminate\Database\Eloquent\Builder  $builder
* @param  \Illuminate\Database\Eloquent\Model  $model
* @return void
*/
protected $checks;
protected $permission;
protected $operator;

public function __construct($operator, array $checks,$permission)
{
    $this->permission = $permission;
    $this->operator = $operator;
    $this->checks = $checks;
}
public function apply(Builder $builder, Model $model)
{
    $builder->when(!is_has_permission($this->permission), function ($query) {
          if ($this->operator === 'or') {
            $query->where(function ($q) {
                foreach ($this->checks as $key => $value) {
                    $q->orWhere($key, '=', $value);
                }
            });
        } else {
            foreach ($this->checks as $key => $value) {
                $query->where($key, '=', $value);
            }
        }
    });
}
}
