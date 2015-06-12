<?php namespace App\Http\Controllers;

use App\Account;
use App\Bill;
use App\Http\Requests;
use App\Http\Requests\BillRequest;
use Illuminate\Support\Facades\Auth;
use App\Repositories\BillRepositoryInterface;

/**
 * Class BillsController
 * @package App\Http\Controllers
 */
class BillsController extends Controller {

    protected $bills;

    /**
     * Ensure users are authenticated before using this controller
     *
     * @param BillRepositoryInterface $bills
     */
	public function __construct(BillRepositoryInterface $bills = null)
	{
		$this->middleware('auth');
        if ($bills)
        {
            $this->bills = $bills;
        }
        elseif (Auth::check())
        {
            $this->bills = Auth::user()->bills;
        }
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
        //$bills = $this->bills->sortBy('next_due');
        $bills = $this->bills;

        return view('bills.index', compact('bills'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		$accounts = Account::getSelectData();
		return view('bills.create', compact('accounts'));
	}


	/**
	 * Save a new bill
	 *
	 * @param BillRequest $request
	 * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
	 */
	public function store(BillRequest $request)
	{
		$bill = new Bill($request->all());

		Auth::user()->bills()->save($bill);

        return redirect('bills');
	}

    /**
     * Display the specified resource.
     *
     * @param Bill $bill
     * @return Response
     * @internal param int $id
     */
	public function show(Bill $bill)
	{
		return view('bills.show', compact('bill'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
     * @param Bill $bill
	 * @return Response
	 */
	public function edit(Bill $bill)
	{
        $accounts = Account::getSelectData();
		return view('bills.edit', compact('bill', 'accounts'));
	}

	/**
	 * Update the specified resource in storage.
	 *
     * @param Bill $bill
     * @param BillRequest $request
	 * @return Response
	 */
	public function update(Bill $bill, BillRequest $request)
	{
		$bill->update($request->all());

        return redirect('bills');
	}

	/**
	 * Remove the specified resource from storage.
	 *
     * @param Bill $bill
	 * @return Response
	 */
	public function destroy(Bill $bill)
	{
		$bill->delete();

        return redirect('bills');
	}
}
