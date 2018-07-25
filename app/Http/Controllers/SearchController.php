<?php
namespace App\Http\Controllers;
use App\Search;
use App\UserDetail;
use Constant;
use Helper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;

/**
 *|--------------------------------------------------------------------------
 *| UserDetaiL , SearchController
 *|--------------------------------------------------------------------------
 *| Package       : Internship
 *| @author       : Huuvh - INS215 - huuvh@ans-asia.com
 *| @created date : 2018/05/24
 *| Description   : function calss declaration SearchController
 */
class SearchController extends Controller {

	public function indexUserSearch(Request $req) {
		session()->forget(['user_cd', 'user_nm', 'user_ab', 'user_kn', 'user_adr', 'birth_day', 'gender']);

		$library = Helper::getUserGenderFromLibrary();
		return view('usersearch', ['usersearch' => null, 'library' => $library]);
	}
	/**
	 *|--------------------------------------------------------------------------
	 *| UserDetaiL , escapeLike
	 *|--------------------------------------------------------------------------
	 *| Package       : Internship
	 *| @author       : Huuvh - INS215 - huuvh@ans-asia.com
	 *| @created date : 2018/05/24
	 *| Description   :  function  declaration escapeLike
	 */
	private function escapeLike($str) {
		return str_replace(['\\', '%', '_', '['], ['\\\\', '\\%\\', '\_', '\['], $str);
	}

	/**
	 *|--------------------------------------------------------------------------
	 *| UserDetaiL , userSearch
	 *|--------------------------------------------------------------------------
	 *| Package       : Internship
	 *| @author       : Huuvh - INS215 - huuvh@ans-asia.com
	 *| @created date : 2018/05/24
	 *| Description   : call store procedure to get data with conditions search got From view
	 */
	public function userSearch(Request $req) {

		$user_cd = Input::get('user_cd', null);
		$user_nm = Input::get('user_nm', null);
		$user_ab = Input::get('user_ab', null);
		$user_kn = Input::get('user_kn', null);
		$user_adr = Input::get('user_adr', null);
		$birth_day = Input::get('birth_day', null);
		$gender = Input::get('gender');
		// keep data for input after submit
		$req->session()->put('user_cd', $user_cd);
		$req->session()->put('user_nm', $user_nm);
		$req->session()->put('user_ab', $user_ab);
		$req->session()->put('user_kn', $user_kn);
		$req->session()->put('user_adr', $user_adr);
		$req->session()->put('birth_day', $birth_day);
		$req->session()->put('gender', $gender);

		$userSearch = UserDetail::select('user_cd', 'user_nm', 'user_ab', 'user_kn', 'user_adr', 'birth_day', 'gender');
		$userSearch = $userSearch->where('deleted_flag', Constant::DELETED_FLAG_ZERO);

		if (!is_null($user_cd)) {
			$userSearch =$userSearch->where('user_cd', $user_cd);
		}
		
		if (!is_null($user_nm)) {

			$userSearch =$userSearch->where('user_nm', 'LIKE', '%' . $this->escapeLike($user_nm) . '%');
		}
		
		if (!is_null($user_ab)) {

			$userSearch =$userSearch>where('user_ab', 'LIKE', '%' . $this->escapeLike($user_ab) . '%');
		}

		if (!is_null($user_kn)) {
			$userSearch =$userSearch->where('user_kn', 'LIKE', '%' . $this->escapeLike($user_kn) . '%');
		}
		
		if (!is_null($user_adr)) {
			$userSearch =$userSearch->where('user_adr', 'LIKE', '%' . $this->escapeLike($user_adr) . '%');
		}

		if (!is_null($birth_day)) {
			$userSearch =$userSearch->where('birth_day', $birth_day);
		}

		if (!is_null($gender)) {
			$userSearch =$userSearch->where('gender', $gender);
		}

		$userSearch = $userSearch->paginate(Constant::ITEMS_PER_PAGE);

		$library = Helper::getUserGenderFromLibrary();

		return view('usersearch', ['usersearch' => $userSearch, 'library' => $library]);
	}

}
