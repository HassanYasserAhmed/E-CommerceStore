<?php

namespace App\Policies;

use Illuminate\Support\Str;

class ModelPolicy
{
    /**
     * Create a new policy instance.
     */
    public function __construct()
    {
        //
    }

    public function __call($name, $arguments)
    {
        $class_name = str_replace('Policy', '', class_basename($this));
        $class_name = Str::plural(Str::lower($class_name));
        if ($name == 'viewAny') {
            $name = 'view';
        }
        $ability = $class_name.'.'.Str::kebab($name);
        $user = $arguments[0];
        $model = $arguments[1] ?? null;

        // if($model->store_id != $user->store_id) {
        //   return false;
        // }
        return $user->hasAbility($ability);
    }
}
