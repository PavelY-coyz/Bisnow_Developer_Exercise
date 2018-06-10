<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TrackPageViews extends Model
{
    //
    protected $table = 'track_page_views';
    protected $fillable = ['url', 'ip', 'session_id', 'email', 'marketing_tracking_code', 'item_Id', 'item_type'];

    //public function track_pages() {
    //  return $this->morphTo();
    //}
}
