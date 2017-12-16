<?php

namespace App\Http\Controllers;

use App\Nortification;
use App\WebsiteUsers;
use Illuminate\Http\Request;
use App\Http\Controllers\UserShortMarketController;
use Illuminate\Support\Facades\Response;
use App\UserConfiguration;

use Log;

class NortificationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $users = WebsiteUsers::all();
        foreach ($users as $user) {
            $notification = new Nortification;
            $notification->user_id = $user->id;
            $notification->notification =  $request->input('text');
            $notification->title = $request->input('title');
            $notification->url = $request->input('url');
            $notification->seen = false;

            $notification->save();

            $update = [
                'type' => 'notification',
                'payload' => $notification
            ];

            UserShortMarketController::update($user->id, json_encode((object)$update));
        }

        Log::info('SENDING NOTIFICATION TO ALL USERS');
        return redirect(url('/users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $id)
    {
        $notification = new Nortification;
        $notification->user_id = $id;
        $notification->notification =  $request->input('text');
        $notification->title = $request->input('title');
        $notification->url = $request->input('url');
        $notification->seen = false;

        $notification->save();

        $update = [
            'type' => 'notification',
            'payload' => $notification
        ];

        UserShortMarketController::update($id, json_encode((object)$update));

        Log::info('SENDING NOTIFICATION TO USER | '.$id.' |');
        return redirect(url('/users'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Nortification  $nortification
     * @return \Illuminate\Http\Response
     */
    public function show(Nortification $nortification)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Nortification  $nortification
     * @return \Illuminate\Http\Response
     */
    public function edit(Nortification $nortification)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Nortification  $nortification
     * @return \Illuminate\Http\Response
     */
    public function update($id)
    {
        $notification = Nortification::find($id);
        $notification->seen = true;
        $notification->save();

        $response = (object)['status' => 'success'];

        return Response::json($response, 200, array('charset' => 'utf8'), JSON_UNESCAPED_UNICODE);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Nortification  $nortification
     * @return \Illuminate\Http\Response
     */
    public function destroy(Nortification $nortification)
    {
        //
    }

    public function getAllUserNotifications($id) {

        $notifications = Nortification::where('user_id', $id)
                            ->select(['id', 'title', 'notification', 'seen', 'created_at'])
                            ->orderBy('created_at', 'desc')
                            ->get();

        return Response::json($notifications, 200, array('charset' => 'utf8'), JSON_UNESCAPED_UNICODE);

    }

    static public function notifySubscribersOfNewArticleTags($themesArray = [], $title, $description, $image_url, $url) {
        $notifiedUsers = [];

        $formatedNoritficationText = '<p><p><img src="'.$image_url.'" /></p><p>'.$description.'</p></p>';
        $userSubscriptions = UserConfiguration::select('noritification_for_themes', 'user_id')->where('id', '>', 0)->get()->toArray();
       
        foreach ($userSubscriptions as $subscriber) {
            if(!empty($subscriber['noritification_for_themes'])) {
                foreach (json_decode($subscriber['noritification_for_themes']) as $subcribedTheme) {
                    if (in_array($subcribedTheme, $themesArray) && !in_array($subscriber['user_id'], $notifiedUsers)) {
                        $notification = new Nortification;
                        $notification->user_id = $subscriber['user_id'];
                        $notification->notification = $formatedNoritficationText;
                        $notification->title = $title;
                        $notification->url = $url;
                        $notification->seen = false;
        
                        $update = [
                            'type' => 'notification',
                            'payload' => $notification
                        ];
                
                        UserShortMarketController::update($subscriber['user_id'], json_encode((object)$update));
                
                        Log::info('SENDING NOTIFICATION TO USER | '.$subscriber['user_id'].' |');
                        array_push($notifiedUsers, $subscriber['user_id']);
                    }
                }
            }
        }
    }
}
