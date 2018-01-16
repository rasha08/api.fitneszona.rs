<?php

namespace App\Http\Controllers;

use App\UserConfiguration;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use App\Http\Controllers\UserConfigurationShortMarketController;
use App\WebsiteUsers;

use Log;

class UserConfigurationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $id)
    {
        if (!WebsiteUsers::find($id)) {
            $response = (object)['status' => 'non existing user'];
            return Response::json($response, 200, array('charset' => 'utf8'), JSON_UNESCAPED_UNICODE);
        }

        $userConfiguration = UserConfiguration::where('user_id', $id)->first();
        if ($userConfiguration) {
           return self::update($request, $id);
        } 

        $userConfiguration = new UserConfiguration;
        $userConfiguration->user_id = $id;
        $userConfiguration->thema = $request['thema'] ?: NULL;
        $userConfiguration->categories_in_navigation = json_encode($request['categoriesInNavigation']) ?: NULL;
        $userConfiguration->number_of_texts_in_left_sidebar = $request['numberOfTextsInLeftSidebar'] ?: NULL;
        $userConfiguration->noritification_for_themes = json_encode($request['noritificationForThemes']) ?: NULL;
        $userConfiguration->save();

        UserConfigurationShortMarketController::store( $id);
        
        Log::info('SAVED USER CONFIGURATION FOR USER: | '. $id.' |');
       
        $response = (object)['status' => 'Configuration successfully created'];
        return Response::json($response, 200, array('charset' => 'utf8'), JSON_UNESCAPED_UNICODE);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\UserConfiguration  $userConfiguration
     * @return \Illuminate\Http\Response
     */
    static public function show($id)
    {
        $userConfiguration = UserConfiguration::where('user_id', $id)->first();
        if ($userConfiguration) {
            $userConfiguration['subscriptionId'] = UserConfigurationShortMarketController::getSubscriptionId($id);
            unset($userConfiguration['id']);
            unset($userConfiguration['user_id']);
            unset($userConfiguration['created_at']);
            unset($userConfiguration['updated_at']);

            return $userConfiguration;
        } 

        return (object)[];

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\UserConfiguration  $userConfiguration
     * @return \Illuminate\Http\Response
     */
    public function edit(UserConfiguration $userConfiguration)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\UserConfiguration  $userConfiguration
     * @return \Illuminate\Http\Response
     */
    static public function update(Request $request, $id)
    {
        Log::info($request);
        
        $userConfiguration = UserConfiguration::where('user_id', $id)->first();
        $userConfiguration->thema = $request['thema'] ?:  $userConfiguration->thema;
        $userConfiguration->categories_in_navigation = json_encode($request['categoriesInNavigation']) ?: $userConfiguration->categories_in_navigation;
        $userConfiguration->number_of_texts_in_left_sidebar = $request['numberOfTextsInLeftSidebar'] ?: $userConfiguration->number_of_texts_in_left_sidebar;
        $userConfiguration->noritification_for_themes = json_encode($request['noritificationForThemes']) ?: $userConfiguration->noritification_for_themes;
        $userConfiguration->save();

        UserConfigurationShortMarketController::update($id, UserConfiguration::where('user_id', $id)->first());
        
        Log::info('UPDATED USER CONFIGURATION FOR USER: | '. $id.' |');
       
        $response = (object)['status' => 'Configuration successfully updated'];
        return Response::json($response, 200, array('charset' => 'utf8'), JSON_UNESCAPED_UNICODE);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\UserConfiguration  $userConfiguration
     * @return \Illuminate\Http\Response
     */
    public function destroy(UserConfiguration $userConfiguration)
    {
        //
    }
}
