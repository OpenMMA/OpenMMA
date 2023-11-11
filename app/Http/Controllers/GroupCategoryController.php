<?php

namespace App\Http\Controllers;

use App\Models\Groups\GroupCategory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class GroupCategoryController extends Controller
{
    /**
     * Display the specified resource.
     */
    public function show(GroupCategory $category): Response
    {
        return response()->view('dashboard.category', ['category' => $category]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        // $name = GroupCategoryController::simplify($request->category_name);
        // if (GroupCategory::where('name', '=', $name)->exists()) {
        //     return response()->redirectTo('/dashboard/group-settings')->with(array('status' => 'exists', 'obj' => 'category'));
        // }
        
        $category = GroupCategory::create(['label' => $request->category_name]);
        if (!$category) {
            return response()->redirectTo('/dashboard/group-settings')->with(array('status' => 'exists', 'obj' => 'category'));
        }
        return response()->redirectTo('/dashboard/group-settings')->with(array('status' => 'success', 'obj' => 'category'));
    }
}
