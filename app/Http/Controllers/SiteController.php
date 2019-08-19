<?php

namespace App\Http\Controllers;

use App\Contracts\Repositories\SiteRepository;
use App\Contracts\Repositories\UserRepository;
use App\Http\Requests\CreateSitePost;
use App\Http\Requests\UpdateSitePost;
use Illuminate\Http\Request;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Hash;

class SiteController extends Controller
{
     /**
     * The token repository instance.
     *
     * @var \Laravel\Spark\Contracts\Repositories\SiteRepository
     */
    protected $user, $site;

    protected $redirectTo = '/site/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(UserRepository $user, SiteRepository $site)
    {
        $this->user = $user;
        $this->site = $site;
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
            'sites'=>$this->site->paginate(),
        ];

        return view("site", $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view("site.create");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateSitePost $request)
    {
        $data = $request->only(['name',]);

        $site = $this->site->create($data);
        
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
            'site'=>$this->site->find($id),
        ];

        return view("site.show", $data);
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
            'site'=>$this->site->find($id),
        ];

        return view("site.edit", $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateSitePost $request, $id)
    {
        $data = $request->only([
            'name',
        ]);

        $this->site->update($id, $data);

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
        $this->site->destroy($id);

        return request()->ajax() ? "" : redirect($this->redirectTo);
    }
}
