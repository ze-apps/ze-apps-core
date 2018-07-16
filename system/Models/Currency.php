<?php

namespace Zeapps\Models ;

use Illuminate\Database\Eloquent\Model ;
use Illuminate\Database\Eloquent\SoftDeletes;

class Currency extends Model {

    use SoftDeletes;

    protected $table = 'zeapps_currency';
}