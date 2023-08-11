<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Permission;
use Illuminate\Validation\Rule;

class RolesController extends Controller
{

    /**
     * Display a listing of all roles resource from `roles` table.
     *
     * @author Akash Chandra Debnath
     * @method index
     * @param void
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(Auth::user()->can('dashboard-settings-rolePermission')){
            $roles = Role::paginate(20);
            return view('role', compact('roles'));
        } else {
            return redirect()->back()->with('fail', 'You are not able to go through!');
        }
    }



    /**
     * Show the form for creating a new role with permissions resource in `roles` table and get group of permissions by `User` model.
     *
     * @author Akash Chandra Debnath
     * @method create
     * @param void
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if(Auth::user()->can('roleAndPermission-create')){
            $all_permissions  = Permission::all();
            $permission_groups = User::getpermissionGroups();
            return view('create-role', compact('all_permissions', 'permission_groups'));
        } else {
            return redirect()->back()->with('fail', 'You are not able to go through!');
        }
    }



    /**
     * Store a newly created role resource in `roles` and `role_has_permissions` table.
     *
     * @author Akash Chandra Debnath
     * @method store
     * @param  \Illuminate\Http\Request  $request roles, permissions
     * @return \Illuminate\Http\Response
    */
    public function store(Request $request)
    {
        if(Auth::user()->can('roleAndPermission-create')){
            $validator = Validator::make($request->all(),[
                'name' => 'required|max:100|unique:roles',
            ]);
            if($validator->fails()) {
                return redirect()->back()->withErrors($validator);
            }
            $role = Role::create(['name' => $request->name]);
            // $role = DB::table('roles')->where('name', $request->name)->first();
            $permissions = $request->permissions;
            if (!empty($permissions)) {
                $role->syncPermissions($permissions);
            }
            return redirect()->route('roles.index')->with('success', 'Role Created Successfully!');
        } else {
            return redirect()->back()->with('fail', 'You are not able to go through!');
        }
    }



    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }



    /**
     * Show the form for editing the specified role resource from `roles` and `role_has_permissions` table.
     *
     * @author Akash Chandra Debnath
     * @method edit
     * @param  int  $id role_id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if(Auth::user()->can('roleAndPermission-edit')){
            $role = Role::findById($id);
            $all_permissions = Permission::all();
            $permission_groups = User::getpermissionGroups();
            return view('edit-role', compact('role', 'all_permissions', 'permission_groups'));
        } else {
            return redirect()->back()->with('fail', 'You are not able to go through!');
        }
    }



    /**
     * Update the specified role resource in `roles` and `role_has_permissions` table.
     *
     * @author Akash Chandra Debnath
     * @method update
     * @param  \Illuminate\Http\Request  $request roles, permissions
     * @param  int  $id role_id
     * @return \Illuminate\Http\Response
    */
    public function update(Request $request, $id)
    {
        if(Auth::user()->can('roleAndPermission-edit')){
            $validator = Validator::make($request->all(),[              // Validation Data
                // 'name' => 'required|max:100|unique:roles,id,'.$id,
                // 'name' => ['required','min:1','max:100',Rule::unique('roles')->where(function ($query) use ($request) {
                //     return $query->where('id','!=',$request->id);
                // })],
            ]);
            if($validator->fails()) {
                return redirect()->back()->withErrors($validator);
            }
            $role = Role::findById($id);
            $permissions = $request->input('permissions');
            if (!empty($permissions)) {
                $role->syncPermissions($permissions);
            }
            return redirect()->route('roles.index')->with('success', 'Role Updated Successfully!');
        } else {
            return redirect()->back()->with('fail', 'You are not able to go through!');
        }

    }



    /**
     * Remove the specified resource from `roles` table.
     *
     * @author Akash Chandra Debnath
     * @method
     * @param  int  $id
     * @return \Illuminate\Http\Response
    */
    public function destroy($id)
    {
        if(Auth::user()->can('roleAndPermission-delete')){
            // if(Auth::user()->can('roleAndPermission-edit')){}
            $role = Role::findorFail($id)->delete();
            // if (!is_null($role)) {
            //     $role->delete();
            // }
            return redirect()->back()->with('fail', 'Role has been Deleted Successfully!');
        } else {
            return redirect()->back()->with('fail', 'You are not able to go through!');
        }
    }
}
