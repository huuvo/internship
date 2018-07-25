<?php
namespace App\Helpers;
use App\Library;
use Constant;

class Helper {
	public static function getUserGenderFromLibrary() {
		return Library::where('library_id', '=', Constant::GENDER_ID)->orderBy('number', 'desc')->get();
	}
	public static function getUserOffDateTypeFromLibrary() {
		return Library::where('library_id', '=', Constant::OFF_DATE_TYPE_ID)->orderBy('number', 'desc')->get();
	}
	public static function getUserSalaryTypeFromLibrary() {
		return Library::where('library_id', '=', Constant::SALARY_TYPE_ID)->orderBy('number', 'desc')->get();
	}
	public static function getUserApprovlFromLibrary() {
		return Library::where('library_id', '=', Constant::APPROVL_ID)->orderBy('number', 'desc')->get();
	}

}
