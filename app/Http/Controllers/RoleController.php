<?php

namespace App\Http\Controllers;

use App\Contracts\Repositories\RoleRepository;
use App\Contracts\Repositories\UserRepository;
use App\Http\Requests\CreateRolePost;
use App\Http\Requests\UpdateRolePost;
use Illuminate\Http\Request;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Hash;

class RoleController extends Controller
{
     /**
     * The token repository instance.
     *
     * @var \Laravel\Spark\Contracts\Repositories\RoleRepository
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
    public function index(Request $request)
    {
        $this->user->authorize('role.all');

        $key = $request->key;

        $data = [
            'roles'=>$this->role->getRoles($key),
        ];

        return view("role", $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->user->authorize('role.edit');

        return view("role.create");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateRolePost $request)
    {
        $this->user->authorize('role.edit');

        $data = $request->only([
            'role_name',
            'role_description',
        ]);

        $role = $this->role->create($data);
        
        return redirect($this->redirectTo);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    {
        $this->user->authorize('role.edit');

        $role = $this->role->find($id);
        $key = $request->key;

        $data = [
            'role'=>$role,
            'users'=>$this->user->getUsersByRole($role, $key),
            'rights'=>$this->user->getConfigRights(),
        ];

        return view("role.show", $data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $this->user->authorize('role.edit');

        $data = [
            'role'=>$this->role->find($id),
        ];

        return view("role.edit", $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateRolePost $request, $id)
    {
        $this->user->authorize('role.edit');

        $data = $request->only([
            'role_name',
            'role_description',
        ]);

        $this->role->update($id, $data);

        return $request->ajax() ? "" : redirect($this->redirectTo);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->user->authorize('role.edit');

        $this->role->destroy($id);

        return request()->ajax() ? "" : redirect($this->redirectTo);
    }
}
