<?php

namespace App\Http\Controllers;

use App\UserStatistic;
use Illuminate\Http\Request;
use App\Http\Controllers\UserShortMarketController;
use Log;

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

    static public function get($userId, $prop)
    {
        $result = UserStatistic::where('user_id', $userId)->select($prop)->first();

        return $result ? json_decode($result->toArray()[$prop]) : [];
    }

    static public function set($userId, $prop, $value)
    {
        return UserStatistic::where('user_id', $userId)->update([$prop => json_encode((array)$value)]);
    }

    static public function updateUserData($data)
    {
        Log::info('UPDATING STATISTIC FOR USER | '. $data->uid . ' |');

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
                    if ($userStats['number_of_visits']) {
                        $userStats['number_of_visits'] += 1;
                    } else {
                        $userStats['number_of_visits'] = 1;
                    }

                    break;
                default:
                // dd(json_encode(self::get($data->uid, $stat['statType'])));
                    if (!self::get($data->uid, $stat['statType'])) {
                        if ($stat['statType'] === 'visited_tags') {
                            self::set($data->uid, $stat['statType'], (array)$stat['statData']);
                        } else {
                            self::set($data->uid, $stat['statType'], (array)[$stat['statData']]);
                        }
                    } else {
                        if ($stat['statType'] === 'visited_tags') {
                            break;
                        } else {
                            $result = self::get($data->uid, $stat['statType']);
                           array_push($result, $stat['statData']);
                        }
                        $result = array_unique($result);
                        self::set($data->uid, $stat['statType'], (array)$result);
                    }
                break;
            }
        }

        $user =  method_exists($userStats, 'save') ?  $userStats->save() : null;

        $update;
        $update['type'] = 'userStatistic';
        $update['payload'] = json_encode($userStats);

        Log::info('STATISTIC FOR USER | '. $data->uid . ' | UPDATED');

        UserShortMarketController::update($data->uid, json_encode((object)$update));
    }
}
