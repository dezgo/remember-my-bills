<?php

namespace App\Http\Controllers;

use App\Bill;
use App\Account;
use Illuminate\Support\Facades\Validator;
use Input;
use App\Http\Requests;
use App\Http\Requests\BillRequest;
use Illuminate\Support\Facades\Auth;
use App\Repositories\BillRepositoryInterface;

/**
 * Class BillsController
 * @package App\Http\Controllers
 */
class BillsController extends Controller {

    /**
     * Ensure users are authenticated before using this controller
     *
     * @param BillRepositoryInterface $bills
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

    public function import_result(Requests\ImportBillsRequest $request)
    {
        $file = $request->file('csvfile');

        $destinationPath = 'uploads';
        $extension = $file->getClientOriginalExtension(); // getting file extension
        $fileName = rand(11111,99999).'.'.$extension; // renaming file
        $file->move($destinationPath, $fileName); // uploading file to given path

        if (($handle = fopen($destinationPath.'/'.$fileName, "r")) !== FALSE) {
            $data_full = [];
            while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
                array_push($data_full, $data);
            }
            fclose($handle);
            $this->import_update($data_full);
        }
    }

    /**
     * Get the number of the column with the given name
     *
     * @param $col_names
     * @return array
     */
    private function get_column_numbers($col_names)
    {
        $col_numbers = [];
        foreach ($col_names as $col_name)
        {
            $item = array_search($col_name, $col_names);
            $col_numbers = array_add($col_numbers, $col_name, $item);
        }
        return $col_numbers;
    }

    private function import_update($bills)
    {
        // get the column number for each column based on headings in array element zero
        $col_numbers = $this->get_column_numbers($bills[0]);

        // now get rid of the first element being column headings
        array_shift($bills);

		if (array_has($col_numbers, 'id'))
		{
			$new = Bill::findOrFail(['id' => $col_numbers['id']]);
		}
		else
		{
			$new = new Bill;
		}

		if (!array_has($col_numbers, 'description'))
		{

		}
		$new->last_due = $bill[$col_numbers['last_due']];
		$new->amount = $bill[$col_numbers['amount']];
		$new->times_per_year = $bill[$col_numbers['times_per_year']];
		$new->auto = $bill[$col_numbers['auto']];

        foreach($bills as $bill)
        {
            $new->user_id = Auth::user()->id;
            $new->description = $bill[$col_numbers['description']];
            $new->last_due = $bill[$col_numbers['last_due']];
            $new->amount = $bill[$col_numbers['amount']];
            $new->times_per_year = $bill[$col_numbers['times_per_year']];
            $new->auto = $bill[$col_numbers['auto']];

            // issue here, we need the account id, not the account description
            // but the user will upload the description
            // have to work out how to get ID from description
            $new->account = $bill[$col_numbers['account']];
        }
        dd($new);
    }
}
