<?php

namespace App\Http\Controllers;

use App\Models\Groups\Group;
use App\Models\Groups\Role;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): Response
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): Response
    {
        //
    }

    private static function simplify($str) {
        return preg_replace('/[^A-Za-z0-9\-]/', '', str_replace(' ', '-', strtolower(trim($str))));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $group = Group::where(['name' => $request->route("group")])->first();
        if (!$group)
            return response()->redirectTo('/dashboard/groups')->with(array('status' => 'unknown_group'));
    
        if (!Auth::user()->can($group->name.'.role.create'))
            return response()->redirectTo('/dashboard/group/'.$group->name)->with(array('status' => 'permission_denied'));
    
        $role_name = RoleController::simplify($request->role_name);
        if ($role_name == '')
            return response()->redirectTo('/dashboard/group/'.$group->name)->with(array('status' => 'exists'));

        $role_name_full = $group->name.'.'.$role_name;
        if (Role::where('name', '=', $role_name_full)->exists())
            return response()->redirectTo('/dashboard/group/'.$group->name)->with(array('status' => 'exists'));
        
        $role = Role::create(['name' => $role_name_full, 'title' => $request->role_name, 'isBaseRole' => false, 'group' => $group->id]);
        return response()->redirectTo('/dashboard/group/'.$group->name.'/role/'.explode('.', $role->name, 2)[1])->with(array('status' => 'success'));
    }

    /**
     * Display the specified resource.
     */
    public function show(string $group, Role $role): Response
    {
        return response()->view('dashboard.role', ['group' => $group, 'role' => $role]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Role $role): Response
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Role $role): RedirectResponse
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Role $role): RedirectResponse
    {
        //
    }
}
