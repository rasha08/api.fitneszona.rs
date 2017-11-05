<?php

namespace App\Http\Controllers;

use App\ConfigurationShortMarket;
use Illuminate\Http\Request;

class ConfigurationShortMarketController extends Controller
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
        $ConfigurationShortMarket = new ConfigurationShortMarket;
        $ConfigurationShortMarket['configuration_id'] = $id;
        $ConfigurationShortMarket['update'] = 'update';
        $ConfigurationShortMarket->save();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\ArticlesShortMarket  $articlesShortMarket
     * @return \Illuminate\Http\Response
     */
    public function show(ConfigurationShortMarket $articlesShortMarket)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\ArticlesShortMarket  $articlesShortMarket
     * @return \Illuminate\Http\Response
     */
    public function edit(ConfigurationShortMarket $articlesShortMarket)
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
        $ConfigurationShortMarket = ConfigurationShortMarket::where('configuration_id', $id)->first();
        $ConfigurationShortMarket['configuration_id'] = $id;
        $ConfigurationShortMarket['update'] = self::generateRandomString();
        $ConfigurationShortMarket->save();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\ArticlesShortMarket  $articlesShortMarket
     * @return \Illuminate\Http\Response
     */
    static public function destroy($id)
    {
        ConfigurationShortMarket::where('configuration_id', $id)->delete();
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
        return ConfigurationShortMarket::where('configuration_id', $id)->value('id');
    }
}
