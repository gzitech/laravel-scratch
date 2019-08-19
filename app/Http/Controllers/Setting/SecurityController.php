<?php

namespace App\Http\Controllers\Setting;

use App\Contracts\Repositories\UserRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;

class SecurityController extends Controller
{
    protected $user;

    protected $redirectTo = '/setting/security/';

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
            'user'=>$this->user->user(),
        ];

        return view("setting/security", $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'current_password' => 'required',
            'password' => 'required|confirmed|different:current_password|min:8',
            'password_confirmation' => 'required',
        ]);

        if (!Hash::check($request->current_password, $request->user()->password)) {
            return back()->withErrors(['current_password'=>'The given password does not match our records.']);
        } else {
            $this->user->updatePassword($request->password);
            return $request->ajax() ? "" : redirect($this->redirectTo);
        }
    }
}
