<?php

namespace App\Policies;

use App\Models\Commodity;
use App\Models\Purchase;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class PurchasePolicy
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
    
        public function viewAny(User $user, Commodity $commodity, Purchase $purchase )
    {
    
    }
}
