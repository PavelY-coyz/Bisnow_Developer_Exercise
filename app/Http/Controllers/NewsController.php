<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

use App\NewsItem;

class NewsController extends Controller
{
    public function __construct()
    {
        $this->middleware('trackdata');
    }

    public function index(Request $request)
    {
        //var_dump(session()->getUser());
        //var_dump(session('ip'));
        $news = NewsItem::orderBy('created_at', 'DESC')->get();
        return view('all_news')->with(["news" => $news,
                                        "item_type" => "news"]);
    }

    public function renderNewsStory(Request $request, $id) {
        try{
          $previous = DB::table('news_items')->orderBy('id', 'DESC')->where('id', '<', $id)->get()->first();
        } catch(Exception $e) {
          $previous = NULL;
        }
        $current = DB::table('news_items')->where('id', '=', $id)->get()->first();
        try{
          $next =  DB::table('news_items')->orderBy('id', 'ASC')->where('id', '>', $id)->get()->first();
        } catch(Exception $e) {
          $next = NULL;
        }
        return view('news_item')->with(['previous' => $previous,
                                         'current' => $current,
                                         'next' => $next,
                                          "item_type" => "news",
                                          "item_id" => $id]);
    }
}
