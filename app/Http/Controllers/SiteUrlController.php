<?php

namespace App\Http\Controllers;

use App\Contracts\Repositories\SiteUrlRepository;
use App\Http\Requests\CreateSiteUrlPost;
use App\Http\Requests\UpdateSiteUrlPost;
use Illuminate\Http\Request;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Hash;

class SiteUrlController extends Controller
{
     /**
     * The token repository instance.
     *
     * @var \Laravel\Spark\Contracts\Repositories\SiteUrlRepository
     */
    protected $siteUrl;

    protected $redirectTo = '/site/url/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(SiteUrlRepository $siteUrl)
    {
        $this->siteUrl = $siteUrl;
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
            'siteUrls'=>$this->siteUrl->paginate(),
        ];

        return view("site/url", $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view("site/url.create");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateSiteUrlPost $request)
    {
        $data = $request->only([
            'site_id',
            'domain',
        ]);

        $siteUrl = $this->siteUrl->create($data);
        
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
            'siteUrl'=>$this->siteUrl->find($id),
        ];

        return view("site/url.show", $data);
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
            'siteUrl'=>$this->siteUrl->find($id),
        ];

        return view("site/url.edit", $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateSiteUrlPost $request, $id)
    {
        $data = $request->only([
            'site_id',
            'domain',
        ]);

        $this->siteUrl->update($id, $data);

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
        $this->siteUrl->destroy($id);

        return request()->ajax() ? "" : redirect($this->redirectTo);
    }
}
