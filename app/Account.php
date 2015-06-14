<?php namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

/**
 * Class Account
 * @package App
 */
class Account extends Model {

	/**
	 * only description can be mass-assigned
	 *
	 * @var array
	 */
	protected $fillable = ['description'];

	/**
	 * An account is owned by a user
	 *
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
	public function user()
	{
		return $this->belongsTo('App\User');
	}

	/**
	 * An account has many bills
	 *
	 * @return mixed
	 */
	public function bills()
	{
		return $this->hasMany('App\Bill');
	}
}
