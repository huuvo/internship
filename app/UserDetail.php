<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
/**
*|--------------------------------------------------------------------------
*| UserDetaiL , UserDetail
*|--------------------------------------------------------------------------
*| Package       : Internship  
*| @author       : Huuvh - INS215 - huuvh@ans-asia.com
*| @created date : 2018/05/24
*| Description   : UserDetail
*/
class UserDetail extends Model
{
     protected $table = "user";
     protected $primaryKey = 'user_cd';
     public $incrementing = false;
}
