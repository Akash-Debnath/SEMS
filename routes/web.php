<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\NoticeController;
use App\Http\Controllers\NoteController;
use App\Http\Controllers\PolicyController;
use App\Http\Controllers\AttachFilesController;
use App\Http\Controllers\FacilityController;
use App\Http\Controllers\IncidentController;
use App\Http\Controllers\HolidayController;
use App\Http\Controllers\LeavesController;
use App\Http\Controllers\JobDescriptionController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\DesignationController;
use App\Http\Controllers\ArchiveController;
use App\Http\Controllers\RamadanController;
use App\Http\Controllers\EvaluationController;
use App\Http\Controllers\RolesController;
use App\Http\Controllers\Late_early_reqController;
use App\Http\Controllers\leaveRequestController;
use App\Http\Controllers\pendingLeaveController;
use App\Http\Controllers\Missing_attendanceController;
use App\Http\Controllers\AdministratorPrivilegeController;
use App\Http\Controllers\EmpTodayController;
use App\Http\Controllers\PermissionPrivilegeController;
use App\Http\Controllers\OfficeTimeController;
use App\Http\Controllers\OfficeScheduleController;
use App\Http\Controllers\RosterSetController;
use App\Http\Controllers\RosterPendingController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\Leave_at_a_glanceController;
use Illuminate\Support\Facades\Auth;

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



// Auth::routes();
Auth::routes([
    'register' => false, // Registration Routes
    'reset' => false, // Password Reset Routes
    'verify' => false, // Email Verification Routes
]);


