<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\TrackPageViews;

class TrackingController extends Controller
{
    public function __construct()
    {
        $this->middleware('trackdata');
    }

    public function index(Request $request)
    {
        //if some date data exists get summmary data; else return normal view
        if(null!==($request->input('start_date')) ||
            null!==($request->input('end_date'))) {

          //if the start_date is set but the end_date isnt
          if(null!==($request->input('start_date')) && null===($request->input('end_date'))) {
            $start_date = $request->input('start_date');
            $end_date = \Carbon\Carbon::today()->format("Y-m-d");
          }
          //start_data not set, but end_data is set
          else if(null===($request->input('start_date')) && null!==($request->input('end_date'))) {
            //This one really depends on if you want to do a query like
              // from start-of-time - end_date
              //if so, this needs to be amended
            $start_date = \Carbon\Carbon::today()->format("Y-m-d");
            $end_date =  $request->input('end_date');
          } else { //both are set
            $start_date = $request->input('start_date');
            $end_date = $request->input('end_date');
          }

          //since "start" and "end" can be interperted differently like "from" and "to"
          //I will maintaint my own order
          //basically which date goes back in time further
          //start_date will be further back in time than end_date
          if($start_date > $end_date) {
            $temp = $end_date;
            $end_date = $start_date;
            $start_date = $temp;
          }
          //Having the dates be equal doesnt matter.

        } else {
          //For last 7 days
          $start_date = \Carbon\Carbon::today()->subDays(7)->format("Y-m-d");
          $end_date = \Carbon\Carbon::today()->format("Y-m-d");
        }

        //We need timestamps for the queries
        $start_date_ts = $start_date." 00:00:00";
        $end_date_ts = $end_date." 23:59:59";
        //get summary
        $summary = $this->getSummary($start_date_ts, $end_date_ts);

        \Log::info('start_date (index-end) : '.$start_date);
        \Log::info('end_date (index-end) : '.$end_date);

        return view('tracking')->with([
          'start_date' => $start_date,
          'end_date' => $end_date,
          'total_views' => $summary['total_views'],
          'unique_views' => $summary['unique_views']
        ]);
    }

    //AJAX called function from news, news/{id}, event, event/{id}, and home
    //saves data about a page visit
    public function trackVisit(Request $request)
    {
        DB::table('track_page_views')->insert(
            ['url' => $request->input('url'),
             'item_Id' => $request->input('item_id'),
             'item_type' => $request->input('item_type'),
             'ip' => $request->ip(),
             'email' => session()->get('user')->email,
             'session_id' => session()->getId(),
             'marketing_tracking_code' => 'huh']
        );

        return response("success");
    }

    public function exportCSV()
    {
        $records = [];

        $headers = array(
            "Content-type" => "text/csv",
            "Content-Disposition" => "attachment; filename=file.csv",
            "Pragma" => "no-cache",
            "Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
            "Expires" => "0"
        );

        //Get all distinct urls
        $urls = DB::table('track_page_views')->select('url')->distinct()->get();
        //Get all unique session_ids
        $distinct_sessions = DB::table('track_page_views')->select('session_id')->distinct()->get();

        //For each unique url
        foreach($urls as $url) {
          //find distinct session_ids that have visited this url
          \Log::info('current url :'.$url->url);
          $distinct_sessions = DB::table('track_page_views')
              ->select('session_id')
              ->where([
                ['url', 'like', $url->url]
              ])
              ->distinct()
              ->get();
          //find total_views of the page
          $total_views = DB::table('track_page_views')
              ->where([
                ['url', 'like', $url->url]
              ])
              ->count();
          //populate the record for the unique url
          $records[] = ['url' => $url->url,
                              'unique_views' => count($distinct_sessions),
                              'total_views' => $total_views];

        }



        $columns = array('url', 'unique_views', 'total_views');

        //callback function to write to file
        $callback = function() use ($records, $columns)
        {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns);

            foreach($records as $record) {
                fputcsv($file, array($record['url'], $record['unique_views'], $record['total_views']));
            }
            fclose($file);
        };
        return response()->stream($callback, 200, $headers);
        //\Log::info('records: '.json_encode($records));
        //return response(json_encode($records));
    }

    private function getSummary($start_date, $end_date)
    {
      \Log::info('start_date (func) : '.$start_date);
      \Log::info('end_date (func) : '.$end_date);
      //Count all the records in the 'track_page_views' between start/end dates
      $total_views = DB::table('track_page_views')->where([
        ['created_at', '>=', $start_date],
        ['created_at', '<=', $end_date]
      ])->count();

      //Get all unique session_ids
      $distinct_sessions = DB::table('track_page_views')->select('session_id')->where([
        ['created_at', '>=', $start_date],
        ['created_at', '<=', $end_date]
      ])->distinct()->get();
      //\Log::info('distinct_sessions : '.$distinct_sessions);

      //Keep a counter
      $unique_views = 0;

      //For each unique session_id; get distinct page visits,
      foreach($distinct_sessions as $sessions) {
        \Log::info('Session id : '.$sessions->session_id);
        $distinct_page = DB::table('track_page_views')->select('url')->where([
          ['created_at', '>=', $start_date],
          ['created_at', '<=', $end_date],
          ['session_id', 'like', $sessions->session_id]
        ])->distinct()->get();

        //count the amount of distinct records we got, and add them to the counter
        $unique_views+= count($distinct_page);
      }

      return ['total_views' => $total_views,
              'unique_views' => $unique_views];
    }
}
