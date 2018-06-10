<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class TrackWebsiteViewEvents extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'track:events';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Store total event views by a session_id into the tracking summary table';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
     public function handle()
     {
       $type = "event_views";
       $date_yesterday = \Carbon\Carbon::yesterday()->format("Y-m-d");
       $start_timestamp_yesterday = \Carbon\Carbon::yesterday()->format("Y-m-d 00:00:00");
       $end_timestamp_yesterday = \Carbon\Carbon::yesterday()->format("Y-m-d 23:59:59");

       //For testing purposes : view today's activity
       //$date_yesterday = \Carbon\Carbon::today()->format('Y-m-d');
       //$start_timestamp_yesterday = \Carbon\Carbon::today()->format('Y-m-d 00:00:00');
       //$end_timestamp_yesterday = \Carbon\Carbon::today()->format('Y-m-d 23:59:59');
       //\Log::info('Item Logged @ '.$end_timestamp_yesterday);

       $records = DB::table('track_page_views')->where([
             ['created_at', '>=', $start_timestamp_yesterday],
             ['created_at', '<=', $end_timestamp_yesterday],
             ['item_type', 'like', 'event']
       ])->get();

       $query_array = [];
       $session_id_hashmap = [];
       //populate our query_array with unique session_ids
       //and count the views
       $unique_sessions_counter = 0;
       foreach($records as $record) {
         //if a session_id has not been recorded yet
         if(!isset($session_id_hashmap[''.$record->session_id])) {
           $query_array[] = ['session_id' => ''.$record->session_id,
                                      'date' => $date_yesterday,
                                      'type' => $type,
                                      'value' => 1];
           $session_id_hashmap[''.$record->session_id] = $unique_sessions_counter;
           $unique_sessions_counter++;
         } else {
           //Otherwise, increment the view by 1;
           $query_array[$session_id_hashmap[''.$record->session_id]]['value'] +=1;
         }
       }

       \Log::info('session_id_list is : '.json_encode($query_array));
       DB::table('summarize_tracking_data')->insert($query_array);
     }
}
