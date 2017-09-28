<?php

namespace App\Http\Controllers;

use App\WebsiteUsers;
use Illuminate\Http\Request;
use App\Http\Requests\RegisterUserRequest;

class WebsiteUsersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return '{status:"Route is not available to Front-End App"}';
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
        $user->password = bcrypt($request->password);
        $user->timestamps();

        $user->save();

        return '{status:"success"}';
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\WebsiteUsers  $websiteUsers
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

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
        return '{status:"Route is not available to Front-End App"}';
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

        return '{status:"succcess"}';
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

        return '{status:"success"}';
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
        } else {
            return 'status: "unknown action"';
        }


        $user->save();

        return '{status:"success"}';
    }

    public function login(Request $request)
    {
        $user = WebsiteUsers::where('email', $request('email'))->first();

        if (!$user) {
            return '{status:"not existing user}';
        }

        if ($user->password === bcrypt($request->password)) {
            return '{status:"success"}';
        } else {
            return '{status:"wrong password"}';
        }
    }
}
