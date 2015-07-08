<?php

namespace App\Http\Controllers;

use App\Bill;
use App\CSVImportFile;
use App\Http\Requests;
use App\Http\Requests\BillRequest;
use Illuminate\Support\Facades\Auth;

/**
 * Class BillsController
 * @package App\Http\Controllers
 */
class BillsController extends Controller {

    /**
     * Ensure users are authenticated before using this controller
     *
     */
	public function __construct()
	{
		$this->middleware('auth');
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		if (Auth::user()->accounts->count() == 0)
		{
			return redirect('accounts');
		}
		else
		{
			$bills = Auth::user()->bills->sortBy('next_due');

			return view('bills.index', compact('bills'));
		}
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		$accounts = $this->accounts_select_list();
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
	 * Return select list for use in displaying accounts combo box
	 *
	 * @return mixed
	 */
	private function accounts_select_list()
	{
		$user = Auth::user();
		return $user->accounts->lists('description', 'id');
	}

	/**
	 * Show the form for editing the specified resource.
	 *
     * @param Bill $bill
	 * @return Response
	 */
	public function edit(Bill $bill)
	{
		$accounts = $this->accounts_select_list();
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

	/**
	 * Show the bill pay form
	 *
	 * @param $id
	 * @return \Illuminate\View\View
	 */
	public function pay($id)
	{
		$bill = Bill::findOrFail($id);
		return view('bills.pay', compact('bill'));
	}

	/**
	 * Mark the selected bill as paid
	 *
	 * @param $id
	 * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
	 */
	public function markPaid($id)
	{
		$bill = Bill::findOrFail($id);
		$payment = $bill->pay();
		$bill->save();
        $payment->save();

		return redirect('bills');
	}

	/**
	 * Export the list of bills to CSV
	 *
	 * @return \Illuminate\View\View
	 */
	public function export()
	{
		$bills = Auth::user()->bills;
		$array = [];
		foreach($bills as $bill)
		{
			$bill_array = [
				'id' => $bill->id,
				'description' => $bill->description,
				'last_due' => $bill->last_due,
                'amount' => $bill->amount,
				'times_per_year' => $bill->times_per_year,
                'monthly' => $bill->monthly,
                'account' => $bill->account->description,
				'auto' => $bill->dd == 1,
                'next_due' => $bill->next_due,
                'in_days' => $bill->indays,
			];
			$array[] = $bill_array;
		}
		return view('bills.export', compact('array'));
	}

    public function import()
    {
        return view('bills.import');
    }

    public function save_file(CSV $csvfile, Request $request)
    {
        $fileName = $this->saveFile($request['csvfile']);
        $content_raw = $csvfile->open($fileName)
                               ->readAll();
        $this->import_result($request, $content_raw);
    }

	/**
	 * Get result of import
	 *
	 * @param Requests\ImportBillsRequest $request
     */
	public function import_result(Requests\ImportBillsRequest $request)
    {
        // basic validation on file type done by laravel validation

		$file = $request['csvfile'];
		$result = CSVImportFile::readFile('uploads',$file);

		$parser = app('App\Contracts\CSVParser');
		$bills = $parser->createBills($result);
		foreach($bills as $bill)
		{
			dd($bill);
			Auth::user()->bills()->save($bill);
		}
	}
}
