<?php

namespace App\Http\Controllers;

use App\Group;
use App\Http\Requests\StoreGroup;
use App\Http\Requests\UpdateGroup;
use App\Queries\GroupDetailsQuery;

class GroupController extends Controller
{
    /**
     * Display a listing of the groups.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Group::all();
    }

    /**
     * Store a newly created group in storage.
     *
     * @param  \App\Http\Requests\StoreGroup  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreGroup $request)
    {
        return Group::create($request->only(['slug', 'name']));
    }

    /**
     * Display the specified group.
     *
     * @param  \App\Queries\GroupDetailsQuery $details
     * @param  \App\Group  $group
     * @return \Illuminate\Http\Response
     */
    public function show(GroupDetailsQuery $details, Group $group)
    {
        return $details($group);
    }

    /**
     * Update the specified group in storage.
     *
     * @param  \App\Http\Requests\UpdateGroup  $request
     * @param  \App\Group  $group
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateGroup $request, Group $group)
    {
        $group->update($request->only(['slug', 'name']));

        return $group;
    }

    /**
     * Remove the specified group from storage.
     *
     * @param  \App\Group  $group
     * @return \Illuminate\Http\Response
     */
    public function destroy(Group $group)
    {
        $group->delete();

        return response('', 204);
    }
}
