<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;



class AuthController extends Controller
{
    public function register(Request $request){
        $atter = $request->validate([
            'name'=>['required'],
            'email'=>['required','string','email'],
            'password'=>['required'],
        ]);

        $user = User::create([
            'name'=>$atter['name'],
            'email'=>$atter['email'],
            'password'=>Hash::make($atter['password']),
        ]);

        // $u=auth()->user()->id;
        if($user){
            return response([
                'user' =>$user,
                'token' => $user->createToken('secret')->plainTextToken ,
            ],200);
        }
        else{
            return response([
                'message' => "sorry you can't register right now | Please tye leater"
            ]);
        }
        
    }

     public function login(Request $request){
        $atter = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if(!Auth::attempt($atter))
        {
            return response([
                'message' => 'Inavild Crdenatail'
            ],403);            
        }

        return response([
            'user' => auth()->user(),
            'token' =>auth()->user()->createToken('secret')->plainTextToken
        ],200);
    }


     function logout(){
        auth()->user()->tokens()->delete();
        return response([
            'message' => 'logout success'
        ],200);
    }


    public function getUser(){
        $users=User::all();
        return response()->json([
            'users' => $users,
        ]);
    }

    public function findUser($user_id){
        $user=User::where('id','=',$user_id)->first();

        if($user){
            return response()->json([
                'user'=>$user,
            ]); 
        }
        return response()->json([
            'message' =>'User not found',
        ]);
    }

    public function makeUserAdmin($id){
        $user=User::where('id','=',$id)->first();
        
        $user->update([
            'role'=>1,
        ]);

        return response()->json([
            'user'=>$user,
        ]);
    }

    public function getUserInfo(){
        $userInfo = auth()->user();
        return response()->json([
            'user' => $userInfo
        ]);
    }

    public function updateUserInfo(Request $request){
        $userId = auth()->user()->id;
        $user = User::where('id','=',$userId)->first();

        $user->update([
            'name' => $request->input('name') ?? $user['name'],
            'email' => $request->input('email') ?? $user['email'],
            'address' => $request->input('address') ?? $user['address'],
        ]);

        return response()->json([
            'user' => $user
        ]);
    }



}


