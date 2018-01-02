<?php

namespace App\Http\Controllers;

use App\UserStatistic;
use Illuminate\Http\Request;
use App\Http\Controllers\UserShortMarketController;

class UserStatisticController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return "ALL USERS STATS VIEW";
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return "SINGLE USER CREATE STATS VIEW";
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\UserStatistic  $userStatistic
     * @return \Illuminate\Http\Response
     */
    public function show(UserStatistic $userStatistic)
    {
        return "SINGLE USER STATS VIEW";
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\UserStatistic  $userStatistic
     * @return \Illuminate\Http\Response
     */
    public function edit(UserStatistic $userStatistic)
    {
        return "SINGLE USERS UPDATE STATS VIEW";
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\UserStatistic  $userStatistic
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, UserStatistic $userStatistic)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\UserStatistic  $userStatistic
     * @return \Illuminate\Http\Response
     */
    public function destroy(UserStatistic $userStatistic)
    {
        //
    }

    static public function updateUserData($data)
    {
        $userStats = UserStatistic::where('user_id', $data->uid)->get();
        if ($userStats->isEmpty()) {
            $userStats = new UserStatistic;
            $userStats->user_id = $data->uid;
        }

        foreach ($data->stats as $stat) {
            switch ($stat['statType']) {
                case 'last_visit_and_page':
                    $userStats['last_visit_and_page'] = json_encode($stat['statData']);
                    break;
                case 'number_of_visits_by_day':
                    if ($userStats['number_of_visits_by_day'] &&
                        $userStats['number_of_visits_by_day'][$stat['statData']]) {
                        $userStats['number_of_visits_by_day'][$stat['statData']] += 1;
                    } else {
                        $userStats['number_of_visits_by_day'][$stat['statData']] = 1;
                    }

                    break;
                case 'time_of_visits':
                    if ($userStats['time_of_visits']) {
                        array_push($userStats['time_of_visits'], $stat['statData']);
                    } else {
                        $userStats['time_of_visits'] = json_encode([$stat['statData']]);
                    }

                    break;
                case 'number_of_visits':
                    if ($userStats['lnumber_of_visits']) {
                        $userStats['lnumber_of_visits'] += 1;
                    } else {
                        $userStats['lnumber_of_visits'] = 1;
                    }

                    break;
                default:
                    if ($userStats[$stat['statType']]) {
                        if ($stat['statType'] === 'visited_tags') {
                            array_merge($userStats[$stat['statType']], $stat['statData']);
                        } else {
                            array_push($userStats[$stat['statType']], $stat['statData']);
                        }

                        $userStats[$stat['statType']] =
                            json_encode(array_unique($userStats[$stat['statType']]));
                    } else {
                        $userStats[$stat['statType']] = json_encode([$stat['statData']]);
                    }
                    break;
            }
        }

        $userStats->save();

        $update;
        $update['type'] = 'userStatistic';
        $update['payload'] = json_encode($userStats);

        UserShortMarketController::update($data->uid, json_encode((object)$update));
    }
}
