<?php

namespace App\Http\Controllers;

use App\Articles;
use Illuminate\Http\Request;
use App\Http\Requests\StoreArticleRequest;
use Illuminate\Support\Facades\Response;
use App\Comment;
use App\Like;
use App\DisLike;
use App\WebsiteUsers;
use App\ArticlesShortMarket;
use App\Http\Controllers\WebsiteConsfigurationController;
use App\Http\Controllers\ArticlesShortMarketController;
use App\Http\Controllers\NortificationController;
use App\Http\Controllers\UserStatisticController;
use App\Http\Controllers\WebsiteUsersController;
use App\Http\Controllers\AllArticlesShortMarketController;

use Log;

class ArticlesController extends Controller
{
    static public $validCategories = [
        'trening',
        'ishrana',
        'saveti',
        'grupni treninzi',
        'crossfit',
        'power liftting',
        'yoga',
        'trcanje',
        'mrsavljenje'
    ];


    static protected function filterForResponse($articles = [])
    {
        foreach ($articles as $article) {
           $article = self::filterForArticleShortMarketResponse($article);
        }

        return $articles;
    }

    static private function fiterComentsForResponse($comments = []) {
        foreach ($comments as $comment) {
           $user = WebsiteUsers::find($comment->user_id);
          unset($comment->user_id);
           $comment->userName = $user->first_name.' '.$user->last_name;
        }

        return $comments;
    }

    static private function fiterLikesForResponse($likes = []) {
        foreach ($likes as $like) {
           $user = WebsiteUsers::find($like->user_id);
           unset($like->user_id);
           unset($like->updated_at);
           unset($like->text_id);
           $like->userName = $user->first_name.' '.$user->last_name;
        }

        return $likes;
    }

    static private function fiterDislikesForResponse($dislikes = []) {
        foreach ($dislikes as $dislike) {
           $user = WebsiteUsers::find($dislike->user_id);
           unset($dislike->user_id);
           unset($dislike->updated_at);
           unset($dislike->text_id);
           $dislike->userName = $user->first_name.' '.$user->last_name;
        }

        return $dislikes;
    }

