<?php

use Illuminate\Support\Facades\Route;

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

Auth::routes(['register' => false]);

Route::get('/questions/reported', 'QuestionController@reported')->name('questions.reported');
Route::get('/', 'HomeController@index')->name('home');
Route::get('/home', 'HomeController@index');
Route::get('/questions/create', 'QuestionController@create')->middleware('auth')->name('questions.create');
Route::get('/questions', 'QuestionController@index')->name('questions');
Route::get('/questions/validation', 'QuestionController@validation')->name('validation');
Route::get('/questions/validated', 'QuestionController@validated')->name('validated');
Route::get('questions/{id}',  'QuestionController@show')->name('show');
Route::post('/questions', 'QuestionController@store');
Route::patch('questions/validate/{id}', 'QuestionController@validate_quest')->name('validate');
Route::patch('questions/invalidate/{id}', 'QuestionController@invalidate_quest')->name('invalidate');
Route::get('questions/edit/{id}', 'QuestionController@edit')->name('edit');
Route::patch('questions/edit/{id}', 'QuestionController@update');
Route::delete('questions/delete/{id}', 'QuestionController@destroy')->name('delete');
Route::get('/questions/type/{id}', 'QuestionController@questionsByType')->name('questions.type');
