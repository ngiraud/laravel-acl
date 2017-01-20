<?php

namespace NGiraud\ACL;

use Illuminate\Database\Eloquent\Model;

class Role extends Model {
	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'roles';

	public $timestamps = false;

	/*
	|--------------------------------------------------------------------------
	| Relationship Methods
	|--------------------------------------------------------------------------
	*/

	/**
	 * many-to-many relationship method.
	 *
	 * @return QueryBuilder
	 */
	public function users() {
		return $this->belongsToMany('App\User');
	}

	/**
	 * many-to-many relationship method.
	 *
	 * @return QueryBuilder
	 */
	public function permissions() {
		return $this->belongsToMany('NGiraud\ACL\Permission');
	}

	public function scopeGetForSelector($query) {
		return $query->get()->sortBy('title')->pluck('title', 'id')->all();
	}
}
