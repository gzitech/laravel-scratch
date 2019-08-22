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
        $this->user->authorize('site.all|site.self');

        $user_id = $this->user->id();

        $data = [
            'sites'=> $this->user->checkRight('site.all') ? $this->site->getSites() : $this->site->getSitesByUserId($user_id),
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
        $this->user->authorize('site.edit');

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
        $this->user->authorize('site.edit');

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
        $this->user->authorize('site.edit');

        $data = [
            'site'=>$this->site->find($id),
            'users'=>$this->user->getUsersBySiteId($id),
        ];

        return view("site.show", $data);
    }
    
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->user->authorize('site.edit');

        $this->site->destroy($id);

        return request()->ajax() ? "" : redirect($this->redirectTo);
    }
}
