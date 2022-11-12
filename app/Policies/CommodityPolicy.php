<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use App\Models\Commodity;
use App\Models\Purchase;

class CommodityPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\JobOffer  $job_offer
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user, Commodity $commodity)
    {
        return $user->id === $commodity->user_id;
    }

    public function delete(User $user, Commodity $commodity)
    {
        return $user->id === $commodity->user_id;
    }

    public function view(User $user, Commodity $commodity)
    {
        return !($user->id === $commodity->user_id);
        // return $user->id === $purchase->commodity->user_id;
    }
}
