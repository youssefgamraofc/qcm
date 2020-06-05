<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::get('questions', 'Api\QuestionController@index');
Route::get('question/{id}', 'Api\QuestionController@show');

Route::get('filter/{pagination}/{type}', 'Api\QuestionController@filter');
Route::get('types', 'Api\QuestionController@showTypes');
Route::get('type/{id}', 'Api\QuestionController@getQuestionsByType');
Route::put('report/{id}', 'Api\QuestionController@report');
