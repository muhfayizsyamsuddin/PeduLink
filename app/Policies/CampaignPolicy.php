<?php

namespace App\Policies;

use App\Models\Campaign;
use App\Models\User;

class CampaignPolicy
{
    /**
     * Determine whether the user can view the campaign.
     */
    public function view(?User $user, Campaign $campaign): bool
    {
        return $campaign->status === 'active'
            || $user?->role === 'admin';
    }

    /**
     * Determine whether the user can update the campaign.
     */
    public function update(User $user, Campaign $campaign): bool
    {
        return $user->role === 'admin';
    }

    /**
     * Determine whether the user can delete the campaign.
     */
    public function delete(User $user, Campaign $campaign): bool
    {
        return $user->role === 'admin';
    }
}