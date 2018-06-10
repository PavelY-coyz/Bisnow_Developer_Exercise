<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

use App\EventItem;

class EventsController extends Controller
{
    public function __construct()
    {
        $this->middleware('trackdata');
    }

    public function index(Request $request)
    {
        
        $events = EventItem::orderBy('id', 'ASC')->get();
        return view('all_events')->with(["events" => $events,
                                          'item_type' => 'event']);
    }

    public function renderEventDetails(Request $request, $id) {
        //$current = DB::table('event_items')->where('id', '=', $id)->get()->first();
        $current = EventItem::find($id);
        //There is only one image per event.
        $current_images = [];
        foreach($current->images as $images) {
            $current_images[] = $images->name;
        };
        try{
          $previous = DB::table('event_items')->orderBy('id', 'DESC')->where('id', '<', $id)->get()->first();
        } catch(Exception $e) {
          $previous = NULL;
        }
        try{
          $next =  DB::table('event_items')->orderBy('id', 'ASC')->where('id', '>', $id)->get()->first();
        } catch(Exception $e) {
          $next = NULL;
        }
        return view('event_item')->with(['previous' => $previous,
                                         'current' => $current,
                                         'current_images' => $current_images,
                                         'next' => $next,
                                         'item_type' => 'event',
                                         'item_id' => $id]);
    }
}
