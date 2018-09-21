<?php

namespace App\Http\Controllers\Api\User;

use App\User;
use App\Mail\UserCreated;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Transformers\UserTransformer;
use App\Http\Controllers\Api\ApiController;

class UserController extends ApiController
{
    public function __construct() {
        // parent::__construct();
        $this->middleware('client.credentials')->only(['store', 'resend']);
        $this->middleware('transform.input:'.UserTransformer::class)->only(['store', 'update']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        $users = User::all();

        // 200 - Everything's ok
        return $this->showAll($users);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {
        $rules = [
            'name'     => 'required',
            'email'    => 'required|email|unique:users',
            'password' => 'required|min:6|confirmed'
        ];

        $this->validate($request, $rules);

        $data = $request->all();
        $data['password'] = bcrypt($request->password);
        $data['verified'] = User::UNVERIFIED_USER;
        $data['verification_token'] = User::generateVerificationCode();
        $data['admin'] = User::REGULAR_USER;

        $user = User::create($data);

        // 201 - data created
        return $this->showOne($user, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(User $user) {
        return $this->showOne($user);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id) {
        $user = User::findOrFail($id);

        $rules = [
            'email'    => 'email|unique:users, email, '.$user->id,
            'password' => 'min:6|confirmed',
            'admin'    => 'in:'.User::ADMIN_USER.','.User::REGULAR_USER
        ];

        // Check if there is a name data given
        if ($request->has('name')) {
            $user->name = $request->name;
        }

        // Check if there is an email data given and if it is different to previous one
        // If true, reset verified status and generate new verification token
        if ($request->has('email') && ($user->email != $request->email)){
            $user->verified = User::UNVERIFIED_USER;
            $user->verification_token = User::generateVerificationCode();
            $user->email    = $request->email; 
        }

        // Check if there is a new password data given
        if ($request->has('password')) {
            $user->password = bcrypt($request->password);
        }

        // Check if there is an admin status change data given
        if ($request->has('admin')) {
            if (!$user) {
                return $this->errorResponse('Only verified users can modify the admin field', 409);
            }

            $user->admin = $request->admin;
        }

        // Check if user has NOT changed, return error if so
        if (!$user->isDirty()) {
            return $this->errorResponse('You need to specify a different value to update', 422);
        }

        // Save changes to user
        $user->save();

        return response()->json($user, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id) {
        $user = User::findOrFail($id);

        $user->delete();

        return response()->json($user, 200);
    }

    public function verify($token) {
        $user = User::where('verification_token', '=', $token)->firstOrFail();
        $user->verified           = User::VERIFIED_USER;
        $user->verification_token = null;

        $user->save();

        return $this->showMessage('The account has beeen verified successfully');
    }

    public function resend(User $user) {
        if ($user->isVerified()) {
            return $this->errorResponse('This user is already verified', 409);
        }
        
        retry(5, function() use ($user) {
            Mail::to($user)->send(new UserCreated($user));
        }, 100);

        return $this->showMessage('The verification email has been resent');
    }
}
