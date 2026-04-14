<?php

namespace App\Policies;

use App\Models\User;
use App\Models\product;
use Illuminate\Auth\Access\Response;

class ProductPolicy extends ModelPolicy
{
      public function before($user,$ability) {
        if($user->super_admin) {
            return true;
        }
    }

//   public function view($user, product $product): bool
//     {
//         return $user->hasAbility('product.view')
//                 && $product->store_id == $user->store_id;
//     }

    // /**
    //  * Determine whether the user can view any models.
    //  */

    // public function before($user,$ability) {
    //     if($user->super_admin) {
    //         return true;
    //     }
    // }
    // public function viewAny($user): bool
    // {
    //     return $user->hasAbility('product.view');
    // }

    // /**
    //  * Determine whether the user can view the model.
    //  */
    // public function view($user, product $product): bool
    // {
    //     return $user->hasAbility('product.view')
    //             && $product->store_id == $user->store_id;
    // }

    // /**
    //  * Determine whether the user can create models.
    //  */
    // public function create($user): bool
    // {
    //     return $user->hasAbility('product.create');
    // }

    // /**
    //  * Determine whether the user can update the model.
    //  */
    // public function update($user, product $product): bool
    // {
    //     return $user->hasAbility('product.update')
    //             && $product->store_id == $user->store_id;
    // }

    // /**
    //  * Determine whether the user can delete the model.
    //  */
    // public function delete($user, product $product): bool
    // {
    //     return $user->hasAbility('product.delete') 
    //             && $product->store_id == $user->store_id;
    // }

    // /**
    //  * Determine whether the user can restore the model.
    //  */
    // public function restore($user, product $product): bool
    // {
    //     return $user->hasAbility('product.restore');
    // }

    // /**
    //  * Determine whether the user can permanently delete the model.
    //  */
    // public function forceDelete($user, product $product): bool
    // {
    //     return $user->hasAbility('product.forceDelete');
    // }
}
