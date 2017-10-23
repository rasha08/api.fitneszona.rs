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

class TestController extends Controller
{   
    public function index()
    {
        $testUsers = WebsiteUsers::where('email', 'like', '%@fitneszona.rs%')->get();
        $articles = Articles::all();

        $data = ['users' => $testUsers, 'articles' => $articles, 'success' => null, 'action' => null, 'textId' => null, 'user' => null];

        return view('test.test')->with('data', $data);
    }

    public function action(Request $request)
    {
        $textId = $request->input('article');
        $userId = $request->input('test-user');
        $action = $request->input('action');
        $request['action'] = $request->input('action');
        $request['userId'] = $userId;
        $request['textId'] = $textId;
        $request['test'] = true;

        switch ($action) {
            case 'addLikedCategory':
                WebsiteUsersController::action($request, $userId);
                break;
            case 'addLikedTag':
                $request['value'] = $request->input('liked_tag');
                WebsiteUsersController::action($request, $userId);
                break;
            case 'addTextToVisited':
                WebsiteUsersController::action($request, $userId);
                break;
            case 'like':
                ArticlesController::action($request, $textId);
                break;
            case 'dislike':
                ArticlesController::action($request, $textId);
                break;
            case 'comment':
                $request['comment'] = $request->input('comment_text');
                ArticlesController::action($request, $textId);
                break;
            case 'setSeenTimes':
                $seenTimes = $request->input('seen_times');
                $article = Articles::find($textId);
                $article->seen_times = $seenTimes;
                $article->save();
                break;
            default:
                break;
        }

        $testUsers = WebsiteUsers::where('email', 'like', '%@fitneszona.rs%')->get();
        $articles = Articles::all();
        $user = WebsiteUsers::find($userId);
        $user = $user->first_name.' '.$user->last_name;
        $data = ['users' => $testUsers, 'articles' => $articles, 'success' => 'success', 'action' => $action, 'textId'=> $textId, 'user' => $user];

        Log::info('TEST ACTION | '.$action.' |');

        return view('test.test')->with('data', $data);
    }
}
