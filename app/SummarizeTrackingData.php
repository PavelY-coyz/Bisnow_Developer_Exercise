<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SummarizeTrackingData extends Model
{
    //This looks like it should be another polymorphic relationship with TrackPageViews model...
    protected $table = 'summarize_tracking_data';
    protected $fillable = ['session_id', 'date', 'type', 'value'];

}
