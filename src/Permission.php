<?php

namespace NGiraud\ACL;

use Illuminate\Database\Eloquent\Model;

class Permission extends Model {
	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'permissions';

	protected $fillable = [ 'title', 'slug', 'description' ];

	public $timestamps = false;

	/*
	|--------------------------------------------------------------------------
	| Relationship Methods
	|--------------------------------------------------------------------------
	*/

	/**
	 * many-to-many relationship method
	 *
	 * @return QueryBuilder
	 */
	public function roles() {
		return $this->belongsToMany('NGiraud\ACL\Role');
	}
}
