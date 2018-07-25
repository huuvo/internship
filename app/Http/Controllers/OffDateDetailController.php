<?php

namespace App\Http\Controllers;
use App\DayOffDate;
use App\Http\Requests\OffDateRequest;
use App\Library;
use App\TotalDayOff;
use App\UserDetail;
use Carbon\Carbon;
use Constant;
use DateTime;
use Helper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Mail;

/**
 *|--------------------------------------------------------------------------
 *| UserDetaiL , OffDateDetailController
 *|--------------------------------------------------------------------------
 *| Package       : Internship
 *| @author       : Huuvh - INS215 - huuvh@ans-asia.com
 *| @created date : 2018/06/12
 *| Description   : function calss declaration OffDateDetailController
 */
class OffDateDetailController extends Controller {
	/**
	 *|--------------------------------------------------------------------------
	 *| UserDetaiL , function OffDatetDetail
	 *|--------------------------------------------------------------------------
	 *| Package       : Internship
	 *| @author       : Huuvh - INS215 - huuvh@ans-asia.com
	 *| @created date : 2018/06/12
	 *| Description   : function declaration Off Date Detail
	 */
	public function OffDatetDetail() {

		$offDateTypes = Helper::getUserOffDateTypeFromLibrary();

		$salaryTypes = Helper::getUserSalaryTypeFromLibrary();
		$userDateOffLeft = $this->getDateOffLeftOfUser();
		$users = $this->getUserById();
		$requester = $users->user_cd . ' : ' . $users->user_nm;
		$approvers = UserDetail::select('user_cd', 'user_nm')->where('deleted_flag', Constant::DELETED_FLAG_ZERO)->get();
		$row_number = DayOffDate::where('user_cd', '=', $users->user_cd)->max('row_number');
		return View('offdatedetail')
			->with(compact('offDateTypes'))
			->with(compact('salaryTypes'))
			->with(compact('requester'))
			->with(compact('row_number'))
			->with(compact('userDateOffLeft'))
			->with(compact('approvers'));
	}
	/**
	 *|--------------------------------------------------------------------------
	 *| DayOffDate , function getUserById
	 *|--------------------------------------------------------------------------
	 *| Package       : Internship
	 *| @author       : Huuvh - INS215 - huuvh@ans-asia.com
	 *| @created date : 2018/06/12
	 *| Description   : function declaration get User By Id
	 */
	private function getUserById() {

		$userId = Constant::USER_CD;
		$users = UserDetail::find($userId);
		return $users;
	}
	/**
	 *|--------------------------------------------------------------------------
	 *| DayOffDate , function getByDateOffLeft
	 *|--------------------------------------------------------------------------
	 *| Package       : Internship
	 *| @author       : Huuvh - INS215 - huuvh@ans-asia.com
	 *| @created date : 2018/06/12
	 *| Description   : function  declaration get By Date Off Left
	 */
	private function getTotalDayOffByUserId() {

		$userId = Constant::USER_CD;
		$usertotalDateOff = TotalDayOff::where('user_cd', $userId)->get();

		return $usertotalDateOff;
	}

	private function getDateOffLeftOfUser() {

		$usertotalDateOff = $this->getTotalDayOffByUserId();
		return $usertotalDateOff[0]->day_left;
	}

