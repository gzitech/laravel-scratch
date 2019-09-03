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
    public function index(Request $request)
    {
        $this->user->authorize('site.all|site.self');

        $key = $request->key;

        $data = [];

        if($this->user->checkRight('site.all')) {
            $data['sites'] = $this->site->getSites($key);
        } else {
            $user_id = $this->user->id();
            $data['sites'] = $this->site->getSitesByUserId($user_id, $key);
        }

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

        $site = $this->site->create($this->user->id(), $data);
        
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
        $this->user->authorize('site.edit');

        $key = $request->key;

        $data = [
            'site'=>$this->site->find($id),
            'users'=>$this->user->getUsersBySiteId($id, $key),
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
