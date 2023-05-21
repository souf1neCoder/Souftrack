<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Operation;

use Illuminate\Auth\Access\Response;
use Illuminate\Auth\Access\HandlesAuthorization;

class OperationPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function viewAny(User $user)
    {
        return true;
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Operation  $operation
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(User $user, Operation $operation)
    {
        return $user->account->operations()->where('operations.id',$operation->id)->exists() ? Response::allow()
        : Response::deny('You do not have this operation.');
        
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function create(User $user)
    {
        return true;
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Operation  $operation
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user, Operation $operation)
    {
        return $user->account->operations()->where('operations.id',$operation->id)->exists() ? Response::allow()
        : Response::deny('You do not have this operation.');
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Operation  $operation
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user, Operation $operation)
    {
        return $user->account->operations()->where('operations.id',$operation->id)->exists() ? Response::allow()
        : Response::deny('You do not have this operation.');
    }

   
}
