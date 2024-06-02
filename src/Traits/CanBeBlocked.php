<?php

namespace Vix\LaravelUtils\Traits;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;

trait CanBeBlocked
{
    /**
     * Blocks the object by setting the 'blocked_at' property to the current date and time.
     *
     * @return void
     */
    public function block(): void
    {
        $this->blocked_at = Carbon::now();
        $this->save();
    }

    /**
     * Unblocks the object by setting the 'blocked_at' property to null and saving the changes to the database.
     *
     * @return void
     */
    public function unblock(): void
    {
        $this->blocked_at = null;
        $this->save();
    }

    /**
     * Checks if the object is blocked.
     *
     * @return bool Returns true if the object is blocked, false otherwise.
     */
    public function isBlocked(): bool
    {
        return !is_null($this->blocked_at);
    }

    /**
     * Retrieves records from the database where the 'blocked_at' column is not null.
     *
     * @param Builder $query The query builder instance.
     * @return Builder The modified query builder instance.
     */
    public function whereBlocked(Builder $query): Builder
    {
        return $query->whereNotNull('blocked_at');
    }

    /**
     * Retrieves records from the database where the 'blocked_at' column is null.
     *
     * @param Builder $query The query builder instance.
     * @return Builder The modified query builder instance.
     */
    public function whereNotBlocked(Builder $query): Builder
    {
        return $query->whereNull('blocked_at');
    }
}