	/**
	 *|--------------------------------------------------------------------------
	 *| DayOffDate , function saveUserOffDate
	 *|--------------------------------------------------------------------------
	 *| Package       : Internship
	 *| @author       : Huuvh - INS215 - huuvh@ans-asia.com
	 *| @created date : 2018/06/18
	 *| Description   : save data from view to database, including create and update Off Date
	 */
	public function saveUserOffDate(OffDateRequest $req) {

		DB::beginTransaction();
		$user = $this->getUserById();
		$userId = $user->user_cd;
		$userOffDate = DayOffDate::find($userId);
		$row_number  = Input::get('row_number', null);

		try {

			$offdate_salary_type = Input::get('salaryType', null);
			$date_off_from 		 = Input::get('date_from', null);
			$date_off_to  		 = Input::get('date_to', null);
			$offdate_type 		 = Input::get('offDateType', null);
			$approval_id 		 = Input::get('approver', null);
			$reason 			 = Input::get('reason', null);
			$note 				 = Input::get('note', null);
			$row_number 		 = Input::get('row_number', null);
			
			if($row_number != null) {
				$row_number = $row_number +1;
				$updated_at	=$updated_at = now();
		
			}

			$offDateDetail = new DayOffDate();

			$offDateDetail->user_cd = $userId;
			$offDateDetail->row_number = $row_number;
			$offDateDetail->offdate_salary_type = $offdate_salary_type;
			$offDateDetail->date_off_to = $date_off_to;
			$offDateDetail->date_off_from = $date_off_from;
			$offDateDetail->offdate_type = $offdate_type;
			$offDateDetail->approval_id = $approval_id;
			$offDateDetail->reason = $reason;
			$offDateDetail->note = $note;
			$offDateDetail->deleted_flag = Constant::DELETED_FLAG_ZERO;
			$offDateDetail->created_at = now();
			$offDateDetail->created_by = $userId;
			$offDateDetail->updated_at =null;
			$offDateDetail->deleted_at = null;

			$offDateDetail->save();
			DB::commit();
			return response()->json(['success' => 'The registration information is successful',"row_number" => $offDateDetail->row_number]);

		} catch (\Throwable $e) {
			throw $e;
			DB::rollback();
			return response()->json(['success' => 'Could you please double check the inFromation at screen user detail']);
		}
	}

	/**
	 *|--------------------------------------------------------------------------
	 *| Date Off Detail , function numberByDayOff
	 *|--------------------------------------------------------------------------
	 *| Package       : Intership
	 *| @author       : Huuvh - INS215 - huuvh@ans-asia.com
	 *| @created date : 2018/06/13
	 *| Description   : Get date information for calculations
	 */
	private function numberByDayOff($userDateFrom, $userDateTo, $userDateOffType) {

		$morning = Constant::MORNING_IS_ONE;
		$afternon = Constant::AFTERNON_IS_TWO;
		$userDateFrom = new DateTime($userDateFrom);

		if (is_null($userDateTo)) {

			$userDateTo = Carbon::now();
		} else {
			$userDateTo = new DateTime($userDateTo);
		}

		$interval = $userDateFrom->diff($userDateTo);

		$registeredDate = $interval->d;

		$isHalfDay = $userDateOffType == $morning || $userDateOffType == $afternon;

		if ($isHalfDay && $registeredDate == 0) {
			$numberByDayOff = Constant::ONE_SECTION;
		} else {
			$numberByDayOff = $registeredDate;
		}

		return $numberByDayOff;
	}
/**
 *|--------------------------------------------------------------------------
 *| Date Off Detail , function getAddressByMail
 *|--------------------------------------------------------------------------
 *| Package       : Intership
 *| @author       : Huuvh - INS215 - huuvh@ans-asia.com
 *| @created date : 2018/06/13
 *| Description   : get address mail to send
 */
	private function getAddressByMail() {
		$mailTo = Constant::MAIL_TO;
		$mailCc = array('huuvh@ans-asia.com', 'huuvh@ans-asia.com');
		return array('mailTo' => $mailTo, 'mailCc' => $mailCc);
	}

