<?php

namespace App\Http\Controllers\admin\configure;

use App\Exports\UsersExport;
use App\Http\Controllers\Controller;
use App\Http\Traits\LdapTrait;
use App\Http\Traits\UserPermissionTrait;
use App\Http\Traits\UserTeamTrait;
use App\Http\Traits\UserTrait;
use App\Models\Department;
use App\Models\Job;
use App\Models\Permission;
use App\Models\PermissionGroup;
use App\Models\Role;
use App\Models\RoleResponsibility;
use App\Models\Team;
use App\Models\User;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Validator;

class UserManagementController extends Controller
{
    use LdapTrait, UserTrait, UserTeamTrait, UserPermissionTrait;
    private $path = 'admin.content.configure.user_management.';

    /**
     * Display a dump message for testing
     *
     * @return String
     */
    public function create()
    {
        if (!checkUsersCount(102)) {
            return abort(401);
        }
        $roles = Role::all();
        $teams = Team::all();
        $managers = User::where('manager_id', null)->get();
        $permissions_group = PermissionGroup::all();
        $permissions = Permission::all();
        $jobs = Job::all();
        $departments = Department::all();
        $breadcrumbs = [['link' => route('admin.dashboard'), 'name' => __('locale.Dashboard')], ['link' => "javascript:void(0)", 'name' => __('locale.Configure')], ['link' => "javascript:void(0)", 'name' => __('locale.User Management')], ['name' => __('locale.AddANewUser')]];
        return view($this->path . 'create', compact('breadcrumbs', 'roles', 'teams', 'managers', 'roles', 'jobs', 'permissions_group', 'departments'));
    }
    /**
     * Display a dump message for testing
     *
     * @return String
     */
    public function store(Request $request)
    {
        $rules = array(
            'type' => 'required',
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'username' => 'required|unique:users,username',
            'manager_id' => 'nullable|integer',
            'password' => 'required|confirmed|min:8',
            'teams' => 'nullable',
            'role_id' => 'required|integer',
            'job_id' => 'nullable|integer',
            'department_id' => 'nullable|integer',
            // 'multi_factor' => 'required',
            // 'permissions' => 'required',
        );
        if (!$request->admin) {
            $request->admin = 0;
        }
        $validator = Validator::make($request->all(), $rules);
        $data = array();

        if ($validator->fails()) {
            $errors = $validator->errors();
            $data = array(
                'status' => 0,
                'errors' => $errors,
            );
        } else {
            $request->salt = generate_token(20);
            $user = $this->AddGrcUser($request);
            $permissions = RoleResponsibility::where('role_id', $request->role_id)->pluck('permission_id')->toArray();

            if ($request->admin == 1) {
                $this->AllTeamToUser($user->id);
                $this->AllPermissionToUser($user->id);
            } else {
                $this->AddTeamsOfUser($user->id, $request->teams);
                $this->AddPermissionsOfUser($user->id, $permissions);
            }
            $data = array(
                'status' => 1,
                'message' => __('configure.save-information-successfully'),
            );
            $teamNames = $user->teams->pluck('name')->toArray();
            // $message = __('configure.A New User Added with name') . ' "' . ($user->name ?? ["no name"]) . '". ' .
            // __('configure.The type is') . ' "' . ($user->type ?? ["no Type"]) . '" ' .
            // __('locale.And job is') . ' "' . ($user->job->name ?? ["no Job"]) . '" ' .
            // __('configure.with role') . ' "' . ($user->role->name ?? ["no role"]) . '" ' .
            // __('locale.Belongs to department') . ' "' . ($user->department->name ?? ["no departement"]) . '" ' .
            // __('configure.joined to team') . ' "' . (!empty($teamNames) ? implode(', ', $teamNames) : '[No Teams]') . '" ' .
            // __('locale.CreatedBy') . ' "' . auth()->user()->name . '".';
            //  write_log($user->id, auth()->id(), $message, 'Creating User');
        }

        return response()->json($data, 200);
    }

