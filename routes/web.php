<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthenticationController;
use App\Http\Controllers\AgencyController;
use App\Http\Controllers\DashboardsController;
use App\Http\Controllers\EmergencyRoomBedController;
use App\Http\Controllers\EmergencyVehiclesController;
use App\Http\Controllers\IncidentReportsController;
use App\Http\Controllers\IndividualController;
use App\Http\Controllers\LogsController;
use App\Http\Controllers\PersonnelRespondersController;
use App\Http\Controllers\SubmittedReportController;
use App\Http\Controllers\TreatmentServicesController;
use App\Http\Controllers\UserController;


/*
|--------------------------------------------------------------------------
| User Authentication Routes
|--------------------------------------------------------------------------
*/

Route::controller(AuthenticationController::class)->group(function () {
    Route::view('/', 'PAGES/welcome')->name('/');
    Route::get('register', 'register')->name('register');
    Route::post('submit-register', 'submitRegister');
    Route::post('submit-login', 'login');
    Route::post('submit-logout', 'logout')->name('logout');
});




Route::prefix('bfp')->name('bfp.')->group(function () {

    Route::controller(PersonnelRespondersController::class)->group(function () {
        Route::get('responders', 'index')->name('responders');
        Route::get('add-responder', 'register')->name('add-responders'); //done
        Route::post('submit-responder', 'addResponders')->name('submit-responders'); //done
        Route::delete('delete-responder/{id}', 'destroy')->name('delete-responders'); //done
        Route::get('edit-responder/{id}', 'edit')->name('edit-responders'); //done
        Route::put('update-responder/{id}', 'updateResponders')->name('update-responders'); //done
        Route::get('search', 'index')->name('search-responders'); //done
        Route::get('view-responders/{id}', 'show')->name('view-responders'); //done
    });

    Route::controller(EmergencyVehiclesController::class)->group(function () {
        Route::get('vehicles', 'index')->name('vehicles'); //done
        Route::view('vehicles/add-vehicles', 'PAGES/BFP_BDRRMC/add-vehicles')->name('add-vehicles'); //done
        Route::post('submit-vehicles', 'addVehicles')->name('submit-vehicles'); //done
        Route::delete('delete-vehicles/{id}', 'destroy')->name('delete-vehicles'); //done
        Route::get('vehicles/edit-responders/{id}', 'edit')->name('edit-vehicles'); //done
        Route::put('vehicles/update-responders/{id}', 'updateVehicles')->name('update-vehicles'); //done
        Route::get('vehicles/search', 'index')->name('search-vehicles'); //done
        Route::get('vehicles/view-vehicles/{id}', 'show')->name('view-vehicles'); //done
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
        Route::post('update/agency/{id}', 'updateAgency')->name('update-agency');
        Route::delete('delete/agency/{id}', 'deleteAgency')->name('delete-agency');
        Route::get('view/agency/{id}', 'viewAgency')->name('view-agency');
        Route::post('search/agency', 'searchAgency')->name('search-agency');
    });

    // 🔹 Admin User Management
    Route::controller(UserController::class)->group(function () {
        Route::get('user/{status}/{id?}', 'userIndex')->name('user');
        Route::post('submit/user', 'userSubmit')->name('submit-user');
        Route::put('update/user/{id}', 'userUpdate')->name('update-user');
        Route::post('deactivate/user{id}', 'userDeactivate')->name('deactivate-user');
        Route::delete('delete/user/{id}', 'userDelete')->name('delete-user');
    });

    Route::controller(LogsController::class)->group(function () {
        //manage logs
        Route::get('logs/{status}', 'index')->name('logs');

        // User logs
        Route::get('logs-users/{status}/{id?}', 'userLogs')->name('logs-users');
        Route::get('logs-view-users/{id}', 'showUser')->name('logs-view-users');
        Route::post('logs-add-users', 'addUsers')->name('logs-add-users'); // Store user
        Route::get('logs-edit-users/{id}', 'editUser')->name('logs-edit-users');
        Route::put('logs-update-users/{id}', 'updateUser')->name('logs-update-users');
        Route::delete('logs-delete-users/{id}', 'destroyUser')->name('logs-delete-users');
        Route::put('logs-restore-users/{id}', 'restoreUser')->name('logs-restore-users');


        // Vehicles log Controller

        Route::get('logs-vehicles/{status}/{id?}', 'vehicleLogs')->name('logs-vehicles');
        Route::get('logs-view-vehicles/{id}', 'showVehicle')->name('logs-view-vehicles');
        Route::get('logs-vehicles-add', 'vehiclesAdd')->name('logs-vehicles-add');
        Route::post('logs-add-vehicles', 'addVehicles')->name('logs-add-vehicles');
        Route::get('logs-edit-vehicles/{id}', 'edit')->name('logs-edit-vehicles');
        Route::put('logs-update-vehicles/{id}', 'updateVehicles')->name('logs-update-vehicles');
        Route::delete('logs-delete-vehicles/{id}', 'destroyVehicle')->name('logs-delete-vehicles');
        Route::put('logs-restore-vehicles/{id}', 'restoreVehicle')->name('logs-restore-vehicles');
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
        Route::patch('patient-release/{id}', 'releasePatient')->name('nurse-chief.release-patient');
    });
});
