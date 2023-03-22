<?php

namespace App\Http\Controllers;

use App\Models\Groups\Group;
use App\Models\Groups\Permission;
use App\Models\Groups\Role;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class GroupController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): Response
    {
        $groups = Group::all();
        return response()->view('dashboard.groups', ['groups' => $groups]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): Response
    {
        //
    }

    private function simplify($str) {
        return preg_replace('/[^A-Za-z0-9\-]/', '', str_replace(' ', '-', strtolower(trim($str))));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $name = GroupController::simplify($request->group_name);
        if (Group::where('name', '=', $name)->exists()) {
            return response()->redirectTo('/dashboard/groups')->with(array('status' => 'exists'));
        }
        
        $group = Group::create(['name' => $name, 'title' => $request->group_name]);
        Permission::createPermissionsForGroup($group->name);
        Role::create(['name' => $group->name . '.', 'title' => '']);
        return response()->redirectTo('/dashboard/group/' . $group->name)->with(array('status' => 'success'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Group $group): Response
    {
        return response()->view('dashboard.group', ['group' => $group]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Group $group): Response
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Group $group): RedirectResponse
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Group $group): RedirectResponse
    {
        //
    }
}
