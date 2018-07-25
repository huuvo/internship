<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OffDateRequest extends FormRequest {
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
			'approver' => 'required',
			// 'dayofftype'    => 'required',
			'dateFrom' => 'date|after:yesterday',
			'dateTo' => 'date|after_or_equal:dateFrom',
			'reason' => 'required|max:1000',
			'note' => 'max:1000',
		];
	}
	public function messages() {
		return [

			'approver.required' => 'The Approver is required.',
			// 'dayofftype.required'   => 'Please select the date type.',
			'dateFrom.date' => 'Please select the  date off.',
			// 'dateFrom.after'        => 'The Date From after tomorrow.',
			'dateTo.date' => ' Please select the  date off to.',
			// 'dateTo.after_or_equal' => 'The Date To is after or equal Date From.',
			'reason.required' => 'Please select the reason.',
			'reason.max' => 'The Reason is max = 1000.',
			'note.max' => 'The Note is max = 1000.',

		];
	}
}
