<?php
namespace App\Scopes;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;

class IsadminScope implements Scope
{
/**
* Apply the scope to a given Eloquent query builder.
*
* @param  \Illuminate\Database\Eloquent\Builder  $builder
* @param  \Illuminate\Database\Eloquent\Model  $model
* @return void
*/
protected $key;
protected $value;

public function __construct($key, $value)
{
    $this->key = $key;
    $this->value = $value;
}
public function apply(Builder $builder, Model $model)
{
    $builder->when(!is_admin(), function ($query) {
        $query->where($this->key, '=', $this->value);
    });
}
}
