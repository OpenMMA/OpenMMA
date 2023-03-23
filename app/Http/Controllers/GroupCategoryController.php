<?php

namespace App\Http\Controllers;

use App\Models\Groups\GroupCategory;
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
}
