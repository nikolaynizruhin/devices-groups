<?php

namespace App\Queries;

use App\Group;

class GroupDetailsQuery
{
    /**
     * Call an object as a function.
     *
     * @param  \App\Group  $group
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function __invoke(Group $group)
    {
        return Group::with(['devices' => function ($query) {
            $query->orderBy('connected_at', 'desc')->take(5);
        }])->withCount('devices')
            ->find($group->id);
    }
}
