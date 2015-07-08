<?php

namespace App;

use Symfony\Component\HttpFoundation\File\UploadedFile;

class CSVImportFile
{
    /**
     * @param $destinationPath
     * @param UploadedFile $file
     * @return string
     */
	private static function saveFile($destinationPath, UploadedFile $file)
	{
		$extension = $file->getClientOriginalExtension(); // getting file extension
		$fileName = rand(11111,99999).'.'.$extension; // renaming file
		$file->move($destinationPath, $fileName); // uploading file to given path

		return $destinationPath.'/'.$fileName;
	}

	/**
	 * Reads the contents of $file and returns as an array
	 *
	 * @param string $destinationPath
	 * @param UploadedFile $file
	 * @return mixed
     */
	public static function readFile($destinationPath = 'uploads', UploadedFile $file)
	{
        $csvfile = app('App\Contracts\CSVReader');
        return $csvfile->open(CSVImportFile::saveFile($destinationPath, $file))->readAll();
	}
}
