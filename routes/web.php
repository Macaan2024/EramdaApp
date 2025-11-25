<?php

use App\Http\Controllers\AgencyCategoryController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthenticationController;
use App\Http\Controllers\AgencyController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\DashboardsController;
use App\Http\Controllers\DeploymentListController;
use App\Http\Controllers\EmergencyRoomBedController;
use App\Http\Controllers\EmergencyVehiclesController;
use App\Http\Controllers\IncidentController;
use App\Http\Controllers\IndexController;
use App\Http\Controllers\IndividualController;
use App\Http\Controllers\LogsController;
use App\Http\Controllers\MapController;
use App\Http\Controllers\ReceiveReportsController;
use App\Http\Controllers\SubmittedReportController;
use App\Http\Controllers\TreatmentServicesController;
use App\Http\Controllers\UserController;

/*
|--------------------------------------------------------------------------
| User Authentication Routes
|--------------------------------------------------------------------------
*/

Route::controller(IndexController::class)->group(function () {
    Route::get('/', 'index')->name('index');
});

Route::controller(AuthenticationController::class)->group(function () {
    Route::view('login', 'PAGES/welcome')->name('login');
    Route::get('register', 'register')->name('register');
    Route::post('submit-register', 'submitRegister');
    Route::post('submit-login', 'login');
    Route::post('submit-logout', 'logout')->name('logout');
});




Route::prefix('operation-officer')->name('operation-officer.')->middleware(['auth'])->group(function () {

    Route::controller(DashboardsController::class)->group(function () {
        Route::get('dashboard', 'bfpIndex')->name('dashboard');
    });

    Route::controller(UserController::class)->group(function () {
        Route::get('responder', 'responderIndex')->name('responder');
        Route::post('submit-responder', 'userSubmit')->name('submit-responder');
        Route::put('update/responder/{id}', 'userUpdate')->name('update-responder');
    });

    Route::controller(EmergencyVehiclesController::class)->group(function () {
        Route::get('vehicle', 'vehicleIndex')->name('vehicle');
        Route::post('submit-vehicle', 'addVehicles')->name('submit-vehicle');
        Route::put('update/vehicle/{id}', 'updateVehicle')->name('update-vehicle');
        Route::delete('delete/vehicle/{id}', 'deleteVehicle')->name('delete-vehicle');
    });

    Route::controller(SubmittedReportController::class)->group(function () {
        Route::get('submitted-report', 'index')->name('submitted-report');
        Route::get('report', 'reportIndex')->name('report');
        Route::view('add-reports/bfp', 'PAGES/bfp/add-report')->name('add-report');
        Route::post('submit-report', 'submitReports')->name('submit-report');
        Route::get('report/decline/{id}', 'decline')->name('decline-report');
        Route::get('report/accept/{id}', 'decline')->name('accept-report');
        Route::get('report/view/{id}', 'view')->name('view-report');
    });

    Route::controller(ReceiveReportsController::class)->group(function () {
        Route::get('receive', 'index')->name('receive');
    });

    Route::controller(DeploymentListController::class)->group(function () {
        Route::post('submit-deploy/{reportId}', 'submitDeploy')->name('submit-deploy');
    });

    Route::controller(AttendanceController::class)->group(function () {

        Route::get('attendance/Time-out/{shift}/{date}', 'attendanceIndexTwo')->name('attendance-time-out-page');

        Route::get('attendance/{shift}/{date}', 'attendanceIndex')->name('attendance');
        // Record Time-in

        // Show attendance page
        Route::get('attendance/{status}/{shift}/{date}', 'attendanceIndex')->name('attendance');

        // Time-in
        Route::post('attendance/time-in', 'attendanceTimeIn')->name('attendance-time-in');

        // Time-out
        Route::post('attendance/time-out', 'attendanceTimeOut')->name('attendance-time-out');

        // Absent
        Route::post('attendance/absent', 'attendanceAbsent')->name('attendance-absent');

        // Missed Time-out
        Route::post('attendance/missed-time-out', 'attendanceMissedTimeOut')->name('attendance-missed-time-out');

        // Cancel any attendance
        Route::delete('attendance/cancel/{id}', 'cancelAttendance')->name('attendance-cancel');
    });
});


