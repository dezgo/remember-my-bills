<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    // make these carbon instances
    protected $dates = ['payment_date'];

    /**
     * A Payment is owned by a user
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo('App\User');
    }

    /**
     * A payment is paid via a particular account
     *
     * @return mixed
     */
    public function account()
    {
        return $this->belongsTo('App\Account');
    }

}
