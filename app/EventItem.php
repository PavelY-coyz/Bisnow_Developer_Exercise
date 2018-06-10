<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EventItem extends Model
{
    //
    protected $table = 'event_items';
    protected $fillable = ['name', 'description', 'event_date'];

    public function images() {
      return $this->morphMany('App\Images', 'image');
    }

    //public function tracking() {
    //  return $this->morphMany('App\TrackPageViews', 'trackable');
    //}
}
