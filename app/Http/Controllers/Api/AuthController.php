<?php

namespace App\Http\Controllers\Api;

use Exception;
use App\Models\User;
use App\Helper\ResponseHelper;
use App\Http\Requests\LoginRequest;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\RegisterRequest;

class AuthController extends Controller
{
    /**
     * Function : register user
     * @param App\Request\RegisterRequest $request
     */
    public function register(RegisterRequest $request)
    {
        try {
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'phone_number' => $request->phone_number,
            ]);

            if ($user) {
                return ResponseHelper::success(message: 'user has been registered successfuly!', data: $user, statusCode: 201);
            }
            return ResponseHelper::error(message: 'Unable to registered user , please try again!', statusCode: 400);
        } catch (Exception $e) {
            \Log::error('Unable to registered user : ' . $e->getMessage(), ' _ Line no ' . $e->getLine());
            return ResponseHelper::error(message: 'Unable to registered user , please try again!' . $e->getMessage() , statusCode: 500);
        }
    }

    /**
     * Function : login user
     * @param App\Request\LoginRequest $request
     */
    public function login(LoginRequest $request)
    {
        try {

            // if credential are incorrect
            if(!Auth::attempt(['email' => $request->email, 'password' => $request->password])){
                return ResponseHelper::error(message: 'Unable to login due to invalid credentials' , statusCode: 400);
            };

            $user = Auth::user();

            // create API token
            $token = $user->createToken('MY API token')->plainTextToken;

            $authUser = [
                'user' => $user,
                'token' => $token
            ];

            return ResponseHelper::success(message: 'you are logged in  successfuly!', data: $authUser, statusCode: 200);
           
        } 
        catch (Exception $e) {
            \Log::error('Unable to Login user : ' . $e->getMessage(), ' - Line no ' . $e->getLine());

            return ResponseHelper::error(message: 'Unable to Login , please try again!' . $e->getMessage() , statusCode: 500);
        }
    }

    /**
     * Function : auth user data / profile data
     * @param NA
     * @return JSONResponse
     */

    public function userProfile(){
        try{
            $user = Auth::user();

            if($user){
                return ResponseHelper::success(message: 'User profile fetched successfuly!', data: $user, statusCode: 200);
            }

            return ResponseHelper::error(message: 'Unable to fetch user due to invalid token' , statusCode: 400);
        }
        catch (Exception $e){
            \Log::error('Unable to fetch user profile  : ' . $e->getMessage(), ' - Line no ' . $e->getLine());
            return ResponseHelper::error(message: 'Unable to fetch user profile , please try again!' . $e->getMessage() , statusCode: 500);
        }
    }

    public function userLogout(){
        try{
            $user = Auth::user();

            if($user){
                $user->currentAccessToken()->delete();
                return ResponseHelper::success(message: 'User logout successfuly!', statusCode: 200);
            }

            return ResponseHelper::error(message: 'Unable to logout due to invalid token' , statusCode: 400);
        }
        catch (Exception $e){
            \Log::error('Unable to logout due to some exception  : ' . $e->getMessage(), ' - Line no ' . $e->getLine());
            return ResponseHelper::error(message: 'Unable to logout due to user profile , please try again!' . $e->getMessage() , statusCode: 500);
        }
    }



}
