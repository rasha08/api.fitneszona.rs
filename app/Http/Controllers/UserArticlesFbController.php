<?php

namespace App\Http\Controllers;

use App\userArticlesFb;
use Illuminate\Http\Request;

class UserArticlesFbController extends Controller
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
    public function store($userArtciclesData)
    {
        $userArticles = new userArticlesFb;
        $userArticles->id = $userArtciclesData['id'];
        $userArticles->top = $userArtciclesData['top'];
        $userArticles->latest = $userArtciclesData['latest'];
        $userArticles->index = $userArtciclesData['index'];
        $userArticles->save();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\userArticlesFb  $userArticlesFb
     * @return \Illuminate\Http\Response
     */
    public function show(userArticlesFb $userArticlesFb)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\userArticlesFb  $userArticlesFb
     * @return \Illuminate\Http\Response
     */
    public function edit(userArticlesFb $userArticlesFb)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\userArticlesFb  $userArticlesFb
     * @return \Illuminate\Http\Response
     */
    static public function update($userArtciclesData)
    {   
        $userArticles = userArticlesFb::find($userArtciclesData['user_id']);
        if ($userArticles->isEmpty()) {
            $this->create($userArtciclesData);
            
            return;
        }

        $userArticles->top = $userArtciclesData['top'];
        $userArticles->latest = $userArtciclesData['latest'];
        $userArticles->index = $userArtciclesData['index'];
        $userArticles->save();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\userArticlesFb  $userArticlesFb
     * @return \Illuminate\Http\Response
     */
    public function destroy(userArticlesFb $userArticlesFb)
    {
        //
    }
}
