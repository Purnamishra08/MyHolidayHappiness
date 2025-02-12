<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Hash;
use DB;

class UserController extends Controller
{
    public function __construct()
    {
       // $this->middleware('auth');
    }
    public function getMetaDataForReport(Request $request){
         $input=$request->all();
         $user=User::find($input['user_id']);

        return ['status'=>true,'users'=> $users];
    }
    
    public function getSearchResults(Request $request){
        $input=$request->all();

        if($input['type']=='all'){
            $results=User::where(function ($query) use ($input) {
                        $query->where('email', 'like', '%'.$input['input'].'%')
                          ->orWhere('name', 'like', '%'.$input['input'].'%')
                          ->orWhere('phone_number', 'like', '%'.$input['input'].'%');
                })->select(DB::Raw('* , \'users\' as resultType'))->get()->toArray();

            
        }
        
        
        return ['status'=>true,'results'=>$results];
    }
    public function tryLogin(Request $request){
        $credentials = $request->only('email', 'password');
         if (Auth::attempt($credentials)) {
              return ['status'=>true,'userId'=>Auth::Id()];
        }

        return ['status'=>false];

    }
    public function getUserDetails(Request $request){
        $user=User::find($request->all()['id']);

         if(isset($user['id'])){
       

            return ['status'=>true,'message'=>'User found','user_details'=>$user];
        }

        return ['status'=>false,'message'=>'User not found','user_details'=>[]];


    }

    public function getUserDetailsForEdit(Request $request){
        $user=User::find($request->all()['id']);

        if(isset($user['id'])){
          



            return [
                    'status'=>true,
                    'message'=>'User found',
                    'user_details'=>$user,
                ];
        }

        return ['status'=>false,'message'=>'User not found','user_details'=>[]];


    }

    public function getUsers(Request $request){
        $users=User::get();

        $users->map(function($user){
          

        });

        return ['status'=>true,'users'=>$users];


    }


    public function updateResume(Request $request){
        $input=$request->all();
        
        $candidate_details=CandidateDetail::find($input['candidate_id']);
        if($request->hasFile('resume') && $request->file('resume')){
            $image = $request->file('resume');
            $filenamewithextension = $image->getClientOriginalName();
            $filename = pathinfo($filenamewithextension, PATHINFO_FILENAME);
            $extension = $image->getClientOriginalExtension();
            $randname=time().''.mt_rand(10000, 20000);
            $filenametostore = $filename.'_'.$randname.'.'.$extension;
            $destinationPath = public_path('/uploads/resume');
            $image->move($destinationPath, $filenametostore);
            $candidate_details->resume= '/uploads/resume/'.$filenametostore;
            $candidate_details->save();
        }
        return ['status'=>true,'file'=>$candidate_details->resume];
    }

    public function updateUserDetails(Request $request){

        $input=$request->all();

        //User 
        $UserWithEmail=User::where('email',$input['email'])->first();
        if($UserWithEmail && $UserWithEmail['id']!=$input['id']){
            return ['status'=>false, 'message'=>'User exists with given email ID'];
        }   
        $user=User::find($input['id']);
        $user->name=$input['name'];
        $user->email=$input['email'];
        
        $user->phone=$input['phone'];
        
        if(isset($input['password'])){
           $user->password=Hash::make($input['password']); 
        }
        
        $user->save();

       


        


        return ['status'=>true];


    }
    
    public function saveUserDetails(Request $request){

        $input=$request->all();

        //User 
        $UserWithEmail=User::where('email',$input['email'])->first();
        if($UserWithEmail){
            return ['status'=>false , 'message'=>'User exists with given email ID'];
        } 
        $user=new User;
        $user->name=$input['name'];
        $user->email=$input['email'];
        
        $user->phone=$input['phone'];
        
        $user->password=Hash::make($input['password']);
       
        $user->save();

        return ['status'=>true];


    }
    public function removeUsers(Request $request){
        $input=$request->all();
        $user=User::find($input['id']);

        User::where('id',$input['id'])->delete();

        $users=User::get();

        $users->map(function($user){
          

        });

        return ['status'=>true,'users'=>$users];

    }
}
