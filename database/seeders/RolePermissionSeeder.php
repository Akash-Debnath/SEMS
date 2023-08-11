<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds-
     *
     * @return void
     */
    public function run()
    {
        // Create Roles
        $roleSuperAdmin = Role::create(['name' => 'superadmin']);
        $roleAdmin = Role::create(['name' => 'admin']);
        $roleManager = Role::create(['name'=>'manager']);
        $roleManagement = Role::create(['name'=>'management']);
        $roleUser = Role::create(['name'=>'user']);


        // Permission List as array
        $permissions = [
            [
                //sidebar permissions
                'group_name' => 'dashboard',
                'permissions' => [
                    'dashboard-view',
                    'dashboard-employee',
                    'dashboard-employee-profileUpdateHistory',
                    'dashboard-board',
                    'dashboard-board-notice',
                    'dashboard-board-attachment',
                    'dashboard-board-policy',
                    'dashboard-board-holiday',
                    'dashboard-board-incident',
                    'dashboard-board-jobDescription',
                    'dashboard-leave',
                    'dashboard-leaveList',
                    'dashboard-leave-glance',
                    'dashboard-leave-yearlyLeaveReport',
                    'dashboard-leave-pending',
                    'dashboard-leave-todayLeave',
                    'dashboard-archive',
                    'dashboard-settings',
                    'dashboard-settings-department',
                    'dashboard-settings-designation',
                    'dashboard-settings-facility',
                    'dashboard-settings-note',
                    'dashboard-settings-rolePermission',
                    'dashboard-settings-administratorPrivilege',
                    'dashboard-settings-permissionPrivilege',
                    'dashboard-settings-officeTime',
                    'dashboard-ramadanTime',
                    'dashboard-ramadanTime-setRamadan',
                    'dashboard-ramadanTime-settings',
                    'dashboard-attendance-report',
                    'dashboard-attendance-todayEmployee',
                    'dashboard-attendance-upload',
                    'dashboard-attendance-lateEarly',
                    'dashboard-attendance-lateEarlyPending',
                    'dashboard-attendance-missingAttendanceRequest',
                    'dashboard-attendance-officeSchedule',
                    'dashboard-attendance-rosterSet',
                    'dashboard-attendance-rosterPending',
                ]
            ],
            [
                'group_name' => 'employee',
                'permissions' => [
                    // Employee Permissions
                    'employee-profile-view',
                    'employee-profile-edit',
                    'employee-profileupdate-sidebar',
                    'employee-create',
                    'employee-grade-set',
                    'employee-grade-add',
                    'employee-status-create',
                    'employee-status-add',
                    'employee-status-delete',
                    'employee-archive',
                    'employee-lock',
                    'employee-edit',
                    'employee-delete',
                    'employee-profile-update-approve',
                    'employee-profile-update-reject',
                ]
            ],
            [
                'group_name' => 'evaluation ',
                'permissions' => [
                    // evaluation Permissions
                    'evaluation-create',
                    'evaluation-view',
                    'evaluation-edit',
                    'employee-self-evaluation',
                    'employee-evaluation',
                    'evaluation-refuse',
                    'evaluation-approve',
                ]
            ],
            [
                'group_name' => 'notice',
                'permissions' => [
                    // admin Permissions
                    'notice-create',
                    'notice-view',
                    'notice-edit',
                    'notice-delete',
                    'notice-approve',
                ]
            ],
            [
                'group_name' => 'attachment',
                'permissions' => [
                    // attachment Permissions
                    'attachment-create',
                    'attachment-view',
                    'attachment-edit',
                    'attachment-delete',
                    'attachment-approve',
                ]
            ],
            [
                'group_name' => 'policy',
                'permissions' => [
                    // policy Permissions
                    'policy-create',
                    'policy-view',
                    'policy-delete',
                    'policy-approve',
                ]
            ],
            [
                'group_name' => 'holiday',
                'permissions' => [
                    // holiday Permissions
                    'holiday-create',
                    'holiday-view',
                    'holiday-edit',
                    'holiday-delete',
                    'holiday-approve',
                ]
            ],
            [
                'group_name' => 'incident',
                'permissions' => [
                    // incident Permissions
                    'incident-create',
                    'incident-view',
                    'incident-edit',
                    'incident-delete',
                    'incident-approve',
                ]
            ],
            [
                'group_name' => 'jobdescription',
                'permissions' => [
                    // jobdescription Permissions
                    'jobdescription-upload',
                    'jobdescription-view',
                    'jobdescription-change',
                    'jobdescription-download',
                    'jobdescription-approve',
                ]
            ],
            [
                'group_name' => 'leave',
                'permissions' => [
                    // leave Permissions
                    'view-leave-list',
                    'view-leave-request-form',
                    'leave-create',
                    'leave-request',
                    'leave-view',
                    'leave-edit',
                    'leave-satff-search',
                    'leave-delete',
                    'leave-refuse',
                    'leave-approve',
                    'leave-verify',
                    'leave-cancel',
                    'leave-approval-approve-refuse',
                    'leave-verification-verify-refuse',
                    'leave-cancel-request-self',
                    'leave-cancellation-approve-refuse-head',
                    'leave-cancellation-approve-refuse-admin',
                ]
            ],
            [
                'group_name' => 'arcive',
                'permissions' => [
                    // arcive Permissions
                    'arcive-show',
                ]
            ],
            [
                'group_name' => 'department',
                'permissions' => [
                    // department Permissions
                    'department-create',
                    'department-view',
                    'department-edit',
                    'department-delete',
                    'department-approve',
                ]
            ],
            [
                'group_name' => 'designation',
                'permissions' => [
                    // designation Permissions
                    'designation-create',
                    'designation-view',
                    'designation-edit',
                    'designation-delete',
                    'designation-approve',
                ]
            ],
            [
                'group_name' => 'facility',
                'permissions' => [
                    // facility Permissions
                    'facility-create',
                    'facility-view',
                    'facility-edit',
                    'facility-delete',
                    'facility-refuse',
                    'facility-approve',
                ]
            ],
            [
                'group_name' => 'note',
                'permissions' => [
                    // note Permissions
                    'note-create',
                    'note-view',
                    'note-edit',
                    'note-delete',
                    'note-refuse',
                    'note-approve',
                ]
            ],
            [
                'group_name' => 'roleAndPermissionSet',
                'permissions' => [
                    // note roleAndPermission
                    'roleAndPermission-create',
                    'roleAndPermission-view',
                    'roleAndPermission-edit',
                    'roleAndPermission-delete',
                    'roleAndPermission-refuse',
                    'roleAndPermission-approve',
                ]
            ],
            [
                'group_name' => 'privilege',
                'permissions' => [
                    // privilege Permissions
                    'privilege-create',
                    'privilege-view',
                    'privilege-edit',
                    'privilege-delete',
                    'privilege-refuse',
                    'privilege-approve',
                ]
            ],
            [
                'group_name' => 'permissionPrivilege',
                'permissions' => [
                    // permissionPrivilege permissions
                    'permissionPrivilege-create',
                    'permissionPrivilege-view',
                    'permissionPrivilege-edit',
                    'permissionPrivilege-delete',
                    'permissionPrivilege-refuse',
                    'permissionPrivilege-approve',
                ]
            ],
            [
                'group_name' => 'officeTime',
                'permissions' => [
                    // office time permissions
                    'roster-update',
                    'schedule-update',
                    'weekly-leave-edit',
                ]
            ],
            [
                'group_name' => 'ramadan',
                'permissions' => [
                    // ramadan Permissions
                    'ramadan-create',
                    'ramadan-view',
                    'ramadan-edit',
                    'ramadan-delete',
                    'ramadan-refuse',
                    'ramadan-approve',
                ]
            ],
            [
                'group_name' => 'settings',
                'permissions' => [
                    // settings Permissions
                    'settings-create',
                    'settings-view',
                    'settings-edit',
                    'settings-delete',
                    'settings-refuse',
                    'settings-approve',
                ]
            ],
            [
                'group_name' => 'report',
                'permissions' => [
                    // report Permissions
                    'report-view',
                    'report-department-staff-search',
                ]
            ],
            [
                'group_name' => 'upload',
                'permissions' => [
                    // upload Permissions
                    'upload-addattendance',
                    'upload-attendancefile',
                ]
            ],
            [
                'group_name' => 'lateEarly',
                'permissions' => [
                    // lateEarly Permissions
                    'lateEarly-create',
                    'lateEarly-pending',
                    'lateEarly-approval-approve-refuse',
                    'lateEarly-verification-approve-refuse',
                    'missing-attendance-approval-approve-refuse',
                    'missing-attendance-verification-approve-refuse'
                ]
            ],
            [
                'group_name' => 'officeSchedule',
                'permissions' => [
                    // officeSchedule Permissions
                    'officeSchedule-view',
                    'officeSchedule-department-staff-search',
                    'officeSchedule-refuse',
                    'officeSchedule-approve',
                ]
            ],
            [
                'group_name' => 'uploadAttendance',
                'permissions' => [
                    // uploadAttendance Permissions
                    'uploadAttendance-create',
                    'uploadAttendance-request',
                    'uploadAttendance-view',
                    'uploadAttendance-edit',
                    'uploadAttendance-delete',
                    'uploadAttendance-refuse',
                    'uploadAttendance-approve',
                ]
            ],
            [
                'group_name' => 'rosterSettings',
                'permissions' => [
                    // rosterSettings Permissions
                    'rosterSettings-create',
                    'rosterSettings-request',
                    'rosterSettings-view',
                    'rosterSettings-edit',
                    'rosterSettings-delete',
                    'rosterSettings-refuse',
                    'rosterSettings-approve',
                ]
            ],
        ];


        // Create and Assign Permissions
        for ($i = 0; $i < count($permissions); $i++) {
            $permissionGroup = $permissions[$i]['group_name'];
            for ($j = 0; $j < count($permissions[$i]['permissions']); $j++) {
                // Create Permission
                $permission = Permission::create(['name' => $permissions[$i]['permissions'][$j], 'group_name' => $permissionGroup]);
                $roleSuperAdmin->givePermissionTo($permission);
                $permission->assignRole($roleSuperAdmin);
            }
        }
    }
}
