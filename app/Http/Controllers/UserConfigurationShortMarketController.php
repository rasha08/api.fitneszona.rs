<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\UserConfigurationShortMarket;


class UserConfigurationShortMarketController extends Controller
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
    static public function store($id)
    {
        $UserConfigurationShortMarket = new UserConfigurationShortMarket;
        $UserConfigurationShortMarket['user_id'] = $id;
        $UserConfigurationShortMarket['update'] = 'update';
        $UserConfigurationShortMarket->save();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    static public function update($id, $update)
    {
        $UserConfigurationShortMarket = UserConfigurationShortMarket::where('user_id', $id)->first();
        $UserConfigurationShortMarket['update'] = json_encode($update);
        $UserConfigurationShortMarket->save();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    static public function destroy($id)
    {
        UserConfigurationShortMarket::where('user_id', $id)->delete();
    }

    static private function generateRandomString($length = 2) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }

    static public function getSubscriptionId($id)
    {
        return UserConfigurationShortMarket::where('user_id', $id)->value('id');
    }
}
