<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MastersController;
use App\Http\Controllers\TransactionsController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\ReportsController;
use App\Http\Controllers\ImportController;
use App\Http\Controllers\OfficeController;
use App\Http\Controllers\ConfigurationController;
use App\Http\Controllers\Controller;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    //return view('welcome');
  
return redirect('/login');
});


Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified'
])->group(function () {
    Route::get('/dashboard',[Controller::class,'getDashboard'])->name('dashboard');

//Masters Routes Start Here
Route::get('/master/state',[MastersController::class , 'statemaster'])->name('statemaster');
Route::get('/master/district',[MastersController::class , 'districtmaster'])->name('districtmaster');
Route::get('/master/designation',[MastersController::class , 'designationmaster'])->name('designationmaster');
Route::get('/master/payscale',[MastersController::class , 'payscalemaster'])->name('payscalemaster');
Route::get('/master/department',[MastersController::class , 'departmentmaster'])->name('departmentmaster');
Route::get('/master/subdepartment',[MastersController::class , 'subdepartmentmaster'])->name('subdepartmentmaster');
Route::get('/master/district/constituency',[MastersController::class , 'districtconstituencymaster'])->name('districtconstituencymaster');
Route::get('/master/office',[MastersController::class , 'officemaster'])->name('officemaster');
Route::get('/master/booth',[MastersController::class , 'boothmaster'])->name('boothmaster');
Route::get('/master/boothlocn',[MastersController::class , 'boothlocnmaster'])->name('boothlocnmaster');
//Masters Routes Ends Here


//Transaction Routes Start Here
Route::get('/transactions/employee',[TransactionsController::class , 'employeedata'])->name('employeedata');
Route::get('/transactions/employee/add',[TransactionsController::class , 'employeedataadd'])->name('employeedataadd');
Route::get('/transactions/employee/edit/{id}',[TransactionsController::class , 'employeedataedit'])->name('employeedataedit');
//Transaction Routes Ends Here
Route::get('/transactions/submitted',[TransactionsController::class , 'submittedOffices'])->name('submittedOffices');
Route::get('/transactions/submitted/{id}',[TransactionsController::class , 'submittedData'])->name('submittedData');

Route::get('/transactions/finalized',[TransactionsController::class , 'finalizedOffices'])->name('finalizedOffices');
Route::get('/transactions/exemption',[TransactionsController::class , 'exemption'])->name('exemption');
//DEO Transaction Routes Start Here

//DEO Transaction Routes Ends Here

//Reports Routes Starts Here
Route::get('/reports/customizedchecklist',[ReportsController::class , 'customchecklistdata'])->name('customchecklistdata');
Route::get('/reports/undertaking',[ReportsController::class , 'undertaking'])->name('undertaking');
Route::get('/reports/designationmaster',[ReportsController::class , 'designationmaster'])->name('reportdesignationmaster');
Route::get('/reports/payscalemaster',[ReportsController::class , 'payscalemaster'])->name('reportpayscalemaster');
Route::get('/reports/exemptionlist',[ReportsController::class , 'exemptionlist'])->name('exemptionlist');
Route::get('/reports/emailchecklist',[ReportsController::class , 'emailchecklist'])->name('emailchecklist');

//Reports Here

//User Management Routes Starts Here
Route::get('/users',[UsersController::class , 'users'])->name('users');
Route::get('/users/privileges',[UsersController::class , 'privileges'])->name('privileges');

//UMR Ends Here

//Import Routes Start Here
Route::get('/import/pulldata',[ImportController::class , 'index'])->name('index');
Route::get('/import/hrmsdata',[ImportController::class , 'importhrmsdata'])->name('importhrmsdata');

Route::get('/import/connection',[ImportController::class , 'connection'])->name('connection');

//Others
Route::get('/office/detail/{key}',[OfficeController::class , 'officedetail'])->name('officedetail');

//photo capture
Route::get('/webcam-capture', [Controller::class,'webCapture'])->name('webCapture');

//Configuration Controller starts here
Route::get('/configure', [ConfigurationController::class,'portalConfiguration'])->name('portalConfiguration');

//Configuration Controller ends here



});