    static private function filterForArticleShortMarketResponse($article) {
        unset($article->text);
        unset($article->likes_id);
        unset($article->dislikes_id);
        unset($article->comments_id);
        $article->tags = explode('|', $article->tags);
        $article['categoryUrlSlug'] = self::getArticleCategoryUrlSlugForArticle($article->category);
        $article['subscriptionId'] = ArticlesShortMarketController::getSubscriptionId($article->id);

        return $article;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($category = NULL)
    {
        if (!$category) {
            $articles = Articles::where('id', '>', 0)
                ->orderBy('created_at', 'desc')
                ->paginate(15);
        } else {
            $articles = Articles::where('category', $category)
                ->orderBy('created_at', 'desc')
                ->paginate(15);
        }


        $data = ['articles' => $articles, 'categories' => self::$validCategories];

        return view('articles.articles')->with('data', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data = [
            'categories' => self::$validCategories,
            'succes' => false];

        return view('articles.create-article')->with('data', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreArticleRequest $request)
    {
        $oldArticle = Articles::where('title', $request->input('title'))->first();
        if ($oldArticle) {
            $data = [
                'error' => 'already exists'
            ];
            Log::info('ERROR | ARTICLE ALREADY EXISTS');
            return redirect()->route('articles.index')->with('data', $data);
        }

        $article = new Articles;

        $article->title = $request->input('title');
        $article->description = $request->input('description');
        $article->text = $request->input('text');
        $article->image_url = $request->input('image_url');
        $article->thumb_image_url = $request->input('thumb_image_url');
        $article->tags = $request->input('tags');
        $article->category = $request->input('category');
        $article->article_title_url_slug = $this->createTitleUrlSlug($request->input('title'));
        $article->seen_times = 0;
        $article->save();

        ArticlesShortMarketController::store($article->id);
        NortificationController::notifySubscribersOfNewArticleTags(
            explode('|', $article->tags),
            $article->title,
            $article->description,
            $article->thumb_image_url,
            '/'.'tekstovi/'.self::getArticleCategoryUrlSlugForArticle( $article->category).'/'.$article->article_title_url_slug
        );

        $data = [
            'success' => 'create'
        ];
        Log::info('ADDED ARTICLE: | '. $article->id .' | ');
        WebsiteConsfigurationController::refreshTagsPriorityList(1);

        return redirect()->route('articles.index')->with('data', $data);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Articles  $articles
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $article = Articles::find($id);
        $data = [
            'article' => $article
        ];

        return view('articles.single-article')->with('data', $data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Articles  $articles
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $article = Articles::find($id);
        $data = [
            'categories' => self::$validCategories,
            'article' => $article
        ];

        return view('articles.edit-article')->with('data', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Articles  $articles
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
       $article = Articles::find($id);

        $article->title = $request->input('title') ? $request->input('title') : $article->title;
        $article->description = $request->input('description') ? $request->input('description') : $article->description;
        $article->text = $request->input('text') ? $request->input('text') : $article->text;
        $article->image_url = $request->input('image_url') ? $request->input('image_url') : $articles->image_url;
        $article->thumb_image_url = $request->input('thumb_image_url') ? $request->input('thumb_image_url') : $article->thumb_image_url;
        $article->tags = $request->input('tags') ? $request->input('tags') : $article->tags;;
        $article->category = $request->input('category') ? $request->input('category') : $article->category;;
        $article->article_title_url_slug = $request->input('title') ?
            $this->createTitleUrlSlug($request->input('title')) : $this->createTitleUrlSlug($request->$article->title);
        $article->save();

        ArticlesShortMarketController::update($id, (object)['change' => 'updated article']);

        $data = [
            'success' => 'update',
            'payload' => null
        ];
        Log::info('UPDATED ARTICLE: | '. $id .' | ');
        WebsiteConsfigurationController::refreshTagsPriorityList(1);

        return redirect()->route('articles.index')->with('data', $data);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Articles  $articles
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Articles::destroy($id);
        $articles = Articles::all();
        $data = [
            'articles' => $articles,
            'success' => 'delete'
        ];

        ArticlesShortMarketController::destroy($id);

        Log::info('DELETED ARTICLE: | '. $id .' | ');
        WebsiteConsfigurationController::refreshTagsPriorityList(1);

        return redirect()->route('articles.index')->with('data', $data);

    }

    /**
    *  Returns all articles from Database
    */
     public function all(Request $request)
    {
        $uid = $request->query('uid');
        if ($uid) {
            $data = [];
            $data['uid'] = $uid;
            $data['stats'] = [];

            array_push(
                $data['stats'],
                [
                    'statType' => 'number_of_visits_by_day',
                    'statData' => strtolower(substr((string)date("D")), 0, 3)
                ],
                [
                    'statType' => 'time_of_visits',
                    'statData' => date("H:i:s")
                ],
                [
                    'statType' => 'number_of_visits',
                    'statData' => 1
                ]
            );
            UserStatisticController::updateUserData((object)$data);
        }

        $articles = Articles::all();;

        $articles = self::filterForResponse($articles);
        $topArticles = $this->getTopArticlesArray();
        $latestArticles = $this->getLatestArticlesArray($topArticles);
        $indexArticles = $this->getIndexPageArticlesArray($topArticles, $latestArticles);
        $response = [
            'articles' => $articles,
            'topArticles' => $topArticles,
            'latestArticles' => $latestArticles,
            'indexPageArticles' => $indexArticles
        ];
        
        Log::info('GET ALL ARTICLES | '.count($articles).' | ');
        $update = [
            'type' => 'update',
            'payload' => '{}'
        ];
        
        AllArticlesShortMarketController::update($topArticles, $latestArticles, $indexArticles, $update);
        return Response::json($response, 200, array('charset' => 'utf8'), JSON_UNESCAPED_UNICODE);
    }

    /**
    *  Returns top articles from Database
    */
    public function top(Request $request)
    {
        $uid = $request->query('uid');
        if ($uid) {
            $data = [];
            $data['uid'] = $uid;
            $data['stats'] = [];

            array_push(
                $data['stats'],
                [
                    'statType' => 'last_visit_and_page',
                    'statData' => [
                        'date' => date("D M j G:i:s T Y"),
                        'page' => 'najcitaniji-tekstovi'
                    ]
                ],
                [
                    'statType' => 'visited_categories',
                    'statData' => 'top'
                ]
            );
            UserStatisticController::updateUserData((object)$data);

        }

        $articles = $this->getLatestArticlesArray($this->getTopArticlesArray());

        Log::info('GET TOP ARTICLES');

        return Response::json($articles, 200, array('charset' => 'utf8'), JSON_UNESCAPED_UNICODE);
    }

    /**
    *  Returns top articles from Database
    */
    public function latest(Request $request)
    {
        $uid = $request->query('uid');
        if ($uid) {
            $data = [];
            $data['uid'] = $uid;
            $data['stats'] = [];

            array_push(
                $data['stats'],
                [
                    'statType' => 'last_visit_and_page',
                    'statData' => [
                        'date' => date("D M j G:i:s T Y"),
                        'page' => 'najnoviji-tekstovi'
                    ]
                ],
                [
                    'statType' => 'visited_categories',
                    'statData' => 'latest'
                ]
            );

            UserStatisticController::updateUserData((object)$data);
        }

        $articles = $this->getTopArticlesArray();

        Log::info('GET TOP ARTICLES');

        return Response::json($articles, 200, array('charset' => 'utf8'), JSON_UNESCAPED_UNICODE);
    }

    /**
    *  Returns all articles from category
    */
    public function category(Request $request, $category)
    {
        $uid = $request->query('uid');
        if ($uid) {
            $data = [];
            $data['uid'] = $uid;
            $data['stats'] = [];

            array_push(
                $data['stats'],
                [
                    'statType' => 'last_visit_and_page',
                    'statData' => [
                        'date' => date("D M j G:i:s T Y"),
                        'page' => $category
                    ]
                ],
                [
                    'statType' => 'visited_categories',
                    'statData' => $category
                ]
            );

            UserStatisticController::updateUserData((object)$data);
        }

        $articles = array_map(
            function($element) {
                return $element['id'];
            },
            Articles::where('category', $category)
                            ->orderBy('updated_at', 'desc')
                            ->select('id')
                            ->get()
                            ->toArray()
        );

        Log::info('GET ALL ARTICLES FROM CATEGORY : | '.strtoupper($category) .' |');

        return Response::json($articles, 200, array('charset' => 'utf8'), JSON_UNESCAPED_UNICODE);
    }

    /**
    *  Returns toparticles from category
    */
    public function categoryTopArticles(Request $request, $category)
    {
        $articles = Articles::where('category', $category)
            ->orderBy('seen_times', 'desc')
            ->take(10)
            ->get();

        $articles = self::filterForResponse($articles);

        Log::info('GET TOP ARTICLES FROM CATEGORY : | '.strtoupper($category) .' |');

        return Response::json($articles, 200, array('charset' => 'utf8'), JSON_UNESCAPED_UNICODE);
    }

    /**
    *  Returns latest articles from category
    */
    public function categoryLatestArticles(Request $request, $category)
    {
        $articles = Articles::where('category', $category)
            ->orderBy('updated_at', 'desc')
            ->take(10)
            ->get();

        $articles = self::filterForResponse($articles);

        Log::info('GET LATEST ARTICLES FROM CATEGORY : | '.strtoupper($category) .' |');

        return Response::json($articles, 200, array('charset' => 'utf8'), JSON_UNESCAPED_UNICODE);
    }

    public static function article(Request $request, $id)
    {
        if ((int)$id > 0) {
            $article = Articles::find($id);
        } else {
            $article = Articles::where('article_title_url_slug', $id)->first();
        }

        if (!$article) {
            return '{"status":"article not found"}';
        }


        $article->seen_times = $article->seen_times + 1;
        $article->save();

        $coments = Comment::where('text_id', $article->id)->orderBy('created_at', 'desc')->get();
        $likes = Like::where('text_id', $article->id)->orderBy('created_at', 'desc')->get();
        $dislikes = DisLike::where('text_id', $article->id)->orderBy('created_at', 'desc')->get();

        $article['comments'] = self::fiterComentsForResponse($coments);
        $article['likes'] =  self::fiterLikesForResponse($likes);
        $article['dislikes'] = self::fiterDislikesForResponse($dislikes);
        $article->tags = explode('|', $article->tags);
        $article['categoryUrlSlug'] = self::getArticleCategoryUrlSlugForArticle($article->category);
        $article['subscriptionId'] = ArticlesShortMarketController::getSubscriptionId($article->id);


        $payload =['seen_times' => $article->seen_times];

        ArticlesShortMarketController::update(
            $article->id,
            (object)[
                'change' => 'action',
                'payload' => json_encode($payload)
            ]
        );

        $uid = $request->query('uid');
        $aof = $request->query('aof');
        $f = $request->query('f');

        if ($uid) {
            $data = [];
            $data['uid'] = $uid;
            $data['stats'] = [];

            $request['action'] = 'addTextToVisited';
            $request['textId'] = $id;

            WebsiteUsersController::action($request, $uid);

            array_push(
                $data['stats'],
                [
                    'statType' => 'visited_tags',
                    'statData' => $article->tags
                ],
                [
                    'statType' => $aof,
                    'statData' => $article->id
                ]
            );

            if ($f) {
                array_push(
                $data['stats'],
                    [
                        'statType' => 'texts_open_that_was_featured',
                        'statData' => $article->id
                    ]
                );
            }

            UserStatisticController::updateUserData((object)$data);
        }

        Log::info('GET ARTICLE  : | '.$id .' |');

        return Response::json($article, 200, array('charset' => 'utf8'), JSON_UNESCAPED_UNICODE);
    }

    public function getArticleShortMArket($id)
    {
        $article = Articles::find($id);

        if(!$article) {
            return "{'status':'atricle does not exist'}";
        }

        $article= self::filterForArticleShortMarketResponse($article);


        return Response::json($article, 200, array('charset' => 'utf8'), JSON_UNESCAPED_UNICODE);
    }

    static public function action(Request $request, $id)
    {
        $article = Articles::find($id);
        $payload = [];
        if ($request['action'] === 'comment') {
            $comment = new Comment;

            $comment->user_id = $request['userId'];
            $comment->comment = $request['comment'];
            $comment->text_id = $id;
            $comment->save();

            $article->number_of_comments = $article->number_of_comments ? $article->number_of_comments + 1 : 1;
            $article->save();


            $payload = [
                'number_of_comments' => $article->number_of_comments,
                'comments' => self::fiterComentsForResponse(
                    Comment::where('text_id', $article->id)->orderBy('created_at', 'desc')->get()
                )
            ];
        } else if ($request['action'] === 'like') {
            $oldLike = Like::where('user_id', $request['userId'])->where('text_id', $id)->first();

            if ($oldLike) {
                Like::destroy($oldLike->id);
                $article->number_of_likes = $article->number_of_likes ? $article->number_of_likes - 1 : 0;
            } else {
                $like = new Like;

                $like->user_id = $request['userId'];
                $like->text_id = $id;
                $like->save();

                $article->number_of_likes = $article->number_of_likes ? $article->number_of_likes + 1 : 1;

                $oldDisLike = DisLike::where('user_id', $request['userId'])->where('text_id', $id)->first();

                if ($oldDisLike) {
                    DisLike::destroy($oldDisLike->id);
                    $article->number_of_dislikes = $article->number_of_dislikes ? $article->number_of_dislikes - 1 : 0;
                }
            }

            $payload = [
                'number_of_likes' => $article->number_of_likes,
                'number_of_dislikes' => $article->number_of_dislikes,
                'likes' => self::fiterLikesForResponse(
                    Like::where('text_id', $article->id)->orderBy('created_at', 'desc')->get()
                ),
                'dislikes' => self::fiterDislikesForResponse(
                    DisLike::where('text_id', $article->id)->orderBy('created_at', 'desc')->get()
                )
            ];
            $article->save();
        } else if ($request['action'] === 'dislike') {
            $oldDisLike = DisLike::where('user_id', $request['userId'])->where('text_id', $id)->first();

            if ($oldDisLike) {
                DisLike::destroy($oldDisLike->id);
                $article->number_of_dislikes = $article->number_of_dislikes ? $article->number_of_dislikes - 1 : 0;
            } else {
                $dislike = new DisLike;

                $dislike->user_id = $request['userId'];
                $dislike->text_id = $id;
                $dislike->save();

                $article->number_of_dislikes = $article->number_of_dislikes ? $article->number_of_dislikes + 1 : 1;

                $oldLike = Like::where('user_id', $request['userId'])->where('text_id', $id)->first();

                if ($oldLike) {
                    Like::destroy($oldLike->id);
                    $article->number_of_likes = $article->number_of_likes ? $article->number_of_likes - 1 : 0;
                }
            }

            $payload = [
                'number_of_likes' => $article->number_of_likes,
                'number_of_dislikes' => $article->number_of_dislikes,
                'likes' => self::fiterLikesForResponse(
                    Like::where('text_id', $article->id)->orderBy('created_at', 'desc')->get()
                ),
                'dislikes' => self::fiterDislikesForResponse(
                    DisLike::where('text_id', $article->id)->orderBy('created_at', 'desc')->get()
                )
            ];
            $article->save();
        } else if ($request['action'] === 'setSeenTimes') {
            $article->seen_times = $request['seen_times'] ?: $article->seen_times + 1;
            $payload =['seen_times' => $article->seen_times];
            $article->save();
        }else {
            return "{'satus':'Unknown action'}";
        }

        ArticlesShortMarketController::update(
            $id,
            (object)[
                'change' => 'action',
                'payload' => json_encode($payload)
            ]);

        Log::info('ON ARTICLE: | '.$id .' |  IS PREFORMED ACTION : | '.strtoupper($request['action']) .' |');

        return "{'satus':'action success'}";
    }

    public function getArticleCategoryAndTags($id)
    {
        $article = Articles::find($id);

        $category = $article->category;
        $tags = $article->tags;

        return "{'category:'".$category.",tags:".$tags."}";
    }

    public function createUrlSlugs()
    {
        $articles = Articles::all();

        foreach ($articles as $article) {
            $singleArticle = Articles::find($article->id);

            $article->article_title_url_slug = $this->createTitleUrlSlug($article->title);
            $article->save();
        }
    }

    private function createTitleUrlSlug($title)
    {
        $nameSlug = trim(mb_strtolower($title, 'UTF-8'));
        $nameSlug = preg_replace('/-/', '', $nameSlug);
        $nameSlug = preg_replace('/\s+/', ' ', $nameSlug);
        $nameSlug = preg_replace('/\s+/', '-', $nameSlug);
        $nameSlug = preg_replace('/\?/', '', $nameSlug);
        $nameSlug = preg_replace('/(\d+).(\d+)/', '$1$2', $nameSlug);
        $nameSlug = preg_replace('/\,/', '', $nameSlug);
        $nameSlug = preg_replace('/\!/', '', $nameSlug);
        $nameSlug = preg_replace('/\:/', '', $nameSlug);
        $nameSlug = preg_replace('/\;/', '', $nameSlug);
        $nameSlug = preg_replace('/\(/', '', $nameSlug);
        $nameSlug = preg_replace('/\)/', '', $nameSlug);
        $nameSlug = preg_replace('/\-–-/', '-', $nameSlug);
        $nameSlug = preg_replace('/\&/', '', $nameSlug);

        return $nameSlug;
    }

    public function counter(Request $request)
    {
        $responseObjects = [];
        $timestring = $request->timestring;
        $timestamp = date($timestring);

        foreach (self::$validCategories as $category) {
            $responseObject = [];
            $articles = Articles::where('category', $category)
                ->where('updated_at','>=', $timestamp)
                ->get();
            $responseObject['categoryName'] = $category;
            $responseObject['count'] = count($articles);
            array_push($responseObjects, (object)$responseObject);
        }


        Log::info('CATEGORIES COUNTER REQUESTED FOR DATE: | '. $timestring .' | ');
        return json_encode($responseObjects);
    }

    static public function getValidArticleTags() {
        $articles = Articles::all();
        $tagsArray = [];
        $result = [];

        foreach ($articles as $article) {
            $tagsArray = explode('|', $article->tags);

            foreach ($tagsArray as $tag) {
                if (array_key_exists($tag, $result)) {
                    $result[$tag]['count'] += 1;
                } else {
                    $result[$tag] = [
                        'name' => $tag,
                        'count' => 0
                    ];
                }
            }
        }

        usort($result, function ($a, $b) {
            if ($a["count"] == $b["count"]) {
                return 0;
            }
            return ($a["count"] < $b["count"]) ? 1 : -1;
        });

        return array_slice($result, 0, 20);
    }

    public function search(Request $request)
    {
        $searchParam = $request->query('search');

        $articles = Articles::where('title', 'like', '%'.$searchParam.'%')
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        $data = ['articles' => $articles, 'categories' => self::$validCategories];

        return view('articles.articles')->with('data', $data);
    }

    public function getIndexPageArticles() {
        $topArticles = $this->getTopArticlesArray();
        $latestArticles = $this->getLatestArticlesArray($topArticles);

        $indexArticles = $this->getIndexPageArticlesArray($topArticles, $latestArticles);

        Log::info('GET ARTICLES FOR INDEX PAGE');

        return Response::json($indexArticles, 200, array('charset' => 'utf8'), JSON_UNESCAPED_UNICODE);
    }

    static public function getArticleCategoryUrlSlugForArticle($category)
    {
        switch ($category) {
                case 'power_liftting':
                    $urlSlug = 'power-liftting';
                    break;
                case 'grupni_treninzi':
                    $urlSlug = 'grupni-treninzi';
                    break;
                case 'articles':
                    $urlSlug = 'svi-tekstovi';
                    break;
                case 'latest_articles':
                    $urlSlug = 'najnoviji-tekstovi';
                    break;
                case 'top_articles':
                    $urlSlug = 'najcitaniji-tekstovi';
                    break;
                default:
                    $urlSlug = $category;
                    break;
            }
        return $urlSlug;
    }

    public function getIndexPageArticlesArray($topArticles, $latestArticles)
    {
        $allArticles = array_map(
            function ($element) {
                return $element['id'];
            }, Articles::where('id', '>', 0)
                       ->orderBy('updated_at', 'desc')
                       ->select('id')
                       ->get()
                       ->toArray()
        );

        Log::info($topArticles);
        Log::info($latestArticles);
        
        return array_slice(
            array_filter(
                $allArticles,
                function ($element) use ($topArticles, $latestArticles) {
                    return !in_array($element, $topArticles) && !in_array($element, $latestArticles);
            }),
            0,
            40
        );
    }

    public function getTopArticlesArray()
    {
        $articles = Articles::where('id', '>', 0)
            ->orderBy('seen_times', 'desc')
            ->select('id')
            ->take(40)
            ->get()
            ->toArray();

        return array_map(
            function($element) {
                return $element['id'];
            },
            $articles
        );
    }

    public function getLatestArticlesArray($topArticles)
    {
        $articles = array_map(
            function($element) {
                return $element['id'];
            }, Articles::where('id', '>', 0)
            ->orderBy('updated_at', 'desc')
            ->select('id')
            ->take(60)
            ->get()
            ->toArray()
        );

        $latestArticles = [];

        foreach($articles as $id) {
            if (!in_array($id, $topArticles)) {
                array_push($latestArticles, $id);
            }
        }

        return $latestArticles;
    }
}
