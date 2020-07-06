<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileRequest;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    protected $user;

    /**
     * Create a new controller instance
     *
     * @param  User $user
     * @return void
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     * Display a list information user
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {
        $profile = $this->user->getUser($id);
        return view('profiles.index', compact('profile'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function editProfile($id)
    {
        $profile = $this->user->getUser($id);
        return view('profiles.edit', compact('profile'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  App\Http\Requests\ProfileRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function updateProfile(ProfileRequest $request, $id) {
        try {

            $this->user->updateUser($request->all(), $id);
            flash('Đã cập nhật Profile thành công.')->success();
        } catch (\Exception $e) {
            \Log::error($e);
            flash('Cập nhật Profile thất bại. Vui lòng thử lại.')->error();
        }
        return redirect($request->redirect_url);
    }
}
