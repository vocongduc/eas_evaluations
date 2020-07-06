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

Route::middleware(['auth']) -> group(function () {
    Route::get('/', 'HomeController@index')->name('home');
    Route::get('profile/{id}','ProfileController@index')->name('profileList');

    Route::get('profile/edit/{id}','ProfileController@editProfile');
    Route::post('profile/edit/{id}','ProfileController@updateProfile');
    //Route Mainpoint
    Route::resource('mainpoints','MainPointsController');
    //Route Category
    Route::resource('categories','CategoryController');

    //Route Criteria
    Route::resource('criterias','CriteriaController');


    Route::resource('courses', 'CourseController');
    Route::resource('teams', 'TeamController');

    Route::prefix('users')->group(function () {
        Route::get('/', 'UserController@index')->name('users.index');
        Route::get('add', 'UserController@create')->name('users.add');
        Route::post('add', 'UserController@store')->name('users.store');
        Route::get('edit/{id}', 'UserController@edit')->name('users.edit');
        Route::post('edit/{id}', 'UserController@update')->name('users.update');
        Route::delete('/destroy/{id}', 'UserController@delete')->name('users.destroy');

        Route::prefix('permission')->group(function () {
            Route::get('/', 'PermissionController@index')->name('permission.index');
            Route::get('/add', 'PermissionController@create')->name('permission.add');
            Route::post('/add', 'PermissionController@store')->name('permission.store');
            Route::get('/edit/{id}', 'PermissionController@edit')->name('permission.edit');
            Route::post('/edit/{id}', 'PermissionController@update')->name('permission.update');
            Route::delete('/destroy/{id}', 'PermissionController@delete')->name('permission.destroy');
        });

        Route::prefix('role')->group(function () {
            Route::get('/', 'RoleController@index')->name('role.index');
            Route::get('/add', 'RoleController@create')->name('role.add');
            Route::post('/add', 'RoleController@store')->name('role.store');
            Route::get('/edit/{id}', 'RoleController@edit')->name('role.edit');
            Route::post('/edit/{id}', 'RoleController@update')->name('role.update');
            Route::delete('/destroy/{id}', 'RoleController@delete')->name('role.destroy');
        });
    });
    Route::resource('forms', 'FormController');
    Route::post('fetch_data', 'CriteriaDependentController@fetch')->name('fetch_data.fetch');
    Route::post('fetchDataFormPermit', 'DynamicDependentController@fetch')->name('dynamicDependent.fetch');
    Route::post('fetchDataTeamFormPermit', 'DynamicDependentController@fetchUser')->name('userCriteria.fetch');

    Route::prefix('evaluations')->group(function () {
        Route::get('/', 'EvaluationController@index')->name('evaluations.index');
        Route::get('/evaluate/{userId}/{formId}', 'EvaluationController@evaluate')->name('evaluations.evaluate');
        Route::post('/evaluate/{userId}/{formId}', 'EvaluationController@postEvaluate')->name('evaluations.postEvaluate');
        Route::get('/detail/{userId}/{formId}', 'EvaluationController@detail')->name('evaluations.detail');
    });

    Route::get('listPoints', 'HomeController@getPoint')->name('listpoint.getall');
    Route::get('flowChartAdmin', 'HomeController@FlowChartAdmin')->name('flowChartAdmin.getall');

    Route::resource('teamForm','TeamFormController');
    Route::post('listTeamAjax','TeamFormController@listTeamAjax')->name('listTeamAjax.fetch');
    Route::post('listCourseAjax','UserController@listCourseAjax')->name('listCourseAjax.fetchCourse');
    Route::resource('formPermit', 'FormPermitController');
    Route::post('listTeamByCourse','FormPermitController@listTeamByCourse')->name('listTeamByCourse.fetch');
});
