<?php

namespace App\Http\Controllers;

use App\Contracts\Repositories\RoleRepository;
use App\Contracts\Repositories\UserRepository;
use Illuminate\Http\Request;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Artisan;

class RightController extends Controller
{
     /**
     * The token repository instance.
     *
     * @var \Laravel\Spark\Contracts\Repositories\RightRepository
     */
    protected $user, $role;

    protected $redirectTo = '/role/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(UserRepository $user, RoleRepository $role)
    {
        $this->user = $user;
        $this->role = $role;
        $this->middleware('auth');
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($role_id)
    {
        $this->user->authorize('right.edit');

        $data = [
            'role'=>$this->role->find($role_id),
            'rights'=>$this->user->getConfigRights(),
        ];

        return view("right", $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $role_id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $role_id)
    {
        $this->user->authorize('right.edit');

        $right = $request->right ?? [];

        $userRight = $this->user->getRight();
        $this->role->updateRight($role_id, $userRight, $right);
        $this->user->clearRightByRoleId($role_id);

        $redirectTo = $this->redirectTo . "$role_id";

        return $request->ajax() ? ""  : redirect($redirectTo);
    }
}
