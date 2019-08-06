<?php

namespace App\Http\Controllers;

use App\Contracts\Repositories\RightRepository;
use App\Http\Requests\CreateRightPost;
use App\Http\Requests\UpdateRightPost;
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
    protected $right;

    protected $redirectTo = '/right/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(RightRepository $right)
    {
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
            'rights'=>[],
        ];

        return view("right", $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view("right.create");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateRightPost $request)
    {
        $data = $request->only([
            'right_name',
            'right_value',
            'right_path',
        ]);

        // $right = $this->right->create($data);
        
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
            'right'=>[],
        ];

        return view("right.show", $data);
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
            'right'=>[],
        ];

        return view("right.edit", $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateRightPost $request, $id)
    {
        $data = $request->only([
            'right_name',
            'right_value',
            'right_path',
        ]);

        // $this->right->update($id, $data);

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
        // $this->right->destroy($id);

        return request()->ajax() ? ""  : redirect($this->redirectTo);
    }
}
