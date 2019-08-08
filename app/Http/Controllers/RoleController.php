<?php

namespace App\Http\Controllers;

use App\Contracts\Repositories\RightRepository;
use App\Contracts\Repositories\RoleRepository;
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
    protected $role, $right;

    protected $redirectTo = '/role/';

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
    public function index()
    {
        $data = [
            'roles'=>$this->role->paginate(),
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
    public function show($id)
    {
        $data = [
            'role'=>$this->role->find($id),
            'rights'=>$this->right->all(),
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
        $data = $request->only([
            'role_name',
            'role_description',
        ]);

        $this->role->update($id, $data);

        return $request->ajax() ? ""  : redirect($this->redirectTo);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->role->destroy($id);

        return request()->ajax() ? ""  : redirect($this->redirectTo);
    }
}
