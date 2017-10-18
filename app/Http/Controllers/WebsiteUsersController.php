<?php

namespace App\Http\Controllers;

use App\WebsiteUsers;
use Illuminate\Http\Request;
use App\Http\Requests\RegisterUserRequest;
use Log;

class WebsiteUsersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = WebsiteUsers::all();
        Log::info('GET ALL USERS');

        return view('users.all')->with('users', $users);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return '{status:"Route is not available to Front-End App"}';
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(RegisterUserRequest $request)
    {   
        $user = new WebsiteUsers;

        $user->first_name = $request->firstName;
        $user->last_name = $request->lastName;
        $user->email = $request->email;
        $user->password = $request->password;
        $user->timestamps();

        $user->save();
        Log::info('CREATED USER | '.$user->email.' | ');

        return '{"status":"registration success"}';
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\WebsiteUsers  $websiteUsers
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        Log::info('GET USER | '.$id.' | ');

        return WebsiteUsers::find($id);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\WebsiteUsers  $websiteUsers
     * @return \Illuminate\Http\Response
     */
    public function edit(WebsiteUsers $websiteUsers)
    {
        return '{"status":"Route is not available to Front-End App"}';
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\WebsiteUsers  $websiteUsers
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $user = WebsiteUsers::find($id);

        $user->first_name = $request->input('firstName') ? $request->input('firstName') : $user->first_name;
        $user->last_name = $request->input('lastName') ? $request->input('lastName') : $user->last_name;

        $user->save();
        Log::info('UPDATED USER | '.$id.' | ');

        return '{"status":"succcess"}';
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\WebsiteUsers  $websiteUsers
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        WebsiteUsers::destroy($id);
        Log::info('DELETED USER | '.$id.' | ');

        return '{"status":"success"}';
    }

    public function action(Request $request, $id)
    {
        $user = WebsiteUsers::find($id);

        if ($request['action'] === 'addVisitedCategory') {
            if (!$user->visited_categories) {
                $user->visited_categories = $request['value'];
            } else if (strrpos($user->visited_categories, $request['value']) === false) {
                $user->visited_categories = $user->visited_categories.'|'.$request['value'];
            } 
        } else if ($request['action'] === 'addVisitedTag') {
            if (!$user->visited_tags) {
                $user->visited_tags = $request['value'];
            } else if (strrpos($user->visited_tags, $request['value']) === false) {
                $user->visited_tags = $user->visited_tags.'|'.$request['value'];
            } 
        } else if ($request['action'] === 'addLikedCategory') {
            if (!$user->liked_categories) {
                $user->liked_categories = $request['value'];
            } else if (strrpos($user->liked_categories, $request['value']) === false) {
                $user->liked_categories = $user->liked_categories.'|'.$request['value'];
            } 
        } else if ($request['action'] === 'addLikedTag') {
            if (!$user->liked_tags) {
                $user->liked_tags = $request['value'];
            } else if (strrpos($user->liked_tags, $request['value']) === false) {
                $user->liked_tags = $user->liked_tags.'|'.$request['value'];
            } 
        } else if ($request['action'] === 'addTextToVisited') {
            if (!$user->visited_text_id) {
                $user->visited_text_id = $request['value'];
            } else if (strrpos($user->visited_text_id, $request['value']) === false) {
                $user->visited_text_id = $user->visited_text_id.'|'.$request['value'];
            } 
        } else {
            return '"status": "unknown action"';
        }

        Log::info('USER | '.$id.' | ACTION: | '.$request['action'].' |');


        $user->save();

        return '{"status":"success"}';
    }

    public function login(Request $request)
    {   
        Log::info('USER LOGIN  | '. $request->email.' |');
        $user = WebsiteUsers::where('email', $request['email'])->first();

        if (!$user) {
            return '{"status":"non existing user"}';
        }


        Log::info('USER LOGIN  | '.$user->email.' |');
        if ($user->password === $request->password) {
            return $user;
        } else {
            return '{"status":"wrong password"}';
        }
    }

    public function resetPassword(Request $request) {
        $user = WebsiteUsers::where('email', $request['email'])->first();
        if (!$user) {
            return '{"status":"non existing user"}';
        }

        $newPassword = $this->generateRandomString(10);
        
        $uppercase = preg_match('@[A-Z]@', $newPassword);
        $lowercase = preg_match('@[a-z]@', $newPassword);
        $number    = preg_match('@[0-9]@', $newPassword);

        while (!$uppercase || !$lowercase || !$number) {
            $newPassword = $this->generateRandomString(10);
            
            $uppercase = preg_match('@[A-Z]@', $newPassword);
            $lowercase = preg_match('@[a-z]@', $newPassword);
            $number    = preg_match('@[0-9]@', $newPassword);
        }
       
        $user->password = $newPassword;
        $user->save();
   
        Log::info('RESET PASSWORD  | '.$request['email'].' |');
        $this->sendResetPasswordEmail($request['email'], $newPassword);
        
        return '{"status":"new password"}';
    }

    private function generateRandomString($length = 10) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }

    private function sendResetPasswordEmail($email, $newPassword)
    {
        $to = $email;
        $subject = "Fitnes Zona - Resetovanje Lozinke";
        
        $message = "
        <html>
        <head>
        <title>Fitnes Zona - Resetovanje Lozinke</title>
        </head>
        <body>
        <h2>Fitnes Zona - Resetovanje Lozinke</h2>
        <p>Poštovani, Vaša nova lozinka je: </p>
        <h4>".$newPassword."</h4>
        <hr>
        <p>
            Srdačan Pozdrav, <br>
            <b>Vaša Fitnes Zona</b>
        </p>
        </body>
        </html>
        ";
        
        $headers = "MIME-Version: 1.0" . "\r\n";
        $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
        
        $headers .= 'From: <fitneszona.mail@gmail.com>' . "\r\n";
        
        mail($to,$subject,$message,$headers);
    }

    public function getUserSpecificData($id, $data) {
        $user = WebsiteUsers::find($id);

        return $user['data'];
    }
}
