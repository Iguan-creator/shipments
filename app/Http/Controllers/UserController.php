<?php

namespace App\Http\Controllers;

use App\Models\User;
use Exception;
use Illuminate\Database\QueryException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(User::class, 'user');
    }

    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index()
    {
        $users = User::orderBy('last_name')
            ->get();

        return jsonResponse($users);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return string
     */
    public function store(Request $request)
    {
        $user = new User();
        $user->fill($request->all());
        $user->password = Hash::make($request->input('password'));
        $user->save();

        return jsonResponse($user);
    }

    /**
     * Show user instance
     *
     * @param User $user
     * @return JsonResponse
     */
    public function show(User $user)
    {
        return jsonResponse($user);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param User $user
     * @return string
     */
    public function update(Request $request, User $user)
    {

        $user->fill($request->all());

        if ($request->has('password')) {
            if ($request->input('password')) {
                $user->password = Hash::make($request->input('password'));
            }
        }

        $user->save();

        return 'Success';
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param User $user
     * @return string
     * @throws Exception
     */
    public function destroy(User $user)
    {
        try {
            $user->delete();
        } catch (QueryException $exception) {
            return 'Error: The user cannot be deleted';
        }

        return 'Success';
    }

    /**
     * Get current logged-in user instance
     *
     * @return JsonResponse
     */
    public function currentUser()
    {
        if (auth()->check()) {
            $user = auth()->user();
            return jsonResponse($user);
        }
    }
}
