<?php

namespace App\Http\Controllers\Authentication;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Http\Requests\ChangePasswordRequest;
use App\Http\Resources\Master\MenuAccessResource;
use App\Models\Master\MRole;
use App\Traits\MainTrait;
use Bschmitt\Amqp\Facades\Amqp;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class AuthController extends Controller
{
    use MainTrait;
    /**
     * Login api
     *
     * @return \Illuminate\Http\Response
     */

    public function login(Request $request)
    {
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            $user = Auth::user();

            if (!$user->role) {
                return $this->sendError('Role has been deleted, please contact admin!', 403);
            }
            $success['token']       =  $user->createToken('MyApp', [
                'expires_at' => now()->addMinutes(config('session.lifetime')),
            ])->plainTextToken;
            $success['id']              =  $user->id;
            $success['name']            =  $user->name;
            $success['email']             =  $user->email;
            $success['expires_at']      =  now()->addMinutes(config('session.lifetime'))->timestamp;
            $success['role']           =  $user->role;
            // $success['menu_access']     =  MenuAccessResource::collection($user->role->menuAccess);

            // $this->recordLog([
            //     'action' => 'Login',
            //     'modul' => 'Authentication',
            //     'description' => 'User ' . $user->name . ' has logged in',
            //     'user' => $user->name
            // ]);

            // $rolesAdmin = MRole::where('id',config('custom.SUPER_ADMIN_ROLE_ID'))->first();

            // $this->pushNotification([
            //     'title' => 'Login',
            //     'description' => 'You has logged in',
            //     'user_id' => $user->id,
            //     'target_user_id' => $user->id
            // ]);

            // check amqp connection
            // $amqpConnected = $this->amqpCheckConnection();

            // send notification to all admin
            // foreach($rolesAdmin->users as $admin){
            //     if($user->id != $admin->id){
            //         $data = [
            //             'title' => 'Login',
            //             'description' => 'User has logged in',
            //             'user_id' => $user->id,
            //             'target_user_id' => $admin->id
            //         ];

            //         $result = $this->pushNotification($data);
            //         if($amqpConnected){
            //             Amqp::publish('drh.notifications.'.$admin->id, json_encode($result) , [
            //                 'exchange_durable' => 'true',
            //                 'exchange'=> 'amq.topic',
            //                 'exchange_type' => 'topic',
            //             ]);
            //         }
            //     }
            // }

            return $this->sendResponse($success, 'User login successfully.');
        } else {
            return $this->sendError('Email or Password are wrong', 401);
        }
    }

    // public function getMenuAccess(){
    //     $user = Auth::user();

    //     $menu_access = MenuAccessResource::collection($user->role->menuAccess);


    //     return $this->sendResponse($menu_access, 'Successfull get Menu Access');
    // }

    public function logout(Request $request)
    {
        $user = Auth::user();
        $user->tokens()->delete();

        // delete the current token that was used for the request
        $request->user()->currentAccessToken()->delete();

        // $this->recordLog([
        //     'action' => 'Logout',
        //     'modul' => 'Authentication',
        //     'description' => 'User '.$user->name.' has logged out'
        // ]);

        // $rolesAdmin = MRole::where('id',config('custom.SUPER_ADMIN_ROLE_ID'))->first();

        return $this->sendResponse([], 'User logout successfully.');
    }

    // public function changePassword(ChangePasswordRequest $request)
    // {
    //     $currentPasswordStatus = Hash::check($request->current_password, auth()->user()->password);
    //     if($currentPasswordStatus){

    //         $user = User::findOrFail(Auth::user()->id);
    //         $user->update([
    //             'password' => Hash::make($request->password),
    //         ]);
    //         $this->recordLog([
    //             'action' => 'Change Password',
    //             'modul' => 'Authentication',
    //             'description' => 'User '.$user->name.' has changed password'
    //         ]);

    //         return $this->sendResponse([], 'Password updated successfully');
    //     }else{

    //         return $this->sendError('Current password does not match with old password',400);
    //     }
    // }
}
