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
     * Test severity levels. Should be
     * 1: Due in > 14 days
     * 2: Due in <= 14 days but >= 7 days
     * 3: Due in < 7 days
     */
    public function getSeverityAttribute()
    {
        if ($this->next_due->gt(Carbon::now()->addDays(14))) return 1;
        if ($this->next_due->gte(Carbon::now()->addDays(7))) return 2;
        return 3;
    }

    public function getSeverityCSSAttribute()
    {
        switch ($this->severity)
        {
            case 1: return 'success';
            case 2: return 'warning';
            case 3: return 'danger';
        }
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
     *
     * @param null
     */
    public function pay()
    {
        $this->last_due = $this->next_due;
    }
}
