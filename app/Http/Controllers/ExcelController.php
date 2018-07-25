<?php

namespace App\Http\Controllers;
use App\UserDetail;
use Excel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Cell\DataType;
use PhpOffice\PhpSpreadsheet\Style\Border;
use Constant;
/**
 *|--------------------------------------------------------------------------
 *| UserDetaiL , userSearch
 *|--------------------------------------------------------------------------
 *| Package       : Internship
 *| @author       : Huuvh - INS215 - huuvh@ans-asia.com
 *| @created date : 2018/05/24
 *| Description   : function calss declaration ExcelController
 */
class ExcelController extends Controller {

	/**
	 *|--------------------------------------------------------------------------
	 *| User Search  , function exportExcel
	 *|--------------------------------------------------------------------------
	 *| Package       : Internship
	 *| @author       :  Huuvh - INS215 - huuvh@ans-asia.com
	 *| @created date : 2018/05/29
	 *| Description   : Export excel.
	 */
	public function exportExcel(Request $req) {
		$objExcel = IOFactory::load(public_path(Constant::EXCEL_TEMPLATE));

		$userData = $this->getsearchData($req);

		$this->fillDataToExcel($objExcel->getActiveSheet(), $userData);

		$writer = new Xlsx($objExcel);

		if (!is_dir(public_path(Constant::EXCEL_DIR))) {
			mkdir(public_path(Constant::EXCEL_DIR));
		}

		if (!is_dir(public_path(Constant::EXPORT_DIR))) {
			mkdir(public_path(Constant::EXPORT_DIR));
		}

		$path = Constant::EXPORT_DIR . '/' . time() . '_' . Constant::FILE_NAME_REPORT;
		$writer->save(public_path($path));

		return response()->json(['path' => $path,
			'userData' => $userData]);
	}

	/**
	 *|--------------------------------------------------------------------------
	 *| UserDetaiL , getsearchData
	 *|--------------------------------------------------------------------------
	 *| Package       : Internship
	 *| @author       : Huuvh - INS215 - huuvh@ans-asia.com
	 *| @created date : 2018/05/24
	 *| Description   : get search Data for excel
	 */
	private function getsearchData(Request $req) {

		$user_cd = Input::get('user_cd', null);
		$user_nm = Input::get('user_nm', null);
		$user_ab = Input::get('user_ab', null);
		$user_kn = Input::get('user_kn', null);
		$user_adr = Input::get('user_adr', null);
		$birth_day = Input::get('birth_day', null);
		$gender = Input::get('gender');

		$userSearch = UserDetail::select('user_cd', 'user_nm', 'user_ab', 'user_kn', 'user_adr', 'birth_day', 'gender');
		$userSearch = $userSearch->where('deleted_flag', Constant::DELETED_FLAG_IT_ONE);
		if (is_null($user_cd)) {
		$userSearch =$userSearch
		}	else {
		$userSearch =$userSearch->where('user_cd', $user_cd);
		}
		if (is_null($user_nm)) {
			$userSearch =$userSearch
		}	else {
			$userSearch =$userSearch->where('user_nm', 'LIKE', '%' . $this->escapeLike($user_nm) . '%');
		}
		if (is_null($user_ab)) {
			$userSearch =$userSearch
		}	else {
			$userSearch =$userSearch>where('user_ab', 'LIKE', '%' . $this->escapeLike($user_ab) . '%');
		}
		if (is_null($user_kn)) {
			$userSearch =$userSearch
		}	else {
			$userSearch =$userSearch->where('user_kn', 'LIKE', '%' . $this->escapeLike($user_kn) . '%');
		}
		if ( is_null($user_adr)) {
			$userSearch =$userSearch
		}	else {
			$userSearch =$userSearch->where('user_adr', 'LIKE', '%' . $this->escapeLike($user_adr) . '%');
		}
		if (is_null($birth_day)) {
			$userSearch =$userSearch
		}	else {
			$userSearch =$userSearch->where('birth_day', $birth_day);
		}
		if (is_null($gender)) {
			$userSearch =$userSearch
		}	else {
			$userSearch =$userSearch->where('gender', $gender);
		}
		return $userSearch->get();
	}
	/**
	 *|--------------------------------------------------------------------------
	 *| User Search  , function fillDataToExcel
	 *|--------------------------------------------------------------------------
	 *| Package       : 2018/05/24
	 *| @author       :  Huuvh - INS215 - huuvh@ans-asia.com
	 *| @created date : 2018/05/29
	 *| Description   : fill Data To Excel
	 */
	private function fillDataToExcel($setCell, $userData) {

		$index = 1;
		$startContent = 6;

		foreach ($userData as $key => $item) {

			$year = null;
			$month = null;
			$day = null;

			if ($item->birth_day != null) {
				$birth_day = explode('-', $item->birth_day);
				$year = $birth_day[0];
				$month = $birth_day[1];
				$day = $birth_day[2];
			}
			$setCell
				->setCellValue('A' . $startContent, $index)
				->setCellValueExplicit('B' . $startContent, $item->user_cd, DataType::TYPE_STRING)
				->setCellValueExplicit('C' . $startContent, $item->user_nm, DataType::TYPE_STRING)
				->setCellValueExplicit('D' . $startContent, $item->user_kn, DataType::TYPE_STRING)
				->setCellValue('E' . $startContent, $day)
				->setCellValue('F' . $startContent, $month)
				->setCellValue('G' . $startContent, $year)
				->setCellValue('H' . $startContent, '=IF(' . $item->gender . '=1,"Male",IF(' . $item->gender . '=2,"Female","Unknow"))');

			$index++;
			$startContent++;
		}
		$setCell->getStyle("A6:H6")->applyFromArray(array(
			'borders' => array(
				'outline' => array(
					'borderStyle' => Border::BORDER_THIN,
					'color' => array('argb' => Constant::BLACK_COLOR),
					'size' => Constant::BORDER_SIZE,
				),
				'horizontal' => array(
					'borderStyle' => Border::BORDER_DASHED,
					'color' => array('argb' => Constant::BLACK_COLOR),
					'size' => Constant::BORDER_SIZE,
				),
				'vertical' => array(
					'borderStyle' =>Border::BORDER_THIN,
					'color' => array('argb' => Constant::BLACK_COLOR),
					'size' => Constant::BORDER_SIZE,
				),
			),
		));
		return $this;
	}

}