Route::prefix('responder')->name('responder.')->middleware(['auth'])->group(function () {
    Route::controller(DashboardsController::class)->group(function () {
        Route::get('dashboard', 'responderIndex')->name('dashboard');
    });

    Route::controller(MapController::class)->group(function () {
        Route::get('nearest-hospital', 'nearestHospital')->name('nearest-hospital');
        Route::get('/nearest-hospital-beds/{agency_id}', 'getErBeds');
    });

    Route::controller(IncidentController::class)->group(function () {
        Route::get('incident/{reportId}/{latitude}/{longitude}', 'incidentIndex')->name('incident');
        Route::post('incident/submit', 'submitIncident')->name('submit-incident');
    });
});

Route::prefix('admin')->name('admin.')->middleware('admin')->group(function () {

    Route::controller(DashboardsController::class)->group(function () {
        Route::get('dashboard', 'adminIndex')->name('dashboard');
    });

    // 🔹 Admin Agencies Management
    Route::controller(AgencyController::class)->group(function () {
        Route::get('agency', 'index')->name('agency');
        Route::view('add/agency', 'PAGES/admin/add-agency')->name('add-agency');
        Route::post('submit-agency/agency', 'submitAgency')->name('submit-agency');
        Route::get('edit/agency/{id}', 'editAGency')->name('edit-agency');
        Route::patch('update/agency/{id}', 'updateAgency')->name('update-agency');
        Route::delete('delete/agency/{id}', 'deleteAgency')->name('delete-agency');
        Route::get('view/agency/{id}', 'viewAgency')->name('view-agency');
        Route::post('search/agency', 'index')->name('search-agency');
    });

    // 🔹 Admin User Management
    Route::controller(UserController::class)->group(function () {
        Route::get('user/{status}/{id?}', 'userIndex')->name('user');
        Route::post('search/user', 'userIndex')->name('search-user');
        Route::get('search/user', 'decline')->name('decline-user');
        Route::post('submit/user', 'userSubmit')->name('submit-user');
        Route::put('update/user/{id}', 'userUpdate')->name('update-user');
        Route::put('deactivate/user/{id}', 'userDeactivate')->name('deactivate-user');
        Route::put('activate/user/{id}', 'userActivate')->name('activate-user');
        Route::delete('delete/user/{id}', 'userDelete')->name('delete-user');
        Route::post('accept-user/{id}', 'accept')->name('accept-user');
        Route::post('decline-user/{id}', 'decline')->name('decline-user');
    });

    Route::controller(AgencyCategoryController::class)->group(function () {
        Route::get('agency-category/{id?}', 'index')->name('agency-category');
    });

    Route::controller(SubmittedReportController::class)->group(function () {
        Route::get('logs/reports/{status}/{id?}', 'reportLogs')->name('log-reports');
        Route::view('add/incident-reports', 'PAGES/admin/add-incident-reports')->name('add-incident-reports');
        Route::post('submit-reports/incident-reports', 'submitReports')->name('submit-reports');
    });
});

Route::prefix('nurse-chief')->name('nurse-chief.')->middleware('nurse-chief')->group(function () {
    Route::controller(DashboardsController::class)->group(function () {
        Route::get('dashboard/{status?}', 'nurseIndex')->name('dashboard');
    });
    Route::controller(EmergencyRoomBedController::class)->group(function () {
        Route::get('bed', 'index')->name('bed');
        Route::post('submit/bed', 'submitBed')->name('submit-bed');
        Route::put('edit/bed/{id}', 'editBed')->name('edit-bed');
        Route::delete('delete/bed/{id}', 'deleteBed')->name('delete-bed');
    });
    Route::controller(TreatmentServicesController::class)->group(function () {
        Route::get('services', 'index')->name('services');
        Route::post('submit/services', 'submitServices')->name('submit-services');
        Route::put('edit/services/{id}', 'editServices')->name('edit-services');
        Route::delete('delete/services/{id}', 'deleteServices')->name('delete-services');
    });
    Route::controller(IndividualController::class)->group(function () {
        Route::get('admit', 'index')->name('admit');
        Route::post('submit/admit', 'submitIndividual')->name('submit-admit');
        Route::patch('patient-release/{id}', 'releasePatient')->name('release-patient');
    });
});
