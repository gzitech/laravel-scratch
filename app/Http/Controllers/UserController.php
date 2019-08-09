<?php

namespace App\Http\Controllers;

use App\Contracts\Repositories\RightRepository;
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
    protected $user, $right;

    protected $redirectTo = '/user/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(UserRepository $user, RightRepository $right)
    {
        $this->user = $user;
        $this->right = $right;
        $this->middleware('auth');
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->user->authorize('user.list');

        $data = [
            'users'=>$this->user->paginate(),
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
        $this->user->authorize('user.update');

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
        $this->user->authorize('user.update');

        $data = $request->only([
            'first_name',
            'last_name',
            'email',
            ]);

        $user = $this->user->create($data);

        $user->roles()->attach([
            config('rbac.roles')['member']
        ]);

        $this->user->updateRight($user->id);
        
        return redirect($this->redirectTo);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $this->user->authorize('user.list');

        $data = [
            'user'=>$this->user->find($id),
            'rights'=>$this->right->all(),
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
        $this->user->authorize('user.update');

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
        $this->user->authorize('user.update');

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
        $this->user->authorize('user.update');
        
        $this->user->destroy($id);

        return request()->ajax() ? "" : redirect()->route('user.index');
    }
}
