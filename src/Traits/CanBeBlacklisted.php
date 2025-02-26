<?php

/*
 * This file is part of the overtrue/laravel-follow
 *
 * (c) overtrue <i@overtrue.me>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Overtrue\LaravelFollow\Traits;

use Overtrue\LaravelFollow\Follow;

/**
 * Trait CanBeBookmarked.
 */
trait CanBeBlacklisted
{
    /**
     * Check if user is bookmarked by given user.
     *
     * @param int $user
     *
     * @return bool
     */
    public function isBlacklistedBy($user)
    {
        return Follow::isRelationExists($this, 'blacklisters', $user);
    }

    /**
     * Return bookmarkers.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function blacklisters()
    {
        return $this->morphToMany(config('follow.user_model'), config('follow.morph_prefix'), config('follow.followable_table'))
            ->wherePivot('relation', '=', Follow::RELATION_BLACKLIST)
            ->withPivot('followable_type', 'relation', 'created_at');
    }
}
