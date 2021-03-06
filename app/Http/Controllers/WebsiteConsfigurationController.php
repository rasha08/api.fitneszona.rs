<?php

namespace App\Http\Controllers;

use App\WebsiteConsfiguration;
use Illuminate\Http\Request;
use App\Http\Controllers\ArticlesController;
use Illuminate\Support\Facades\Response;
use App\Http\Controllers\ConfigurationShortMarketController;
use App\CacheModel;

use Log;

class WebsiteConsfigurationController extends Controller
{
    public $validHomePageChoices = [
        'articles',
        'latest_articles',
        'top_articles',
        'trening',
        'ishrana',
        'grupni_treninzi',
        'saveti',
        'yoga',
        'crossfit',
        'trcanje',
        'mrsavljenje',
        'power_lifting'
    ];

    private $validThemes = ['light', 'dark', 'winter', 'nature', 'metal', 'art'];


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return '{"status":"Route is not available"}';
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return '{"status":"Route is not available"}';
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        return '{"status":"Route is not available"}';
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\WebsiteConsfiguration  $websiteConsfiguration
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return '{"status":"Route is not available"}';
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
        $activeCategories = explode('|', $configuration->active_categories);

        $data = [
            'configuration' => $configuration,
            'validHomePageChoices' => $this->validHomePageChoices,
            'activeCategories' => $activeCategories ? $activeCategories : $validHomePageChoices,
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
        $configuration->banner_title = $request->input('banner_title') ? true : false;
        $configuration->banner_title = $request->input('banner_title') ?
        $request->input('banner_title') : $configuration->banner_title;
        $configuration->banner_text = $request->input('banner_text') ?
            $request->input('banner_text') : $configuration->banner_text;
        $configuration->about_us = $request->input('about_us') ?
            $request->input('about_us') : $configuration->about_us;
        $configuration->is_fitness_creator_enabled = $request->input('is_fitness_creator_enabled') ? true : false;
        $configuration->text_for_email_response = $request->input('text_for_email_response') ?
            $request->input('text_for_email_response') : $configuration->text_for_email_response;

        $activeCategories = '';
        foreach ($this->validHomePageChoices as $category) {
            if ($request->input($category)) {
                $activeCategories .= $category.'|';
            }
        }

        $activeCategories = substr($activeCategories, 0, -1);
        $configuration->active_categories = $activeCategories;

        $sortedValidTags = ArticlesController::getValidArticleTags();
        $tagsPriorityList = '';

        foreach ($sortedValidTags as $tag) {
            $tagsPriorityList .= $tag['name'].'|';
        }

        $tagsPriorityList = substr($tagsPriorityList, 0, -1);
        $configuration['tags_priority_list'] = $tagsPriorityList;


        $configuration->save();

        $this-> createConfigurationCache($id);

        $activeCategories = explode('|', $activeCategories);

        $data = [
            'configuration' => $configuration,
            'validHomePageChoices' => $this->validHomePageChoices,
            'validThemes' => $this->validThemes,
            'activeCategories' => $activeCategories,
            'status' => 'success'
        ];
        Log::info('CONFIGURATION UPDATED FOR WEBSITE | '.$id.' |');
        ConfigurationShortMarketController::update($id);

        return redirect('/configuration/'.$id.'/edit')->with('data', $data);
    }

