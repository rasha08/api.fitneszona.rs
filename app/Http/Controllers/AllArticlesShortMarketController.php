<?php

namespace App\Http\Controllers;

use App\AllArticlesShortMarket;
use Illuminate\Http\Request;

class AllArticlesShortMarketController extends Controller
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
    static public function create($top, $latest, $index)
    {
        $allArticlesShortMarket = new AllArticlesShortMarket;
        $allArticlesShortMarket['update'] = json_encode(
            [
                'type' => 'update',
                'payload' => ''
            ]
        );
        $allArticlesShortMarket['top'] = json_encode($top);
        $allArticlesShortMarket['latest'] = json_encode($latest);
        $allArticlesShortMarket['index'] = json_encode($index);
        $allArticlesShortMarket->save();
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
     * @param  \App\AllArticlesShortMarket  $allArticlesShortMarket
     * @return \Illuminate\Http\Response
     */
    public function show(AllArticlesShortMarket $allArticlesShortMarket)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\AllArticlesShortMarket  $allArticlesShortMarket
     * @return \Illuminate\Http\Response
     */
    public function edit(AllArticlesShortMarket $allArticlesShortMarket)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\AllArticlesShortMarket  $allArticlesShortMarket
     * @return \Illuminate\Http\Response
     */
    static public function update($top, $latest, $index, $update)
    {
        $allArticlesShortMarket = AllArticlesShortMarket::find(1);
        $allArticlesShortMarket['update'] = json_encode($update);
        $allArticlesShortMarket['top'] = json_encode($top);
        $allArticlesShortMarket['latest'] = json_encode($latest);
        $allArticlesShortMarket['index'] = json_encode($index);
        $allArticlesShortMarket->save();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\AllArticlesShortMarket  $allArticlesShortMarket
     * @return \Illuminate\Http\Response
     */
    public function destroy(AllArticlesShortMarket $allArticlesShortMarket)
    {
        //
    }
}
