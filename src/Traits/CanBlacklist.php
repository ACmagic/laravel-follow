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
 * Trait CanBookmark.
 */
trait CanBlacklist
{
    /**
     * Follow an item or items.
     *
     * @param int|array|\Illuminate\Database\Eloquent\Model $targets
     * @param string                                        $class
     *
     * @throws \Exception
     *
     * @return array
     */
    public function blacklist($targets, $class = __CLASS__)
    {
        return Follow::attachRelations($this, 'blacklists', $targets, $class);
    }

    /**
     * Unbookmark an item or items.
     *
     * @param int|array|\Illuminate\Database\Eloquent\Model $targets
     * @param string                                        $class
     *
     * @return array
     */
    public function unblacklist($targets, $class = __CLASS__)
    {
        return Follow::detachRelations($this, 'blacklists', $targets, $class);
    }

    /**
     * Toggle bookmark an item or items.
     *
     * @param int|array|\Illuminate\Database\Eloquent\Model $targets
     * @param string                                        $class
     *
     * @throws \Exception
     *
     * @return array
     */
    public function toggleBlacklist($targets, $class = __CLASS__)
    {
        return Follow::toggleRelations($this, 'blacklists', $targets, $class);
    }

    /**
     * Check if user is bookmarked given item.
     *
     * @param int|array|\Illuminate\Database\Eloquent\Model $target
     * @param string                                        $class
     *
     * @return bool
     */
    public function hasBlacklisted($target, $class = __CLASS__)
    {
        return Follow::isRelationExists($this, 'blacklists', $target, $class);
    }

    /**
     * Return item bookmarks.
     *
     * @param string $class
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function blacklists($class = __CLASS__)
    {
        return $this->morphedByMany($class, config('follow.morph_prefix'), config('follow.followable_table'))
            ->wherePivot('relation', '=', Follow::RELATION_BLACKLIST)
            ->withPivot('followable_type', 'relation', 'created_at');
    }
}