    public function createConfigurationCache($id = 1)
    {
        $configurationCache = WebsiteConsfiguration::find($id);

        $configurationCache->active_categories = $this->getFullActiveCategoryObjects(explode('|', $configurationCache->active_categories));
        $configurationCache->tags_priority_list = explode('|', $configurationCache->tags_priority_list);
        $configurationCache['subscriptionId'] = ConfigurationShortMarketController::getSubscriptionId($id);
        $configurationCache['validThemeOptions'] = $this->validThemes;

        if (empty(CacheModel::where('key', 'websiteConfiguration')->first())) {
            $cache = new CacheModel;
            $cache['key'] = 'websiteConfiguration';
            $cache['value'] = json_encode($configurationCache);
            $cache->save();
        } else {
            CacheModel::where('key', 'websiteConfiguration')->update(['value' => json_encode($configurationCache)]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\WebsiteConsfiguration  $websiteConsfiguration
     * @return \Illuminate\Http\Response
     */
    public function getConfiguration($id)
    {
        return CacheModel::where('key', 'websiteConfiguration')
                         ->select(['value'])
                         ->first()['value'];
    }

    public function getActiveCategories($id)
    {

        try {
            $configuration = WebsiteConsfiguration::find($id);
        } catch (\Illuminate\Database\QueryException $e) {
            return "{'status':'configuration not found'}";
        }
        $configuration = WebsiteConsfiguration::find($id);

        $activeCategories = explode('|', $configuration->active_categories);

        Log::info('ACTIVE CATEGORIES FETCHED FOR WEBSITE | '.$id.' |');

        return json_encode((object)['activeCategories' => $activeCategories]);
    }

    public function getTagsPriority($id)
    {

        try {
            $configuration = WebsiteConsfiguration::find($id);
        } catch (\Illuminate\Database\QueryException $e) {
            return "{'status':'configuration not found'}";
        }
        $configuration = WebsiteConsfiguration::find($id);

        $tagsPriorityList = explode('|', $configuration->tags_priority_list);

        Log::info('TAGS PRIORITY LIST FETCHED FOR WEBSITE | '.$id.' |');

        return Response::json((object)['tagsPriorityList' => $tagsPriorityList], 200, array('charset' => 'utf8'), JSON_UNESCAPED_UNICODE);
    }

    static public function refreshTagsPriorityList($id) {
        $configuration = WebsiteConsfiguration::find($id);
        $sortedValidTags = ArticlesController::getValidArticleTags();
        $tagsPriorityList = '';

        foreach ($sortedValidTags as $tag) {
            $tagsPriorityList .= $tag['name'].'|';
        }

        $tagsPriorityList = substr($tagsPriorityList, 0, -1);
        $configuration['tags_priority_list'] = $tagsPriorityList;

        Log::info('REFRESHING TAGS PRIORITY LIST FOR WEBSITE | '.$id.' |');
        $configuration->save();
    }

    private function getFullActiveCategoryObjects($categories)
    {
        $fullActiveCategoriesMarkets = [];
        foreach ($categories as $category) {
            $fullMarket = [];
            switch ($category) {
                case 'power_lifting':
                    $fullMarket['name'] = 'Power Liftting';
                    $fullMarket['urlSlug'] = 'power-lifting';
                    $fullMarket['category'] = 'power';
                    break;
                case 'grupni_treninzi':
                    $fullMarket['name'] = 'Grupni Treninzi';
                    $fullMarket['urlSlug'] = 'grupni-treninzi';
                    $fullMarket['category'] = 'grupni';
                    break;
                case 'articles':
                    $fullMarket['name'] = 'Svi Tekstovi';
                    $fullMarket['urlSlug'] = 'svi-tekstovi';
                    $fullMarket['category'] = $category;
                    break;
                case 'latest_articles':
                    $fullMarket['name'] = 'Najnoviji Tekstovi';
                    $fullMarket['urlSlug'] = 'najnoviji-tekstovi';
                    $fullMarket['category'] = $category;
                    break;
                case 'top_articles':
                    $fullMarket['name'] = 'Najčitaniji Tekstovi';
                    $fullMarket['urlSlug'] = 'najcitaniji-tekstovi';
                    $fullMarket['category'] = $category;
                    break;
                default:
                    $fullMarket['name'] = ucfirst($category);
                    $fullMarket['urlSlug'] = $category;
                    $fullMarket['category'] = $category;
                    break;
            }

            array_push($fullActiveCategoriesMarkets, (object)$fullMarket);

        }

        return $fullActiveCategoriesMarkets;
    }

}
