<?php

use Illuminate\Database\Seeder;

class ACLSeeder extends Seeder {
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run() {
		DB::table('permissions')->delete();
		DB::table('permission_role')->delete();
		DB::table('roles')->delete();
		DB::table('role_user')->delete();

		// Permissions
		$perm_user = \App\Permission::firstOrCreate([
			'title' => 'Manage users',
			'slug'  => 'manage_user',
		]);

		// Roles
		$role_admin = \App\Role::firstOrCreate([
			'title' => 'Administrator',
			'slug'  => 'administrator',
		]);
		$role_admin->permissions()->saveMany([ $perm_user ]);

//		$role_editor = \App\Role::firstOrCreate([
//			'title' => 'Editor',
//			'slug'  => 'editor',
//		]);

		// Attach roles to users
		$admin = \App\User::where('email', 'contact@ngiraud.me')->first();
		if(!is_null($admin)) {
			$admin->roles()->save($role_admin);
		}

//		$editor = \App\User::find(2);
//		$editor->roles()->save($role_editor);

	}
}
