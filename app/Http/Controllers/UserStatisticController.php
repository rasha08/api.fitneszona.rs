<?php

namespace App\Http\Controllers;

use App\UserStatistic;
use Illuminate\Http\Request;

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
}