	/**
	 *|----------------------------------------------------------------------- ---
	 *| Date Off Detail , function sendEmail
	 *|--------------------------------------------------------------------------
	 *| Package       : Intership
	 *| @author       : Huuvh - INS215 - huuvh@ans-asia.com
	 *| @created date : 2018/06/13
	 *| Description   :Get information to send mail
	 */
	public function sendEmail(OffDateRequest $req) {
		{
			$address = $this->getAddressByMail();
			$result_save = $this->saveUserOffDate($req)->getdate();

			$userDateOffLeft = $this->getDateOffLeftOfUser();

			$data = array(
				'email' 		=> 'honghuudl@gmail.com',
				'users' 		=> self::getUserById(),
				'offDateType' 	=> Library::select('name')->where('number', '=', $req->offDateType)->first(),
				'approval_id' 	=> $req->approver,
				'date_off_from' => $req->date_from,
				'date_off_to' 	=> $req->date_to,
				'reason' 		=> $req->reason,
				'note' 			=> $req->note,
				'address' 		=> $address,
			);

			Mail::send('emails.email_template', $data, function ($message) use ($data) {

				if ($data['date_off_to'] == null) {

					$sub = "[Đà Nẵng][Đăng kí Ngày nghỉ]" . $data['users']->user_nm . " xin nghỉ ngày " . $data['date_off_from'];
				} else {

					$sub = "[Đà Nẵng][Đăng kí Ngày nghỉ] " . $data['users']->user_nm . " xin nghỉ từ ngày " . $data['date_off_from'] . " đến ngày " . $data['date_off_to'];
				}

				$message->to($data['address']['mailTo'])->cc($data['address']['mailCc'])->subject($sub);
				$message->from('honghuudl@gmail.com', $data['users']->user_nm);
			});
			
			return response()->json();
		}
	}
/**
 *|--------------------------------------------------------------------------
 *| Date Off Detail  , function approval
 *|--------------------------------------------------------------------------
 *| Package       : Intership
 *| @author       : Huuvh - INS215 - huuvh@ans-asia.com
 *| @created date : 2018/06/14
 *| Description   : save approval and reject.
 */
	public function approval(Request $req) {

		$user = $this->getUserByID();
		$userId = $user->user_cd;

		$approverId = $req->approver;
		$action = $req->action;

		if ($action == "approval") {

			$action = Constant::APPROVAL;
		} else {

			$action = Constant::USER_REJECT;
		}

		DB::beginTransaction();

		try {

			DayOffDate::where('user_cd', $userId)
				->update(['approval_id' => $approverId,
					'approval' => $action,
					'updated_at' => now()]);

			$dateOffLeft = $this->getDateOffLeftOfUser();

			if ($dateOffLeft <= 0) {

				return response()->json(['success' => 'Your off date time is not enough, please try again']);
			}

			$userDateFrom 	 = $req->date_from;
			$userDateTo 	 = $req->date_to;
			$userDateOffType = $req->offDateType;
			$numberByDayOff  = $this->numberByDayOff($userDateFrom, $userDateTo, $userDateOffType);

			if ($req->action == "reject") {
				$day_left = $dateOffLeft + $numberByDayOff;
			}elseif ($req->action == "approval") {
				$day_left = $dateOffLeft - $numberByDayOff;
			} 
			TotalDayOff::where('user_cd', $userId)->update(['updated_at' => now(), 'day_left' => $day_left]);

			DB::commit();

			return response()->json(['success' => 'Success','day_left' => $day_left]);

		} catch (\Throwable $e) {
			return false;
			DB::rollback();
			throw $e;
			return response()->json(['success' => 'Could not "' . $action . '" user. Please double check the inFromation!']);
		}
	}

/**
 *|--------------------------------------------------------------------------
 *| Date Off Detail  , function approvalRefer
 *|--------------------------------------------------------------------------
 *| Package       : Intership
 *| @author       : Huuvh - INS215 - huuvh@ans-asia.com
 *| @created date : 2018/06/14
 *| Description   : approvalRefer
 */
	public function approvalRefer($id) {
		$approvalRefer = DayOffDate::where('approval_id', $id)
			->where('approval', '=', null)
			->get();

		return response()->json(['approvalRefer' => $approvalRefer]);
	}
	/**
	 *|--------------------------------------------------------------------------
	 *| Date Off Detail  , function deleteOffdatedetail
	 *|--------------------------------------------------------------------------
	 *| Package       : Intership
	 *| @author       : Huuvh - INS215 - huuvh@ans-asia.com
	 *| @created date : 2018/06/14
	 *| Description   : softy delete deleteOffdatedetail. Before deleting, check if row_number is existed or not
	 */
	public function deleteOffDateDetail(Request $req) {

		DB::beginTransaction();

		$user = $this->getUserById();

		try {

			$userOffDate = DayOffDate::where('user_cd', $user->user_cd)->where('row_number', $req->row_number)->get();

			if ($userOffDate != null) {

				DayOffDate::where('user_cd', $user->user_cd)->where('row_number', $req->row_number)
					->update(['deleted_at' => now(),
						'deleted_flag' => Constant::DELETED_FLAG_ONE,
					]);
				DB::commit();
				return response()->json(['success' => 'Delete User Successfully!']);
			}
		} catch (\Throwable $e) {
			DB::rollback();
			throw $e;
			return response()->json(['success' => 'Could not delete user. Please double check the inFromation!']);
		}
	}
}