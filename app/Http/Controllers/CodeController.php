<?php

namespace App\Http\Controllers;

use App\Contracts\Repositories\CodeRepository;
use App\Http\Requests\CreateCodePost;
use App\Http\Requests\UpdateCodePost;
use Illuminate\Http\Request;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Hash;

class CodeController extends Controller
{
     /**
     * The token repository instance.
     *
     * @var \Laravel\Spark\Contracts\Repositories\CodeRepository
     */
    protected $code;

    protected $redirectTo = '/code/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(CodeRepository $code)
    {
        $this->code = $code;
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
            'codes'=>$this->code->all(),
        ];

        return view("code", $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view("code.create");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateCodePost $request)
    {
        $data = $request->only([
            'model_name',
        ]);
        
        return redirect($this->redirectTo);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($modelName)
    {
        $data = [
            'model'=>$this->code->find($modelName),
        ];

        return view("code.show", $data);
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
            'code'=>'',
        ];

        return view("code.edit", $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateCodePost $request, $id)
    {
        $data = $request->only([
            'model_name',
        ]);

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
        return request()->ajax() ? ""  : redirect($this->redirectTo);
    }
}
