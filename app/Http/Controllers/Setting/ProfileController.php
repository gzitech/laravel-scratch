<?php

namespace App\Http\Controllers\Setting;

use App\Http\Controllers\Controller;
use App\Contracts\Repositories\UserRepository;
use App\Http\Requests\CreateSettingProfilePost;
use App\Http\Requests\UpdateSettingProfilePost;
use Illuminate\Http\Request;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
     /**
     * The token repository instance.
     *
     * @var \Laravel\Spark\Contracts\Repositories\UserRepository
     */
    protected $user;

    protected $redirectTo = '/setting/profile/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(UserRepository $user)
    {
        $this->user = $user;
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
            'user'=>$this->user->find(1),
        ];

        return view("setting/profile", $data);
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
}
