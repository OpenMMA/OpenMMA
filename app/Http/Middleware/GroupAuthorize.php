<?php

namespace App\Http\Middleware;

use App\Models\Groups\Group;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class GroupAuthorize
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, $permission): Response
    {
        // dd($request, $permission, $request->route()->event);
        if ($request->route()->event == null || !Auth::user()->can(Group::find($request->route()->event->group)->name.$permission))
            return response("Not allowed.", 403);
        // if (!Auth::user()->can($request->))

        return $next($request);
    }
}
