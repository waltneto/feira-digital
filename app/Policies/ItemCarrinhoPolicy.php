<?php

namespace App\Policies;

use App\Models\ItemCarrinho;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ItemCarrinhoPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\ItemCarrinho  $itemCarrinho
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user, ItemCarrinho $itemCarrinho)
    {
        return $user->isConsumidor() && $user->consumidor->id === $itemCarrinho->carrinho->consumidor_id;
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\ItemCarrinho  $itemCarrinho
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user, ItemCarrinho $itemCarrinho)
    {
        return $this->update($user, $itemCarrinho);
    }
}
