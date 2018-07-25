<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 *|--------------------------------------------------------------------------
 *| UserDetaiL , totaldateoff
 *|--------------------------------------------------------------------------
 *| Package       : Internship
 *| @author       : Huuvh - INS215 - huuvh@ans-asia.com
 *| @created date : 2018/05/24
 *| Description   : totaldateoff
 */
class TotalDayOff extends Model {
	protected $table = "totaldateoff";
	protected $primaryKey = 'user_cd';
	public $incrementing = false;
}
