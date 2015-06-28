<?php

namespace App\Validators;

use App\Contracts\CSV;
use App\Bill;

class BillsImportValidator
{
	protected $csvfile;
	protected $content_raw;

	public function __construct(CSV $csvfile)
	{
		$this->csvfile = $csvfile;
	}

	/**
	 * Validate CSV file contents
	 *
	 * @param $field
	 * @param $value
	 * @param $parameters
	 * @return bool
	 */
	public function validate($field, $value, $parameters)
	{
        $fileName = $this->saveFile($value);
		$this->content_raw = $this->csvfile->open($fileName)
										   ->readAll();

		$message = $this->validate_hasData();

		if ($message == '')
		{
			$message = $this->validate_correctNumColumns();
		}

		if ($message == '')
		{
			$message = $this->validate_correctColumnNames();
		}

		return $message == '';
	}

	/**
	 * Save the file in the input request to the uploads folder
	 *
	 * @param Request $request
	 * @return string
	 */
	private function saveFile($file)
	{
		$destinationPath = 'uploads';
		$extension = $file->getClientOriginalExtension(); // getting file extension
		$fileName = rand(11111,99999).'.'.$extension; // renaming file
		$file->move($destinationPath, $fileName); // uploading file to given path

		return $destinationPath.'/'.$fileName;
	}


	/**
	 * CSV Validator - has at least 2 rows
	 *
	 * @return bool
	 */
	private function validate_hasData()
	{
		return count($this->content_raw) < 2 ? 'CSV must have at least 2 rows' : '';
	}

	private function validate_correctNumColumns()
	{
		$expecting = count(Bill::get_column_names());
		$actual = count($this->content_raw[0]);
		return $expecting == $actual ? '' :
			'Incorrect number of columns. Expecting '.$expecting.', got '.$actual;
	}

	/**
	 * Ensure column names are correct
	 *
	 * @return string
	 */
	private function validate_correctColumnNames()
	{
		foreach ($this->content_raw[0] as $index=>$value)
		{
			if (Bill::get_column_names()[$index] != $value)
			{
				return 'Column '.$index.': Expecting '.Bill::get_column_names()[$index].
				', got '.$value;
			}
		}
		$this->content_raw = array_shift($this->content_raw);
		return '';
	}
}