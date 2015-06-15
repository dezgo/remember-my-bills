<?php namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

/**
 * Class Bill
 *
 * @package App
 */
class Bill extends Model {

    /**
     * Fields that can be mass-assigned
     *
     * @var array
     */
    protected $fillable = [
		'description',
		'last_due',
		'times_per_year',
		'account_id',
		'amount',
        'dd'
	];

	/**
     * dates to treat as Carbon instances
     *
     * @var array
     */
    protected $dates = ['last_due'];

	/**
     * additional calculated fields
     *
     * @var array
     */
    protected $appends = array('monthly', 'next_due', 'in_days');

	/**
     * Get the next due date for this bill
     *
     * @return mixed
     */
    public function getNextDueAttribute()
    {
        return $this->last_due->addDays(365/$this->times_per_year);
    }

	/**
     * Get the amount to pay per month
     *
     * @return float
     */
    public function getMonthlyAttribute()
    {
        return $this->amount * $this->times_per_year / 12;
    }

	/**
     * Returns next due in terms of days / weeks etc
     *
     * @return mixed
     */
    public function getInDaysAttribute()
    {
        return $this->next_due->diffForHumans();
    }
	/**
	 * A bill is owned by a user
	 *
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
	public function user()
	{
		return $this->belongsTo('App\User');
	}

    /**
     * A bill is paid via a particular account
     *
     * @return mixed
     */
    public function account()
    {
        return $this->belongsTo('App\Account');
    }

    /**
     * Ensure the last_due field is an instance of Carbon
     *
     * @param $date
     */
    public function setLastDueAttribute($date)
    {
        $this->attributes['last_due'] = Carbon::parse($date);
    }

	/**
     * Pay a bill, then advance the last due date
     * ensure the last due date is after the date the bill is paid
     *
     * @param null $date < date the bill is paid, default to now()
     */
    public function pay($date = null)
    {
        if ($date == null) $date = Carbon::now();
        do
        {
            $this->last_due = $this->next_due;
        } while ($this->next_due <= $date);
    }
}
