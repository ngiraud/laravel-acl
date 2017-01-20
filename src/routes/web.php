<?php
Route::group([
	'namespace' => 'NGiraud\ACL\Controllers\Admin',
	'prefix' => 'admin',
	'middleware' => [ 'web', 'auth' ]
], function() {
	Route::resource('permission', 'PermissionController', [ 'except' => [ 'show' ], 'as' => 'admin' ]);
});