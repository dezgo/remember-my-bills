<?php

namespace App\Validators;

use App\Bill;
use Illuminate\Validation\Validator;

class BillsImportValidator extends Validator
{
	protected $csvfile;
	protected $content_raw;

	/**
	 * Grab CSV file and store as local parameter
	 *
	 * @param \Symfony\Component\Translation\TranslatorInterface $translator
	 * @param array $data
	 * @param array $rules
	 * @param array $messages
	 * @internal param CSV $csvfile
	 */
//    public function __construct($translator, $data, $rules, $messages)
//	{
//        parent::__construct($translator, $data, $rules, $messages);
//        $this->csvfile = app('App\Contracts\CSVReader');
//        $fileName = $this->saveFile($data['csvfile']);
//        $this->content_raw = $this->csvfile->open($fileName)->readAll();
//    }
//
//	/**
//	 * CSV Validator - has at least 2 rows
//	 *
//	 * @return bool
//	 */
//	public function validateHasData($attribute, $value, $parameters)
//	{
//		if (count($this->content_raw) < 2) {
//            $this->messages->add('csvfile', 'CSV must have at least 2 rows');
//            return false;
//        }
//        return true;
//	}
//
//	public function validateCorrectNumColumns($attribute, $value, $parameters)
//	{
//		$expecting = count(Bill::get_column_names());
//		$actual = count($this->content_raw[0]);
//		if ($expecting != $actual) {
//            $this->messages->add('csvfile', 'Incorrect number of columns. Expecting ' . $expecting . ', got ' . $actual);
//            return false;
//        }
//        return true;
//	}
//
//	/**
//	 * Ensure column names are correct
//	 *
//	 * @return string
//	 */
//	public function validateCorrectColumnNames($attribute, $value, $parameters)
//	{
//		foreach ($this->content_raw[0] as $index=>$value)
//		{
//			if (Bill::get_column_names()[$index] != $value)
//			{
//                $this->messages->add('csvfile', 'Column '.$index.': Expecting '.Bill::get_column_names()[$index].', got '.$value);
//                return false;
//			}
//		}
//		$this->content_raw = array_shift($this->content_raw);
//		return true;
//	}
}