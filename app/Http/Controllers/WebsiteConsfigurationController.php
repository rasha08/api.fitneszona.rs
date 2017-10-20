<?php

namespace App\Http\Controllers;

use App\WebsiteConsfiguration;
use Illuminate\Http\Request;
use Log;

class WebsiteConsfigurationController extends Controller
{   
    public $validHomePageChoices = [
        'landing',
        'articles',
        'latest articles',
        'top articles',
        'trening',
        'ishrana',
        'grupni treninzi',
        'saveti',
        'yoga',
        'crossfit',
        'trcanje',
        'mrsavljenje'
    ];

    private $validThemes = ['light', 'dark', 'urban', 'roboto', 'art'];


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return '{status:"Route is not available"}';
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return '{status:"Route is not available"}';
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {   
        return '{status:"Route is not available"}';
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\WebsiteConsfiguration  $websiteConsfiguration
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return '{status:"Route is not available"}';
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\WebsiteConsfiguration  $websiteConsfiguration
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $configuration = WebsiteConsfiguration::find($id);

        $data = [
            'configuration' => $configuration,
            'validHomePageChoices' => $this->validHomePageChoices,
            'validThemes' => $this->validThemes
        ];

        return view('configuration.configuration')->with('data', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\WebsiteConsfiguration  $websiteConsfiguration
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $configuration = WebsiteConsfiguration::find($id);

        $configuration->home_page = $request->input('home_page');
        $configuration->theme = $request->input('theme');
        $configuration->is_registration_enabled = $request->input('is_registration_enabled') ? true : false;
        $configuration->is_login_enabled = $request->input('is_login_enabled') ? true : false;
        $configuration->banner_image_url = $request->input('banner_image_url');
        $configuration->number_of_articles_in_sidebar = $request->input('number_of_articles_in_sidebar');
        $configuration->is_landing_page_enabled = $request->input('is_landing_page_enabled') ? true : false;
        $configuration->is_chat_bot_enabled = $request->input('is_chat_bot_enabled') ? true : false;
        $configuration->is_google_map_enabled = $request->input('is_google_map_enabled') ? true : false;
        $configuration->banner_text = $request->input('banner_text') ? 
            $request->input('banner_text') : $configuration->banner_text;
        $configuration->about_us = $request->input('about_us') ? 
            $request->input('about_us') : $configuration->about_us;
        $configuration->is_fitness_creator_enabled = $request->input('is_fitness_creator_enabled') ? true : false;
        $configuration->text_for_email_response = $request->input('text_for_email_response') ? 
            $request->input('text_for_email_response') : $configuration->text_for_email_response;

        $configuration->save();

        $data = [
            'configuration' => $configuration,
            'validHomePageChoices' => $this->validHomePageChoices,
            'validThemes' => $this->validThemes,
            'status' => 'Success'
        ];
        Log::info('CONFIGURATION UPDATED');

        return redirect('/configuration/'.$id.'/edit')->with('data', $data);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\WebsiteConsfiguration  $websiteConsfiguration
     * @return \Illuminate\Http\Response
     */
    public function getConfiguration($id)
    {
        Log::info('GET CONFIGURATION FOR WEBSITE ID: | '.$id.' |');

        return WebsiteConsfiguration::find($id);
    }

    public function getActiveCategories($id)
    {
        return $this->validHomePageChoices;
    }
}
