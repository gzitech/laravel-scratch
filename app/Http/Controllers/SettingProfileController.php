<?php

namespace App\Http\Controllers;

use App\Contracts\Repositories\SettingProfileRepository;
use App\Http\Requests\CreateSettingProfilePost;
use App\Http\Requests\UpdateSettingProfilePost;
use Illuminate\Http\Request;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Hash;

class SettingProfileController extends Controller
{
     /**
     * The token repository instance.
     *
     * @var \Laravel\Spark\Contracts\Repositories\SettingProfileRepository
     */
    protected $settingProfile;

    protected $redirectTo = '/setting/profile/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(SettingProfileRepository $settingProfile)
    {
        $this->settingProfile = $settingProfile;
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
            'settingProfiles'=>$this->settingProfile->paginate(),
        ];

        return view("setting/profile", $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view("setting/profile.create");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateSettingProfilePost $request)
    {
        $data = $request->only([
            'name',
            'description',
        ]);

        $settingProfile = $this->settingProfile->create($data);
        
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
            'settingProfile'=>$this->settingProfile->find($id),
        ];

        return view("setting/profile.show", $data);
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
            'settingProfile'=>$this->settingProfile->find($id),
        ];

        return view("setting/profile.edit", $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateSettingProfilePost $request, $id)
    {
        $data = $request->only([
            'name',
            'description',
        ]);

        $this->settingProfile->update($id, $data);

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
        $this->settingProfile->destroy($id);

        return request()->ajax() ? "" : redirect($this->redirectTo);
    }
}
