<?php

namespace App\Http\Controllers;

use App\Contracts\Repositories\RoleRepository;
use App\Contracts\Repositories\UserRepository;
use App\Http\Requests\CreateUserPost;
use App\Http\Requests\UpdateUserPost;
use Illuminate\Http\Request;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
     /**
     * The token repository instance.
     *
     * @var \Laravel\Spark\Contracts\Repositories\UserRepository
     */
    protected $user;

    protected $redirectTo = '/user/';

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
        $this->user->authorize('user.all');

        $key = $request->key;

        $data = [
            'users'=>$this->user->getUsers($key),
        ];

        return view("user", $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->user->authorize('user.edit');

        return view("user.create");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateUserPost $request)
    {
        $this->user->authorize('user.edit');

        $data = $request->only([
            'first_name',
            'last_name',
            'email',
            ]);

        $user = $this->user->create($data);

        $user->roles()->attach([
            config('rbac.roles')['member']
        ]);
        
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
        $this->user->authorize('user.edit');

        $key = $request->key;

        $user = $this->user->find($id);
        $data = [
            'user'=>$user,
            'roles'=>$this->role->getRolesByUser($user, $key),
            'userRight'=>$this->user->getRight($user),
            'rights'=>$this->user->getRights(),
        ];

        return view("user.show", $data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $this->user->authorize('user.edit');

        $data = [
            'user'=>$this->user->find($id),
        ];

        return view("user.edit", $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateUserPost $request, $id)
    {
        $this->user->authorize('user.edit');

        $data = $request->only([
            'first_name',
            'last_name',
            'email',
            ]);

        $this->user->update($id, $data);

        return $request->ajax() ? "" : redirect()->route('user.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->user->authorize('user.edit');
        
        $this->user->destroy($id);

        return request()->ajax() ? "" : redirect()->route('user.index');
    }
}
