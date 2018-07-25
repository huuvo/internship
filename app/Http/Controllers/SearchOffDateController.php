<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Library;
use App\TotalDayOff;
use App\UserDetail;
use App\DayOffDate;
use Constant;
use Helper;
use Illuminate\Support\Facades\Input;

class SearchOffDateController extends Controller
{

/**
	*|--------------------------------------------------------------------------
	*| Date Off Search  , indexOffDateSearch
	*|--------------------------------------------------------------------------
	*| Package       : Internship 
	*| @author       : Huuvh - INS215 - huuvh@ans-asia.com
	*| @created date : 2018/06/25
	*| Description   : index Off Date Search
	*/
 public function indexOffDateSearch()
    {
    	
        $offDateTypes = Helper::getUserOffDateTypeFromLibrary();
		$salaryTypes = Helper::getUserSalaryTypeFromLibrary();
		$approvals = Helper::getUserApprovlFromLibrary();
		$users 		= UserDetail::all();
		$offDateSearch = null;
       return view('offdatesearch')
    	->with(compact('offDateSearch'))
    	->with(compact('offDateTypes'))
    	->with(compact('users'))
    	->with(compact('approvals'))
		->with(compact('salaryTypes'));
    }  
/**
	*|--------------------------------------------------------------------------
	*| Date Off Search  , offDateSearch
	*|--------------------------------------------------------------------------
	*| Package       : Internship 
	*| @author       : Huuvh - INS215 - huuvh@ans-asia.com
	*| @created date : 2018/06/25
	*| Description   : index Off Date Search
	*/
	public function offDateSearch(Request $req){

			$requester  			= Input::get('requester', null);
	        $approval 				= Input::get('approval', null);
	        $approverId 			= Input::get('approver', null);
	        $date_off_from 			= Input::get('date_from', null);
	        $date_off_to 			= Input::get('date_to', null);
	        $offdate_type 			= Input::get('offDateType', null);
	        $offdate_salary_type 	= Input::get('salaryType', null);
	        // keep data for input after submit
			$req->session()->put('requester', $requester);
			$req->session()->put('approval', $approval);
			$req->session()->put('date_from', $date_off_from);
			$req->session()->put('date_to', $date_off_to);
			$req->session()->put('offDateType', $offdate_type);
			$req->session()->put('salaryType', $offdate_salary_type);
			$offDateSearch = DayOffDate::join('user', 'offdatedetail.user_cd', '=', 'user.user_cd')
			->join('totaldateoff', 'user.user_cd', '=', 'totaldateoff.user_cd')
			->where('user.deleted_flag', '=', Constant::DELETED_FLAG_ZERO)
			->select('user.user_cd', 'user.user_nm', 'offdatedetail.row_number', 'offdatedetail.reason', 
            	'offdatedetail.offdate_type','offdatedetail.offdate_salary_type', 'offdatedetail.approval_id', 
            	'offdatedetail.approval', 'offdatedetail.date_off_from', 'offdatedetail.date_off_to','totaldateoff.day_left');

		if (!is_null($requester)) {

			$offDateSearch =$offDateSearch->where('offdatedetail.user_cd', $requester);
		}
		if (!is_null($approverId)) {

			$offDateSearch =$offDateSearch->where('offdatedetail.approval_id', $approverId);
		}
		
		if (!is_null($approval)) {
			$offDateSearch =$offDateSearch->where('offdatedetail.approval', $approval);
		}

		if (!is_null($offdate_type)) {
			$offDateSearch =$offDateSearch->where('offdatedetail.offday_type', $offdate_type);
		}
		
		if (!is_null($offdate_salary_type)) {
			$offDateSearch =$offDateSearch->where('offdatedetail.offdate_salary_type', $offdate_salary_type);
		}
		if (!is_null($date_off_from)) {
			$offDateSearch =$offDateSearch->where('offdatedetail.date_off_from', $date_off_from);
		}
		if (!is_null($date_off_to)) {
			$offDateSearch =$offDateSearch->where('offdatedetail.date_off_to', $date_off_to);
		}
	
		$offDateSearch = $offDateSearch->paginate(Constant::ITEMS_PER_PAGE);

		$offDateTypes = Helper::getUserOffDateTypeFromLibrary();
		$salaryTypes = Helper::getUserSalaryTypeFromLibrary();
		$approvals = Helper::getUserApprovlFromLibrary();
		$users 		= UserDetail::all();
		return view('offdatesearch', ['offDateSearch' => $offDateSearch,
			'offDateTypes' =>$offDateTypes, 'salaryTypes' =>$salaryTypes,
			'approvals' => $approvals, 'users' =>$users]);

	}
	/**
	*|--------------------------------------------------------------------------
	*| Date Off Search  , offDateSearch
	*|--------------------------------------------------------------------------
	*| Package       : Internship 
	*| @author       : Huuvh - INS215 - huuvh@ans-asia.com
	*| @created date : 2018/06/25
	*| Description   : index Off Date Search
	*/
	public function loadModalId(Request $req){

		$offDateSearchs = DayOffDate::where('user_cd',  $req->id)->get();
		$approval   = Library::where('library_id', Constant::APPROVL_ID)->get();

		foreach ($offDateSearchs as $offdatedetail) {
            $approver   = UserDetail::find($offdatedetail->approval_id);
            $offdatedetail->approval_id = $approver->user_cd . ' : ' . $approver->user_nm;
            foreach ($approval as $value) {
                if($offdatedetail->approval == $value->number){
                    $offdatedetail->approval = $value->name;
                }
            }
        }

		return response()->json(['listApprover' => $offDateSearchs]);
	}

}
