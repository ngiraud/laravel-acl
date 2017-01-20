<?php

namespace NGiraud\ACL\Controllers\Admin;

use NGiraud\ACL\Requests\PermissionRequest;
use Illuminate\Http\Request;

use App\Http\Controllers\Controller;
use NGiraud\ACL\Permission;
use NGiraud\ACL\Role;

class PermissionController extends Controller {
	/**
	 * PermissionController constructor.
	 */
	public function __construct() {
		$this->middleware('acl:manage_permission');
	}
	
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index() {
		$perms = Permission::all();
		return view('admin.permission.index', compact('perms'));
	}
	
	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create() {
		$permission = new Permission();
		$roles = Role::getForSelector();
		
		return view('admin.permission.create', compact('permission', 'roles'));
	}
	
	/**
	 * Store a newly created resource in storage.
	 *
	 * @param PermissionRequest|Request $request
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function store(PermissionRequest $request) {
		$permission = Permission::create($request->all());
		
//		foreach($request->get('roles') as $role_id) {
//			$role = Role::find($role_id);
//			$role->permissions()->sync()
//		}
		$permission->roles()->sync($request->get('roles'));
		
		return redirect(route('admin.permission.edit', $permission))->with('success', trans('admin.flash.permission.created'));
	}
	
	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int $id
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function edit($id) {
		$permission = Permission::findOrFail($id);
		
		// Only takes the first role because for now there is only one role per user
		$permission->roles = $permission->roles->pluck('id')->toArray();
		$roles = Role::getForSelector();
		
		return view('admin.permission.edit', compact('permission', 'roles'));
	}
	
	/**
	 * Update the specified resource in storage.
	 *
	 * @param PermissionRequest|Request $request
	 * @param  int $id
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function update(PermissionRequest $request, $id) {
		$permission = Permission::findOrFail($id);
		$permission->roles()->sync($request->get('roles'));
		$permission->update($request->all());
		
		return redirect(route('admin.permission.edit', $id))->with('success', trans('admin.flash.permission.updated'));
	}
	
	/**
	 * Remove the specified resource from storage.
	 *
	 * @param Request $request
	 * @param  int $id
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function destroy(Request $request, $id) {
		if(!$request->ajax()) {
			exit;
		}
		
		$permission = Permission::findOrFail($id);
		$success = $permission->delete();
		$permission->roles()->detach();
		
		if($success == 1) {
			return response()->json(trans("admin.permission.deleted.ok"));
		}
		
		return response()->json(trans('admin.permission.deleted.error'), 422);
	}
}
