<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('data/uploadData', 'Api\DataController@upload');
Route::get('data/uploadOptions', 'Api\DataController@getUploadComponentData');

Route::get('counties', 'Api\DataController@getCounties');
Route::post('counties/pilot', 'Api\DataController@updatePilotCounties');
Route::get('counties/pilot', 'Api\DataController@getPilotCounties');

Route::prefix('data')->group(function(){
	Route::post('counties/pilot/opd-ipd', 'Api\DataController@getPilotCountyIPDOPDData');
	Route::post('counties/facility/level/{dataType}', 'Api\DataController@getOPDIPDLevelofFacility');

	Route::get('types', function(){
		return \App\Enums\DataType::toSelectArray();
	});

	Route::get('names/{type}', 'Api\DataController@getDataNamesByType');
	Route::get('search', 'Api\DataController@searchDataField');

	Route::post('name/type/add', 'Api\DataController@addDataWithType');
	Route::get('counties/population', 'Api\DataController@getCountyPopulation');

	Route::get('referrals/{county_id}', 'Api\DataController@getFacilityReferralData');
	Route::get('los/{county_id}', 'Api\DataController@getLengthOfStay');
	Route::get('utilization/sector/opd-ipd/{county_id}', 'Api\DataController@getOPDIPDBySector');

	Route::get('geographical/county/{county}', 'Api\DataController@getGeographicalDataOfCounty');
	Route::get('pyramid', 'Api\DataController@getPyramid');
});