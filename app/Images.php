<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Images extends Model
{
    //

    protected $table = 'images';
    protected $fillable = ['name'];

    public function images() {
        return $this->morphTo();
    }
}