    /**
     * Display a dump message for testing
     *
     * @return String
     */
    public function index()
    {
        $breadcrumbs = [['link' => route('admin.dashboard'), 'name' => __('locale.Dashboard')], ['link' => "javascript:void(0)", 'name' => __('locale.Configure')], ['link' => "javascript:void(0)", 'name' => __('locale.User Management')], ['name' => __('locale.ManageUsers')]];
        $users = User::all();
        $roles = Role::all();
        $departments = Department::all();
        return view($this->path . '.index', compact('roles', 'departments', 'breadcrumbs'));
    }
    /**
     * Display a User edit
     *
     * @return String
     */
    public function edit($id)
    {
        if ($id == 1 && auth()->id() != 1) {
            return abort(401);
        }

        $roles = Role::all();
        $teams = Team::all();
        $managers = User::where('manager_id', null)->get();
        $permissions_group = PermissionGroup::all();
        $permissions = Permission::all();
        $jobs = Job::all();
        $breadcrumbs = [['link' => route('admin.dashboard'), 'name' => __('locale.Dashboard')], ['link' => "javascript:void(0)", 'name' => __('locale.Configure')], ['link' => route('admin.configure.user.index'), 'name' => __('locale.User Management')], ['name' => __('locale.UpdateUser')]];
        $editUser = User::findOrFail($id);
        $editUserTeam = $this->GetTeamsOfUser($id);
        $departments = Department::all();

        return view($this->path . 'edit', compact('breadcrumbs', 'roles', 'teams', 'managers', 'roles', 'jobs', 'permissions_group', 'editUser', 'editUserTeam', 'departments'));
    }

    /**
     * Return a listing of the resource after some manipulation.
     * @param  \Illuminate\Http\Request  $request
     *
     * @return \Illuminate\Http\Response
     */
    public function ajaxGetList(Request $request)
    {
        /* Start reading datatable data and custom fields for filtering */
        $dataTableDetails = [];
        $customFilterFields = [
            'normal' => ['type', 'username'],
            'relationships' => ['role', 'department'],
            'other_global_filters' => ['name', 'email'],
        ];
        $relationshipsWithColumns = [
            // 'relationshipName:column1,column2,....'
            'role:id,name',
            'department:id,name',
        ];

        prepareDatatableRequestFields($request, $dataTableDetails, $customFilterFields);
        /* End reading datatable data and custom fields for filtering */

        // Getting total records count with and without apply global search
        [$totalRecords, $totalRecordswithFilter] = getDatatableFilterTotalRecordsCount(
            User::class,
            $dataTableDetails,
            $customFilterFields
        );

        $mainTableColumns = getTableColumnsSelect(
            'users',
            [
                'id',
                'type',
                'username',
                'name',
                'email',
                'admin',
                'enabled',
                'role_id',
                'department_id'
            ]
        );

        // Getting records with apply global search */
        $users = getDatatableFilterRecords(
            User::class,
            $dataTableDetails,
            $customFilterFields,
            $relationshipsWithColumns,
            $mainTableColumns
        );

        // Custom users response data as needs
        $data_arr = [];
        foreach ($users as $user) {
            $data_arr[] = array(
                'id' => $user->id,
                'type' => $user->type,
                'username' => showBOLB($user->username),
                'name' => $user->name,
                'email' => showBOLB($user->email),
                'role' => $user->role->name,
                'admin' => $user->admin,
                'active' => $user->enabled,
                // 'ldap_department' => $user->department,
                'department' => ($user->department) ? $user->department->name : '-',
                'Actions' => $user->id,
            );
        }

        // Get custom response for datatable ajax request
        $response = getDatatableAjaxResponse(intval($dataTableDetails['draw']), $totalRecords, $totalRecordswithFilter, $data_arr);

        return response()->json($response, 200);


        ######################################
        $Users = User::get()->map(function ($user) {
            return (object) [
                'responsive_id' => $user->id,
                'type' => $user->type,
                'username' => showBOLB($user->username),
                'name' => $user->name,
                'email' => showBOLB($user->email),
                'role_id' => $user->role->name,
                'admin' => $user->admin,
                'active' => $user->enabled,
                'ldap_department' => $user->department,
                'department_id' => ($user->department) ? $user->department->name : '-',
                'Actions' => $user->id,
            ];
        });

        return response()->json($Users, 200);
    }
    /**
     * check if user found in ldap
     *
     * @return String
     */
    public function CheckUserLdap(Request $request)
    {
        $rules = array(
            'email' => 'required|email|unique:users,email',
            'username' => 'required|unique:users,username',

        );

        $validator = Validator::make($request->all(), $rules);
        $data = array();
        if ($validator->fails()) {
            $errors = $validator->errors();
            $data = array(
                'status' => 0,
                'errors' => $errors,
            );
        } else {
            $check = $this->CheckExistUserLdap($request->email, $request->username);
            if ($check) {
                $data = array(
                    'status' => true,
                    'check' => true,
                    'user' => $check,
                );
            } else {
                $data = array(
                    'status' => true,
                    'check' => false,
                    'message' => __('configure.UserNotFoundInLdap'),
                );
            }
        }
        return response()->json($data, 200);
    }

