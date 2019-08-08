<?php

namespace App\Http\Controllers;

use App\Contracts\Repositories\RightRepository;
use App\Contracts\Repositories\RoleRepository;
use Illuminate\Http\Request;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Hash;

class RightController extends Controller
{
     /**
     * The token repository instance.
     *
     * @var \Laravel\Spark\Contracts\Repositories\RightRepository
     */
    protected $role, $right;

    protected $redirectTo = '/right/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(RoleRepository $role, RightRepository $right)
    {
        $this->role = $role;
        $this->right = $right;
        $this->middleware('auth');
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($role_id)
    {
        $data = [
            'role'=>$this->role->find($role_id),
            'rights'=>$this->right->all(),
        ];

        return view("right", $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $right = $request->right;

        $this->role->updateRight($id, $right);

        return $request->ajax() ? ""  : redirect($this->redirectTo);
    }
}