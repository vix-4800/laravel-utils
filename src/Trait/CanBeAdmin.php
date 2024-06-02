<?php

namespace Vix\LaravelUtils\Traits;

use Illuminate\Database\Eloquent\Builder;

trait CanBeAdmin
{
    /**
     * Assign admin role to the user.
     *
     * @return void
     */
    public function makeAdmin(): void
    {
        $this->is_admin = true;
        $this->save();
    }

    /**
     * Revoke admin role from the user.
     *
     * @return void
     */
    public function revokeAdmin(): void
    {
        $this->is_admin = false;
        $this->save();
    }

    /**
     * Check if the user has an admin role.
     *
     * @return bool
     */
    public function isAdmin(): bool
    {
        return $this->is_admin;
    }

    /**
     * Scope a query to only include admin users.
     *
     * @param Builder $query
     * @return Builder
     */
    public function whereAdmin(Builder $query): Builder
    {
        return $query->where('is_admin', true);
    }

    /**
     * Scope a query to only include non-admin users.
     *
     * @param Builder $query
     * @return Builder
     */
    public function whereNotAdmin(Builder $query): Builder
    {
        return $query->where('is_admin', false);
    }
}
