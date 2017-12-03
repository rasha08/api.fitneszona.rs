<?php

namespace App\Http\Controllers;

use App\UserShortMarket;
use Illuminate\Http\Request;

class UserShortMarketController extends Controller
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
        $UserShortMarket = new UserShortMarket;
        $UserShortMarket['user_id'] = $id;
        $UserShortMarket['update'] = 'update';
        $UserShortMarket->save();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\ArticlesShortMarket  $articlesShortMarket
     * @return \Illuminate\Http\Response
     */
    public function show(UserShortMarket $articlesShortMarket)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\ArticlesShortMarket  $articlesShortMarket
     * @return \Illuminate\Http\Response
     */
    public function edit(UserShortMarket $articlesShortMarket)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\ArticlesShortMarket  $articlesShortMarket
     * @return \Illuminate\Http\Response
     */
    static public function update($id)
    {
        $UserShortMarket = UserShortMarket::where('user_id', $id)->first();
        $UserShortMarket['update'] = self::generateRandomString();
        $UserShortMarket->save();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\ArticlesShortMarket  $articlesShortMarket
     * @return \Illuminate\Http\Response
     */
    static public function destroy($id)
    {
        UserShortMarket::where('user_id', $id)->delete();
    }

    static private function generateRandomString($length = 5) {
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
        return UserShortMarket::where('user_id', $id)->value('id');
    }
}
