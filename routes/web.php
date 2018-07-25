<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
 */
// for  method GET
Route::get('userdetail', 'UserController@userdetail');
Route::get('userdetailbyid', 'UserController@getEditUserdetailById');
Route::any('userdetail/{user_cd}', 'UserController@getUserdetailById');
Route::get('user/search/index', 'SearchController@indexUserSearch');
Route::get('user/exportexcel', 'ExcelController@exportExcel');
Route::get('offdatedetail', 'OffDateDetailController@OffDatetDetail');
Route::get('offdate/search/index', 'SearchOffDateController@indexOffDateSearch');

// for method POST
Route::post('userdetailbyid', [
	'as' => 'getEditUserdetailById',
	'uses' => 'UserController@getEditUserdetailById',
]);
Route::post('saveUser', [
	'as' => 'saveUser',
	'uses' => 'UserController@saveUser',
]);
Route::post('saveUserOffDate', [
	'as' => 'saveUserOffDate',
	'uses' => 'OffDateDetailController@saveUserOffDate',
]);

Route::any('user/search/list', [
	'as' => 'user/search/list',
	'uses' => 'SearchController@userSearch',
]);
Route::any('offdate/search/list', [
	'as' => 'offdate/search/list',
	'uses' => 'SearchOffDateController@offDateSearch',
]);

Route::any('offdatedetail/delete', 'OffDateDetailController@deleteOffDateDetail');
Route::any('userdetail/delete/{user_cd}', 'UserController@deleteUserdetail');
Route::any('approvalRefer/{id}', 'OffDateDetailController@approvalRefer');
Route::post('approval', 'OffDateDetailController@approval');
Route::post('sendemail', 'OffDateDetailController@sendEmail');
Route::post('reject', 'OffDateDetailController@userReject');
Route::post('viewapprover', 'SearchOffDateController@loadModalId');