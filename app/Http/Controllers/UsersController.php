<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Hash;
use Session;
use Validator;
use Redirect;
use App\Http\Requests;
use Illuminate\Support\MessageBag;

class UsersController extends Controller
{
	//function to check whether the login credentials are correct or not. If correct, direct them according to whether they are admin users or regualr users
    public function verify_login(Request $request)
    {
        //fetch valued from db of the particular username
    	$result = DB::table('users')->where('username', $request->username)->first();
        //flash username back incase of faulty login
        $request->flashOnly('username');
    	//if either no username found or password doesnt match return an error
    	if(count($result)==0 || !(Hash::check($request->password, $result->password)))
    		return redirect('/')->with('errors','Username and password does not match.');
    	else
    	{	
    		//register the user's session
    		Session::put('user', $result->username);
    		Session::put('id',$result->id);
    		//take him to the admin route or the user route based on the value
    		$id = $result->id;

    		if($result->admin_user==1)
    		{
    			return redirect()->to('users/admin/'.$id);
    		}
    		else
    		{
    			return redirect()->to('users/normal/'.$id);
    		}
    	}

    	
    }

    //function to verify registration credentials of a user and add him if correct
    public function verify_register(Request $request)
    {
            //get the particular username to check whether one exists previously
    		$checker = DB::table('users')->where('username',$request->uname)->get();
            $request->flashOnly('name','uname');
    		if(count($checker)!=0)	//means the username already exists and we need to return back with errors
    		{
    			
    			return redirect('/')->with('errors','Username already exists.');
    		}
    		else
    		{
                //hash the password to add to the DB
                $request->pass = Hash::make($request->pass);
    			if($request["user_type"])
    				$user_type =  1;
    			else
    				$user_type = 0;

    			$name = $request->name;
    			$username = $request->uname;
    			$password = $request->pass;

                //add him to the users table
    			$result = DB::table('users')->insert(
    					['name'=>$name, 'username'=>$username, 'password'=>$password, 'admin_user'=>$user_type]
    				);
    			if($result)	//redirect user to login page to continue
    			{
    				
    				return redirect('/')->with('success','Registered successfully. Please login to continue.');
    			} 
    			
    		}	
    		
    	
    	
    }

    //function shows the list of all normal users to admin users
    public function show($id)
    {
        //if the user tries to access protected route, LOG HIM OUT !! 
        if(Session::get('id')!=$id)
        {
            Session::flush();
            return redirect()->to('/');
        }

    	$user_list = DB::table('users')->where('admin_user', 0)->get();		//get a list of all normal users to send it to the view
        //get notification count to display on apge
    	$notif_count = DB::table('notifications')->where('sender',Session::get('user'))->count();
    	$user_count = count($user_list);
    	$errors ="";
    	$success="";
    	return view('admin_display', ['user_list'=>json_encode($user_list), 'user_count'=>$user_count, 'errors'=>$errors, 'success'=>$success, 'notif_count'=>$notif_count]);	//this is the home page for admin users
    }

    //when logging out, flush the session and redirect to home
    public function logout()
    {
        Session::flush();
        return redirect()->to('/');
    }
}
