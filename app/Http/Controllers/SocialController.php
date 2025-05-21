<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Exception;
use App\Models\User;
use Crypt;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class SocialController extends Controller

{

   public function redirectFacebook()
    {
        return Socialite::driver('facebook')->redirect();
    }



    public function facebookCallback()
    {
        try {
        
            $user = Socialite::driver('facebook')->user();
         	//dd($user);
            $finduser = User::where('social_id', $user->id)->first();
        
            if($finduser){
         
                Auth::login($finduser);
        
                return redirect()->intended('home');
         
            }else{
                $newUser = User::create([
                    'name' => $user->name,
                    'firstname' => null,
                    'email' => $user->email,
                    'social_id'=> $user->id,
                    'password' => encrypt('Test123456')
                ]);
                 $newUser->assignRole('Bénévole');   
        
        		//dd($newUser);
                Auth::login($newUser);
	                if(!$newUser->phone)
	                {
	                	return redirect()->route('users.edit',['user'=>Crypt::encrypt($newUser->id)]); 
	                }
	                else {
	                	return redirect()->intended('home'); 
					}
            }
        
        } catch (Exception $e) {
            dd($e->getMessage());
        }
    }
    
    
    public function redirectGoogle()

    {

        return Socialite::driver('google')->redirect();

    }

          

    /**

     * Create a new controller instance.

     *

     * @return void

     */

    public function googleCallback()
    {
        try {
        
            $user = Socialite::driver('google')->user();
        	//dd($user);
            $finduser = User::where('social_id', $user->id)->first();
         
            if($finduser){
         
                Auth::login($finduser);
        
                return redirect()->intended('home');
         
            }else{
                $newUser = User::updateOrCreate(['email' => $user->email],[
                        'name' => $user->user['family_name'],
                        'firstname' => $user->user['given_name'],
                        'social_id'=> $user->id,
                        'password' => encrypt('Xr58g!r*654')
                    ]);
                 $newUser->assignRole('Bénévole');   
         
                Auth::login($newUser);
	                if(!$newUser->phone)
	                {
	                	return redirect()->route('users.edit',['user'=>Crypt::encrypt($newUser->id)]); 
	                }
	                else {
	                	return redirect()->intended('home'); 
					}
            }
        
        } catch (Exception $e) {
            dd($e->getMessage());
        }

    }
    
    
    
    
    
    
}