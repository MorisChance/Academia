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
    // 省略
    public function viewAny(User $user)
    {
        
        return true;
    }

    //買う人と売る人が一致していなれば、購入ボタンを見せる
    public function view(User $user, Commodity $commodity)
    {
        return !($user->id === $commodity->user_id);
    }

    // 省略
    public function create(User $user)
    {
        return true;
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\JobOffer  $job_offer
     * @return \Illuminate\Auth\Access\Response|bool
     */
    //ユーザーと商品を投稿する人が一致していれば、編集と投稿ボタンを見せる
    public function update(User $user, Commodity $commodity)
    {
        return $user->id === $commodity->user_id;
    }

    public function delete(User $user, Commodity $commodity)
    {
        return $user->id === $commodity->user_id;

    }
    
}
