<?php

namespace App\Http\Controllers;
use App\Models\User;
use Auth;
use Illuminate\Http\Request;
use App\Http\Requests;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\HasApiTokens;

class AuthController extends Controller
{
    //

    public function register(Request $request){

        $fields = $request->validate([
            "name"=> "required|string",
            "email"=> "required|email|unique:users,email",
            "password"=> "required|string|confirmed",
            'password_confirmation' => 'required|min:8',
        ]);
         
        // $request->password = hash::make($request->password);

        $user = User::create([
            "name"=> $fields["name"],
            "email"=> $fields["email"],
            "password"=> bcrypt($fields["password"]),
        ]);
       

        $token = $user->createToken("myapplicationtoken")->plainTextToken;
        // $token = $user->createToken("remember_token")->accessToken;

        $response = [
          "user"=>$user,
          "token"=>$token
        ];

        return response()->json($response); 

    }



    public function login(Request $request){

        $fields = $request->validate([
           
            "email"=> "required|email",
            "password"=> "required|string",
           
        ]);
         
        // $request->password = hash::make($request->password);

        // check email

        $user = User::where("email",$fields["email"])->first();

        // check password

        if($user){
            $password = Hash::check($fields["password"],$user->password);
        }else{
            
            return  response()->json([
                "error"=> "not found"
            ],401);   

        }

        $token = $user->createToken("myapplicationtoken")->plainTextToken;
        // $token = $user->createToken("remember_token")->accessToken;

        $response = [
          "user"=>$user,
          "token"=>$token
        ];

        return response()->json($response); 
        
    }
    public function logout($request){

        // $user = Auth::user();

        auth()->user()->tokens()->delete(); 

        return response()->json([
            "message"=> "logged out"
        ]);    

    }

}
