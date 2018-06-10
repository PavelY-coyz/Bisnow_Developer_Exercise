<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class NewsItem extends Model
{
    //
    protected $table = 'news_items';
    protected $fillable = ['title', 'html_body'];

    public function images() {
      return $this->morphMany('App\Images', 'image');
    }

    //public function tracking() {
    //  return $this->morphMany('App\TrackPageViews', 'trackable');
    //}
}
