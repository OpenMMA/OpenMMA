<?php

namespace App\Http\Controllers;

use App\Models\Groups\Role;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): Response
    {
        $groups = Role::where('name', 'NOT LIKE', '%:%')->get();
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
        $name = RoleController::simplify($request->group_name);
        if (Role::where('name', '=', $name)->exists()) {
            return response()->redirectTo('/dashboard/groups')->with(array('status' => 'exists'));
        }
        
        $role = Role::create(['name' => $name, 'title' => $request->group_name]);
        return response()->redirectTo('/dashboard/group/' . $role->id)->with(array('status' => 'success'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Role $role): Response
    {
        return response()->view('dashboard.group', ['group' => $role]);
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
