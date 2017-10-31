<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Articles;
use Illuminate\Support\Facades\Response;
use App\Comment;
use App\Like;
use App\DisLike;
use App\WebsiteUsers;
use Log;
use App\Http\Controllers\ArticlesController;
use App\Http\Controllers\WebsiteUsersController;


class SearchController extends Controller
{
    private $articles;
    private $categories;
    
    public function __construct() {
        $this->articles = Articles::where('id', '>', 0)
            ->select('title', 'category', 'tags', 'article_title_url_slug', 'text')
            ->orderBy('created_at', 'desc')
            ->get();
    
        $this->categories = ArticlesController::$validCategories;
    }

    public function index()
    {
        $response = (object)['articles' => $this->articles, 'categories' => $this->categories];

        Log::info('PREPARE ARTICLES FOR SEARCH  ');
        
        return Response::json($response, 200, array('charset' => 'utf8'), JSON_UNESCAPED_UNICODE);
    }
}