    /**
     * delete user by id
     *
     * @return String
     */
    public function destroy($id)
    {
        $this->RemoveUserTeam($id);
        $this->RemoveUserPermission($id);
        $user = User::where('id', $id)->delete();
        $message = __('locale.User') . ' "' . $user->name . '" ' . __('locale.DeletedBy') . ' "' . auth()->user()->name . '".';
        write_log($user->id, auth()->id(), $message, 'deleting User');
        return response()->json('ok', 200);
    }
    /**
     * change account status user by id
     *
     * @return String
     */
    public function AccountStatus($id)
    {
        if ($id == 1)
            return response()->json('ok', 200);

        $user = User::find($id);
        if ($user->enabled == 1) {
            $user->enabled = 0;
            $user->save();
        } else {

            $user->enabled = 1;
            $user->save();
        }
        return response()->json('ok', 200);
    }

    /**
     * edit user
     *
     * @return String
     */
    public function update(Request $request)
    {
        if ($request->id == 1 && auth()->id() != 1) {
            $response = array(
                'status' => false,
                'message' => __('locale.YouDonotHavePermissionToDoThat'),
            );
            return response()->json($response, 401);
        }
        $rules = array(
            'name' => 'required',
            'manager_id' => 'nullable|integer',
            'password' => 'nullable|confirmed|min:8',
            'teams' => 'nullable',
            'role_id' => 'required|integer',
            'job_id' => 'nullable|integer',
            'department_id' => 'nullable|exists:departments,id',
        );
        if (!$request->admin) {
            $request->admin = 0;
        }
        $validator = Validator::make($request->all(), $rules);
        $data = array();

        if ($validator->fails()) {
            $errors = $validator->errors();
            dd($errors);
            $data = array(
                'status' => 0,
                'errors' => $errors,
            );
        } else {

            $user = $this->EditGrcUser($request);
            $permissions = RoleResponsibility::where('role_id', $request->role_id)->pluck('permission_id')->toArray();
            $teams = $request->teams;
            if ($request->admin == 1) {
                $teams = Team::pluck('id')->toArray();
                $permissions = Permission::pluck('id')->toArray();
            }
            $this->UpdateTeamsOfUser($request->id, $teams);
            $this->UpdatePermissionsOfUser($request->id, $permissions);

            $data = array(
                'status' => 1,
                'message' => __('configure.save-information-successfully'),
            );
            $message = __('locale.User') . ' "' . $user->name . '" ' . __('locale.UpdatedBy') . ' "' . auth()->user()->name . '".';
            write_log($user->id, auth()->id(), $message, 'Updating User');
        }

        return response()->json($data, 200);
    }

    /**
     * Return an Export file for listing of the resource after some manipulation.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function ajaxExport(Request $request)
    {
        if ($request->type != 'pdf')
            return Excel::download(new UsersExport, 'Users.xlsx');
        else
            return 'Users.pdf';
    }
}
