<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 *|--------------------------------------------------------------------------
 *| UserDetaiL , offdatedetail
 *|--------------------------------------------------------------------------
 *| Package       : Internship
 *| @author       : Huuvh - INS215 - huuvh@ans-asia.com
 *| @created date : 2018/05/24
 *| Description   : offdatedetail
 */
class DayOffDate extends Model {
	protected $table = "offdatedetail";
	protected $primaryKey = 'user_cd';
	public $incrementing = false;
	protected $fillable = ['user_cd', 'row_number', 'offday_type', 'offdate_salary_type', 'approval_id', 'approval', 'date_off_from', 'date_off_to', 'reason', 'note', 'update_by','deleted_by', 'deleted_flag'];

}