<?php

namespace App\Http\Controllers;

use App\Bill;
use Illuminate\Support\Facades\Validator;
use Input;
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
     * @param null $bills
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
		$bills = Auth::user()->bills->sortBy('next_due');

        return view('bills.index', compact('bills'));
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
	 * @param  int  $id
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
	 * @param  int  $id
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
	 * @param  int  $id
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

    public function import_result()
    {
		// get all the post data
        $file = ['csvfile' => Input::file('csvfile')];

		// establish some validation rules
		$rules = [
			'csvfile' => 'required',
		];

		// now do the validation
		$validator = Validator::make($file, $rules);

		if ($validator->fails())
		{
			return redirect('bills/import')->withInput()->withErrors($validator);
		}
		elseif (!Input::file('csvfile')->isValid())
		{
			Session::flash('error', 'Uploaded file is not valid');
			return redirect('bills/import');
		}
		else
		{
			$destinationPath = 'uploads';
			$extension = Input::file('csvfile')->getClientOriginalExtension(); // getting image extension
			$fileName = rand(11111,99999).'.'.$extension; // renaming image
			Input::file('csvfile')->move($destinationPath, $fileName); // uploading file to given path

			$row = 1;
			if (($handle = fopen($destinationPath.'/'.$fileName, "r")) !== FALSE) {
				while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
					$num = count($data);
					echo "<p> $num fields in line $row: <br /></p>\n";
					$row++;
					for ($c=0; $c < $num; $c++) {
						echo $data[$c] . "<br />\n";
					}
				}
				fclose($handle);
			}
		}
    }
}
