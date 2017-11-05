<?php

namespace App\Http\Controllers;

use App\ArticlesShortMarket;
use Illuminate\Http\Request;

class ArticlesShortMarketController extends Controller
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
        $articleFB = new ArticlesShortMarket;
        $articleFB['text_id'] = $id;
        $articleFB['update'] = 'update';
        $articleFB->save();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\ArticlesShortMarket  $articlesShortMarket
     * @return \Illuminate\Http\Response
     */
    public function show(ArticlesShortMarket $articlesShortMarket)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\ArticlesShortMarket  $articlesShortMarket
     * @return \Illuminate\Http\Response
     */
    public function edit(ArticlesShortMarket $articlesShortMarket)
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
        $articleFB = ArticlesShortMarket::where('text_id', $id)->first();
        $articleFB['text_id'] = $id;
        $articleFB['update'] = self::generateRandomString();
        $articleFB->save();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\ArticlesShortMarket  $articlesShortMarket
     * @return \Illuminate\Http\Response
     */
    static public function destroy($id)
    {
        $articleFB = ArticlesShortMarket::where('text_id', $id)->delete();
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
        return ArticlesShortMarket::where('text_id', $id)->value('id');
    }
}
