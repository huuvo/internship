<?php
namespace App\Http\Controllers;
use App\Http\Requests\UserDetailRequest;
use App\UserDetail;
use Carbon\Carbon;
use File;
use Helper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Response;

/**
 *|--------------------------------------------------------------------------
 *| UserDetaiL , UserController
 *|--------------------------------------------------------------------------
 *| Package       : Internship
 *| @author       : Huuvh - INS215 - huuvh@ans-asia.com
 *| @created date : 2018/05/24
 *| Description   : function calss declaration UserController
 */
class UserController extends Controller {
	/**
	 *|--------------------------------------------------------------------------
	 *| UserDetaiL , userdetail
	 *|--------------------------------------------------------------------------
	 *| Package       : Internship
	 *| @author       : Huuvh - INS215 - huuvh@ans-asia.com
	 *| @created date : 2018/05/24
	 *| Description   : userdetail
	 */
	public function userdetail() {

		$library = Helper::getUserGenderFromLibrary();
		return view('userdetail', ['library' => $library]);
	}
/**
 *|--------------------------------------------------------------------------
 *| UserDetaiL , saveUser
 *|--------------------------------------------------------------------------
 *| Package       : Internship
 *| @author       : Huuvh - INS215 - huuvh@ans-asia.com
 *| @created date : 2018/05/24
 *| Description   : save data from view to database, including create and update user
 */public function saveUser(UserDetailRequest $req) {

		DB::beginTransaction();

		try {

			$userId = $req->userid;

			$user = UserDetail::find($userId);

			if ($user == null) {

				$user = new UserDetail();
				$now = Carbon::now();
				$user->user_cd = $userId;
				$user->created_at = $now;
				$user->updated_at = $now;
			}

			$user->user_ab = $req->shortname;
			$user->user_kn = $req->kataname;
			$user->user_nm = $req->fullnames;
			$user->birth_day = $req->birthday;
			$user->gender = $req->gender;
			$user->user_adr = $req->address;
			$user->password = $req->passwords;
			$user->note = $req->note;
			$user->updated_at = null;
			$user->deleted_at = null;
			$user->deleted_flag = Constant::DELETED_FLAG_IT_ZERO;

			if ($req->avatar != null && $req->file('avatar')->isValid()) {

				$file = $req->file('avatar');
				$fileExtension = $file->getClientOriginalExtension();
				$currentPathFileName = "upload/img/" . $user->avatar;

				while (Storage::exists($currentPathFileName)) {
					Storage::delete($currentPathFileName);
				}

				$fileName = $user->user_cd . '.' . $fileExtension;
				$file->move("upload/img/", $fileName);
				$user->avatar = $fileName;
			} else {

				$image = $req->imgAvatar;
				// your base64 encoded
				$image = str_replace('data:image/png;base64,', '', $image);

				$image = str_replace(' ', '+', $image);
				$imageName = $user->user_cd . '.' . 'png';

				File::put("upload/img" . '/' . $imageName, base64_decode($image));
				$user->avatar = $imageName;
			}

			$user->save();

			DB::commit();

			return redirect('userdetail')->with('success', 'The inFromation updated success');

		} catch (\Throwable $e) {

			DB::rollback();
			return redirect('userdetail')->with('message', 'Could you please double check the inFromation at screen user detail');
		}

	}
/**
 *|--------------------------------------------------------------------------
 *| UserDetaiL , getUserdetailById
 *|--------------------------------------------------------------------------
 *| Package       : Internship
 *| @author       : Huuvh - INS215 - huuvh@ans-asia.com
 *| @created date : 2018/05/24
 *| Description   : UserdetailById
 */
	public function getUserdetailById($user_cd) {

		$library = Helper::getUserGenderFromLibrary();

		$userDetail = UserDetail::find($user_cd);

		if ($userDetail != null) {
			return view('userdetail', ['userDetail' => $userDetail, 'library' => $library]);
		} else {
			return redirect('userdetail')->with('notFound', 'Could not found user with userId:' . $user_cd);
		}
	}
/**
 *|--------------------------------------------------------------------------
 *| UserDetaiL , getEditUserdetailById
 *|--------------------------------------------------------------------------
 *| Package       : Internship
 *| @author       : Huuvh - INS215 - huuvh@ans-asia.com
 *| @created date : 2018/05/24
 *| Description   : get info of user by user_cd
 */
	public function getEditUserdetailById(Request $req) {
		$userDetail = UserDetail::where([['user_cd', '=', $req->userId], ['deleted_flag', '=', constant::DELETED_FLAG_IT_ZERO]])->get();
		return Response::json($userDetail);
	}
/**
 *|--------------------------------------------------------------------------
 *| UserDetaiL , deleteUserdetail
 *|--------------------------------------------------------------------------
 *| Package       : Internship
 *| @author       : Huuvh - INS215 - huuvh@ans-asia.com
 *| @created date : 2018/05/24
 *| Description   :  softy delete user. Before deleting, check if user_cd is existed or not
 */
	public function deleteUserdetail(Request $req) {

		DB::beginTransaction();

		try {

			$userId = $req->user_cd;
			$user = UserDetail::find($userId);

			if ($user == null) {
				return redirect('userdetail')->with('message', 'Could not found the user');
			}

			$user->deleted_flag = Constant::DELETED_FLAG_ONE;
			$user->deleted_at = Carbon::now();
			$user->avatar = null;

			$user->save();

			DB::commit();

			return redirect('userdetail')->with('deleteSuccess', 'Delete User successfully');

		} catch (\Throwable $e) {

			DB::rollback();

			return redirect('userdetail')->with('message', 'Could not delete user. Please double check the inFromation');
		}
	}

}