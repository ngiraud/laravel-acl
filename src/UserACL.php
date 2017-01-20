<?php

namespace NGiraud\ACL;

use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Cache;

trait UserACL {

	public function isSuperAdmin() {
		if(!empty( Config::get('acl.superadmin_users') ) && in_array($this->id, Config::get('acl.superadmin_users')))
			return true;

		return false;
	}

	/**
	 * Checks a Permission
	 *
	 * @param String $permission Slug of a permission (i.e: manage_user)
	 *
	 * @return bool                    true if has permission, otherwise false
	 */
	public function hasPermission($permission = null) {
		if($this->isSuperAdmin())
			return true;

		return !is_null($permission) && $this->checkPermission($permission);
	}

	/**
	 * Check if the permission matches with any permission user has
	 *
	 * @param  String permission slug of a permission
	 *
	 * @return Boolean true if permission exists, otherwise false
	 */
	protected function checkPermission($perm) {
		$userPermissions     = $this->getAllPermissionsFormAllRoles();
		$requiredPermissions = is_array($perm) ? $perm : [ $perm ];

		return array_diff($requiredPermissions, $userPermissions) === [];
	}

	/**
	 * Get all permission slugs from all permissions of all roles
	 *
	 * @return Array of permission slugs
	 */
	protected function getAllPermissionsFormAllRoles() {
		$roles       = Cache::rememberForever('roles_for_user_'.$this->id, function() {
			return $this->roles()->with([
				'permissions' => function($query) {
					$query->select('slug');
				},
			])->get();
		});
		$permissions = [];
		foreach($roles as $role) {
			foreach($role->permissions as $permission) {
				$permissions[] = $permission->permission_slug;
			}
		}

		return $permissions;
	}

	/*
	|--------------------------------------------------------------------------
	| Relationship Methods
	|--------------------------------------------------------------------------
	*/

	/**
	 * Many-To-Many Relationship Method for accessing the User->roles
	 *
	 * @return QueryBuilder Object
	 */
	public function roles() {
		return $this->belongsToMany('NGiraud\ACL\Role');
	}

	/**
	 * Scopes
	 *
	 * @param $query
	 *
	 * @return mixed
	 */
	public function scopeNonSuperAdmin($query) {
		return $query->whereNotIn('id', config('acl.superadmin_users'));
	}

	public function scopePermissions($query, $perm) {
		return $query->whereHas('roles', function($q) use ($perm) {
			$q->whereHas('permissions', function($q) use ($perm) {
				$q->where('slug', '=', $perm);
			});
		});
	}
}
