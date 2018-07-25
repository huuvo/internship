<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserDetailRequest extends FormRequest {
	/**
	 * Determine if the user is authorized to make this request.
	 *
	 * @return bool
	 */
	public function authorize() {
		return true;
	}

	/**
	 * Get the validation rules that apply to the request.
	 *
	 * @return array
	 */
	public function rules() {
		return [
			'userid' => 'required|max:10',
			'fullnames' => 'required',
			'passwords' => 'required|min:6|max:20',
			'avatar' => 'mimes:jpeg,jpg,png',

		];
	}
	public function messages() {
		return [

			'userid.required' => 'Please enter User Id ',
			'userid.max' => 'ID Used  at multiple 10 characters ',
			'fullnames.required' => 'Please enter  Fullname ',
			'password.required' => 'Please enter  Password ',
			'passwords.min' => 'Password at least 6 characters ',
			'passwords.max' => 'Password at multiple 20 characters ',
			'avatar' => 'Could you please choose fileExtension: jpg, png, jpeg',
		];
	}
}