Route::group(['middleware' => 'auth'], function () {

    // @author Akash Chandra Debnath routes start here
    Route::get('/', [HomeController::class, 'index']);
    Route::get('change-password', [HomeController::class, 'changePasswordViewFile']);
    Route::post('new-password-set', [HomeController::class, 'changePassword']);

    Route::resource('employees', EmployeeController::class);
    Route::post('add-facility', [EmployeeController::class, 'createFacility']);
    Route::get('edit-facility/{id}', [EmployeeController::class, 'editFacility']);
    Route::put('update-facility', [EmployeeController::class, 'updateFacility']);
    Route::delete('facility-delete/{id}', [EmployeeController::class, 'deleteFacility']);
    Route::delete('delete-status/{id}', [EmployeeController::class, 'deleteStatus']);
    Route::post('add-status', [EmployeeController::class, 'createStatus']);
    Route::post('add-grade', [EmployeeController::class, 'createGrade']);
    Route::put('update-grade/{id}', [EmployeeController::class, 'updateGrade']);
    Route::put('archive-employee/{id}', [EmployeeController::class, 'employeeArchive']);
    Route::post('edit-employee-info', [EmployeeController::class, 'editEmployeeInfo']);
    Route::get('profile-update-request', [EmployeeController::class, 'profileUpdateRequest']);

    Route::resource('notice', NoticeController::class);

    Route::resource('attachment', AttachFilesController::class);
    Route::delete('delete-attachment-file/{id}', [AttachFilesController::class, 'deleteAttachmentFile']);

    Route::resource('policy', PolicyController::class);

    Route::resource('holiday', HolidayController::class);
    Route::get('holiday', [HolidayController::class, 'searchHoliday']);
    Route::get('edit-holiday/{id}', [HolidayController::class, 'edit']);
    Route::put('update-holiday', [HolidayController::class, 'update']);

    Route::resource('incident', IncidentController::class);
    Route::get('edit-incident/{id}', [IncidentController::class, 'edit']);
    Route::put('update-incident', [IncidentController::class, 'update']);
    Route::get('incident', [IncidentController::class, 'searchIncident']);

    Route::resource('archive', ArchiveController::class);

    Route::resource('department', DepartmentController::class);
    Route::get('edit-department/{id}', [DepartmentController::class, 'edit']);
    Route::put('update-department', [DepartmentController::class, 'update']);

    Route::resource('designation', DesignationController::class);
    Route::get('edit-designation/{id}', [DesignationController::class, 'edit']);
    Route::put('update-designation', [DesignationController::class, 'update']);

    Route::resource('facility', FacilityController::class);
    Route::get('edit-facility/{id}', [FacilityController::class, 'edit']);
    Route::put('update-facility', [FacilityController::class, 'update']);

    Route::resource('note', NoteController::class);
    Route::get('edit-note/{id}', [NoteController::class, 'edit']);
    Route::put('update-note', [NoteController::class, 'update']);

    Route::resource('ramadan', RamadanController::class);
    Route::get('edit-ramadan/{id}', [RamadanController::class, 'edit']);
    Route::put('update-ramadan', [RamadanController::class, 'update']);

    Route::get('evaluation-details/{id}', [EvaluationController::class, 'index']);
    Route::get('evaluations/{id}/{empId}', [EvaluationController::class, 'show']);
    Route::resource('evaluation', EvaluationController::class);

    Route::resource('adminpriv', AdministratorPrivilegeController::class);
    Route::post('admin-privileger', [AdministratorPrivilegeController::class, 'adminPrivilege']);
    Route::post('roster-privileger', [AdministratorPrivilegeController::class, 'rosterPrivilege']);
    Route::post('management-privileger', [AdministratorPrivilegeController::class, 'managementPrivilege']);
    Route::delete('admin-delete/{id}', [AdministratorPrivilegeController::class, 'deleteAdmin']);
    Route::delete('roster-delete/{id}', [AdministratorPrivilegeController::class, 'deleteRoster']);
    Route::delete('management-delete/{id}', [AdministratorPrivilegeController::class, 'deleteManagement']);

    Route::resource('permission-priv', PermissionPrivilegeController::class);

    Route::resource('office-time', OfficeTimeController::class);
    Route::put('schecule-update/{id}', [OfficeTimeController::class, 'updateRoster']);
    Route::put('roster-update/{id}', [OfficeTimeController::class, 'updateRoster']);

    Route::resource('roles', RolesController::class);
    // @author Akash Chandra Debnath routes end here


    //@author Tahrim Kabir routes start here 
    Route::resource('jobdescription', JobDescriptionController::class);
    Route::resource('job', JobDescriptionController::class);
    Route::get('edit-jobdesc/{id}', [JobDescriptionController::class, 'edit']);
    Route::post('job-update/', [JobDescriptionController::class, 'update']);

    Route::get('office-schedule', [OfficeScheduleController::class, 'getIndex']);
    Route::post('office-schedule', [OfficeScheduleController::class, 'officeSchedule'])->name('officeSchedule');

    // Route::resource('set-roster', RosterSetController::class);
    Route::get('set-roster', [RosterSetController::class, 'setRoster']);
    Route::post('set-roster', [RosterSetController::class, 'setRoster']);
    Route::post('roster-set-same-time', [RosterSetController::class, 'setRosterSameTime']);
    Route::post('set-roster-more-weekend', [RosterSetController::class, 'setRosterMoreWeekend']);
    Route::post('roster-set-custom-time', [RosterSetController::class, 'setRosterCustomTime']);
    Route::post('roster-slot-data', [RosterSetController::class, 'setRosterSlotData']);
    Route::post('add-roster-slot', [RosterSetController::class, 'store']);
    Route::post('upate-roster-slot/{id}', [RosterSetController::class, 'update']);
    Route::get('delete-slot/{id}', [RosterSetController::class, 'destroy']);

    Route::resource('roster/holiday-request', RosterPendingController::class);
    // Route::resource('approve-roster-holidays', RosterPendingController::class);

    Route::get('/leave-list', [LeavesController::class, 'leaves'])->name('leaves');
    Route::get('/leave-list', [LeavesController::class, 'showLeave'])->name('leave.show');
    Route::post('/leave-list', [LeavesController::class, 'employeeLeave'])->name('emp.leave');
    Route::get('/leave-list', [LeavesController::class, 'showEmployee_leaveList'])->name('emp.list');
    Route::get('search-today-leave', [LeavesController::class, 'todayLeaveIndex']);
    Route::post('search-today-leave', [LeavesController::class, 'searchLeave'])->name('searchLeave');
    Route::get('/yearly-leave', [LeavesController::class, 'yearlyLeave']);
    Route::get('/yearly-leave', [LeavesController::class, 'showYearlyLeave']);
    Route::get('/multiple-department-employees', [LeavesController::class, 'showMultipleEmpByDept']);
    Route::post('/yearly-leave', [LeavesController::class, 'searchYearlyLeave'])->name('emp.show');


    Route::get('leave-request-form', [LeaveRequestController::class, 'showForm']);


    Route::get('pending-leave', [pendingLeaveController::class, 'index']);
    Route::get('/view-leave/{eid?}/{id?}/{date?}', [pendingLeaveController::class, 'show'])->name('viewLeave');
    Route::get('delete-leave/{id?}', 'App\Http\Controllers\pendingLeaveController@deleteLeave')->name('deleteLeave');
    Route::post('cancel-req/{id?}', 'App\Http\Controllers\pendingLeaveController@cancel_req')->name('cancel_req');
    Route::post('cancel-approve/{id?}', 'App\Http\Controllers\pendingLeaveController@cancel_approve')->name('cancel_approve');
    Route::post('approve-leave/{id?}', 'App\Http\Controllers\pendingLeaveController@update')->name('approve.update');
    Route::post('verify-leave/{id?}', 'App\Http\Controllers\pendingLeaveController@Leave_Verify')->name('Leave_Verify.update');

    Route::get('edit-leave-request-form/{eid?}/{id?}/{date?}', [pendingLeaveController::class, 'editLeave'])->name('editLeave');
    Route::post('update-leave-request/{id?}', [pendingLeaveController::class, 'updateLeaveRequest'])->name('updateLeaveRequest');

    Route::get('setting', [SettingController::class, 'index'])->name('setting.index');
    Route::post('setting', [SettingController::class, 'store'])->name('store');
    Route::post('edit-weekend/{id}', [SettingController::class, 'weekend'])->name('weekend.store');
    Route::post('edit-cmn-leave/{id}', [SettingController::class, 'cmnLeave'])->name('cmnleave.store');
    Route::post('edit-leave/{id}', [SettingController::class, 'fmLeave'])->name('fmLeave.store');
    Route::post('addLeave/', [SettingController::class, 'addLeave'])->name('addLeave.store');
    Route::post('destroyLeave/{id}', [SettingController::class, 'destroy'])->name('destroy.leave');

    // missing-attendance-req
    Route::get('missing-attendance-req', [Missing_attendanceController::class, 'index']);
    Route::get('upload-attendance', [Missing_attendanceController::class, 'upload_Attendance'])->name('upload');
    Route::post('upload-attendance', [Missing_attendanceController::class, 'store'])->name('upload.store');
    Route::get('reports', [Missing_attendanceController::class, 'report']);
    Route::post('reports', [Missing_attendanceController::class, 'search_report'])->name('search_report');
    Route::post('report', [Missing_attendanceController::class, 'attendance_file'])->name('attendance_file.report');
    Route::post('training-report', 'App\Http\Controllers\Missing_attendanceController@training_attendance')->name('training_attendance');
    Route::get('approve-att-req/{id}', [Missing_attendanceController::class, 'approve_att_req']);
    Route::get('verify-att-req/{id}', [Missing_attendanceController::class, 'verify_att_req']);
    Route::get('delete-missing-attendance/{id}', [Missing_attendanceController::class, 'destroy']);

    Route::get('leave-glance', [Leave_at_a_glanceController::class, 'index']);
    Route::post('leave-glance', [Leave_at_a_glanceController::class, 'search'])->name('search');

    Route::get('/view-leave-list/{id?}/{date?}', [pendingLeaveController::class, 'showLeaves']);
    Route::get('late-early-req', [Late_early_reqController::class, 'late_early_req']);
    Route::get('approve-late/{id?}', [Late_early_reqController::class, 'approve']);
    Route::get('verify-late/{id?}', [Late_early_reqController::class, 'verify']);
    Route::get('delete-late-early-request/{id?}', [Late_early_reqController::class, 'destroy']);
    Route::post('late-early-req-send', [Late_early_reqController::class, 'create']);

    Route::get('leave-req', [leaveRequestController::class, 'index']);

    Route::post('send-leave-req', [leaveRequestController::class, 'create']);

    Route::resource('emp-today', EmpTodayController::class);

    Route::get('/pending-req', [Late_early_reqController::class, 'index'])->name('late.pending');

    // to test if attendance files being uploaded via url
    Route::get('attendancefiles-genuity', [Missing_attendanceController::class, 'getAttendanceByUrl']);
    // @author Tahrim Kabir routes end here

});
