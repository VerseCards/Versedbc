<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Collection;
//use App\Http\Controllers\User;
use App\Models\User;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use App\Models\ActivityLog;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

            $roles = Role::where('created_by', '=', \Auth::user()->creatorId())->get();
            return view('role.index')->with('roles', $roles);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $user = \Auth::user();
            if($user->type == 'company' || $user->type == 'techsupport')
            {
                $permissions = Permission::all()->pluck('name', 'id')->toArray();
                
            }
            else
            {
                $permissions = new Collection();
                foreach($user->roles as $role)
                {
                    $permissions = $permissions->merge($role->permissions);
                }
                $permissions = $permissions->pluck('name', 'id')->toArray();
            }

            return view('role.create', ['permissions' => $permissions]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

            $roles = Role::where('name', '=', $request->name)->where('created_by', '=', \Auth::user()->creatorId())->first();
            if(isset($roles))
            {
                return redirect()->back()->with('error', __('The department have already been created.'));
            }
                $this->validate(
                    $request, [
                                'name' => 'required|max:100|unique:roles,name,NULL,id,created_by,' . \Auth::user()->creatorId(),
                                'permissions' => 'required',
                            ]
                );
            $name             = $request['name'];
            $role             = new Role();
            $role->name       = $name;
            $role->created_by = \Auth::user()->creatorId();
            $permissions      = $request['permissions'];
            $role->save();
            
            foreach($permissions as $permission)
            {
                $p = Permission::where('id', '=', $permission)->firstOrFail();
                $role->givePermissionTo($p);
            }
			
			ActivityLog::create([
								'user_id' => \Auth::user()->id,
								'initiated_by' => \Auth::user()->name,
								'remark' => $role->name . ' ' . 'Department Created',
							]);

            return redirect()->route('roles.index')->with('success', __('Department successfully created.'));

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $role = Role::where('id', '=', $id)->where('created_by', '=', \Auth::user()->creatorId())->first();
        $user = \Auth::user();
        if($user->type == 'company')
        {
            $permissions = Permission::all()->pluck('name', 'id')->toArray();
        }
        else
        {
            $permissions = new Collection();
            foreach($user->roles as $role1)
            {
                $permissions = $permissions->merge($role1->permissions);
            }
            $permissions = $permissions->pluck('name', 'id')->toArray();
        }
		
		
        
        return view('role.edit', compact('role', 'permissions'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

            $role = Role::where('id', '=', $id)->where('created_by', '=', \Auth::user()->creatorId())->first();
			
        
            $this->validate(
                $request, [
                            'name' => 'required|max:100|unique:roles,name,' . $role['id'] . ',id,created_by,' . \Auth::user()->creatorId(),
                            'permissions' => 'required',
                        ]
            );
			
			
			if($role->name != $request->name){
				$allUsers = User::where('type', $role->name)->get();
				foreach($allUsers as $updateUser) {
					$updateUser->type = $request->name;
					$updateUser->save();
				}
				
			}
			

            $input       = $request->except(['permissions']);
            $permissions = $request['permissions'];
            $role->fill($input)->save();

            $p_all = Permission::all();

            foreach($p_all as $p)   
            {
                $role->revokePermissionTo($p);
            }

            foreach($permissions as $permission)
            {
                $p = Permission::where('id', '=', $permission)->firstOrFail();
                $role->givePermissionTo($p);
            }
			
			ActivityLog::create([
								'user_id' => \Auth::user()->id,
								'initiated_by' => \Auth::user()->name,
								'remark' => $role->name . ' ' . 'Department updated',
							]);

            return redirect()->back()->with('success', __('Department successfully updated.'));

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        
            $role = Role::where('id', '=', $id)->where('created_by', '=', \Auth::user()->creatorId())->first();
            $role->delete();

            return redirect()->route('roles.index')->with( 'success', __('Department successfully deleted.'));

    }
}
