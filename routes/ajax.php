<?php

use Illuminate\Support\Facades\Auth;
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

Route::namespace('App\\Http\\Controllers\\Ajax')->group(function () {

    Route::prefix('employee')->namespace('Employee')->group(function () {
        Route::get('getEmployeesByCompanyId', 'MainController@getEmployeesByCompanyId')->name('ajax.employees-by-company-id');

        Route::post('updateQueues', 'MainController@updateQueues')->name('ajax.employee.updateQueues');
        Route::post('updateCompetences', 'MainController@updateCompetences')->name('ajax.employee.updateCompetences');
    });

    Route::prefix('queue')->namespace('Queue')->group(function () {
        Route::get('getQueuesByCompany', 'MainController@getQueuesByCompany')->name('ajax.queue.getQueuesByCompany');
    });

    Route::prefix('user')->namespace('User')->group(function () {
        Route::post('emailControl', 'MainController@emailControl')->name('ajax.emailControl');
    });

    Route::prefix('role')->namespace('Role')->group(function () {
        Route::post('permissionsUpdate', 'MainController@permissionsUpdate')->name('ajax.role.permissionsUpdate');
    });

    Route::prefix('monitoring')->namespace('Monitoring')->group(function () {
        Route::any('CallQueues', 'MainController@CallQueues')->name('ajax.monitoring.CallQueues');
        Route::any('GetJobList', 'MainController@GetJobList')->name('ajax.monitoring.GetJobList');
        Route::any('EmployeeAndJobTracking', 'MainController@EmployeeAndJobTracking')->name('ajax.monitoring.EmployeeAndJobTracking');
        Route::any('ShiftEmployeesLastSunday', 'MainController@ShiftEmployeesLastSunday')->name('ajax.monitoring.ShiftEmployeesLastSunday');
        Route::any('Abandon', 'MainController@Abandon')->name('ajax.monitoring.Abandon');
        Route::any('GetPointDay', 'MainController@GetPointDay')->name('ajax.monitoring.GetPointDay');
        Route::any('GetPointWeek', 'MainController@GetPointWeek')->name('ajax.monitoring.GetPointWeek');
        Route::any('GetMonthJobRanking', 'MainController@GetMonthJobRanking')->name('ajax.monitoring.GetMonthJobRanking');
    });

});
