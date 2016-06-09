<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Session;
use DateTime;
use App\Http\Requests;

class NotifController extends Controller
{

    //function to render display of default page of normal users that display list of all received notifications
    public function show($id)
    {
        //if user tries to access restricted route, LOG HIM OUT ! 
        if(Session::get('id')!=$id)
        {
            Session::flush();
            return redirect()->to('/');
        }
        $notif_list = DB::table('notifications')->where('receiver', Session::get('user'))->get();     //get a list of all notifications sent to this user
        $notif_count = count($notif_list);
        return view('normal_display', ['notif_list'=>json_encode($notif_list), 'notif_count'=>$notif_count]);   //this is the home page for normal users users	
    }


    //function to send a notification from an admin user to a regular user
    public function send(Request $request, $id)
    {
        //If user tries to access protected route, LOG HIM OUT! 
        if(Session::get('id')!=$id)
        {
            Session::flush();
            return redirect()->to('/');
        }
    	$errors = "";
    	$success = "";

        //message cannot be empty
    	if(empty($request->message))
    	{
    		$errors.= "The message string cant be empty";
    		return redirect('users/admin/'.$id)->with('errors',$errors);
    	}

        //for all normal users, if the checkbox is selected, send him a notification
    	$users = DB::table('users')->where('admin_user',0)->get();
    	$atleast_one = 0;
    	foreach($users as $user)
    	{
    		if($request->has($user->username))
    		{	
    			$atleast_one = 1;    //variable to check whether atleast one recipeine t is selcted or not
    			$sender = Session::get('user');
    			$receiver = $user->username;
    			$data = $request->message;
    			$time = new DateTime();
    			DB::table('notifications')->insert(
    				['sender'=>$sender, 'receiver'=>$receiver, 'data'=>$data, 'time'=>$time]
    				);
    		}
    	}
        //if no user was selected prompt an error
        if($atleast_one==0)
        {
            return redirect('users/admin/'.$id)->with('errors','Please select atleast one recipient.');
        }
        //else success
    	return redirect('users/admin/'.$id)->with('success','Message sent.');
    }

   
    //displays the history of all notifications to the admin user
    public function history($id)
    {
        //if user tries to access protected route, LOG HIM OUT! 
        if(Session::get('id')!=$id)
        {
            Session::flush();
            return redirect()->to('/');
        }
    	$user_count = DB::table('users')->where('admin_user', 0)->count();		//get a list of all normal users to send it to the view
    	$notif_count = DB::table('notifications')->where('sender',Session::get('user'))->count();
    	$notif_list = DB::table('notifications')->where('sender',Session::get('user'))->get();
    	
    	return view('admin_history', ['user_count'=>$user_count, 'notif_count'=>$notif_count, 'notif_list'=>json_encode($notif_list)]);
    }
}
