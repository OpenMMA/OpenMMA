<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Mail\AccountVerified;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): Response
    {
        // $users = User::orderByDesc('created_at')->get();
        // return response()->view('dashboard.users', ['users' => $users]);
        return response()->view('dashboard.users');
    }

    /**
     * Display a profile page for the user.
     */
    public function profile(): Response
    {
        return response()->view('profile.profile');
    }

    public function verify(User $user): JsonResponse
    {
        if ($user->user_verified_at != NULL)
            return response()->json(['verified' => 'already_verified']);
        $user->user_verified_at = Carbon::now();
        $user->save();
        $user->assignRole('member.');
        Mail::to($user)->send(new AccountVerified($user));
        return response()->json(['verified' => 'verified']);
    }

    public function search(Request $request): JsonResponse
    {
        $q = $request->input('q');
        return response()->json(User::whereRaw('CONCAT(first_name, \' \', last_name) LIKE ?', ["%$q%"])
                                    ->orWhere('email', 'LIKE', "%$q%")
                                    ->get());
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): Response
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user): Response
    {
        return response()->view('dashboard.user', ['user' => $user]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user): Response
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user): RedirectResponse
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user): RedirectResponse
    {
        //
    }
}
