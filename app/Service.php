<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    protected $fillable = ['sweat', 'client_id', 'invoice_nr', 'name', 'description', 'cost', 'price', 'attachment', 'delivery_date'];

    function client(){
        return $this->belongsTo('App\Client');
    }

}
