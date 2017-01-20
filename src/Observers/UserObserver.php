<?php

namespace NGiraud\ACL\Observers;

use App\User;
use Illuminate\Support\Facades\Validator;

class UserObserver {

	public function saving(User $user) {
		// Checking roles if creating or editing user (not profile)
		if(request()->route()->getName() == 'admin.user.store' || request()->route()->getName() == 'admin.user.update') {
			$validator = \Validator::make(request()->only('roles'), [
				'roles' => 'required|exists:roles,id',
//				'roles' => 'required|in:5',
			])->validate();
		}
	}

	public function saved(User $user) {
		if(request()->route()->getName() == 'admin.user.store' || request()->route()->getName() == 'admin.user.update') {
			$user->roles()->sync([ request()->get('roles') ]);
		}
	}
}