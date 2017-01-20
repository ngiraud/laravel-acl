<?php

namespace NGiraud\ACL\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PermissionRequest extends FormRequest {
	/**
	 * Determine if the user is authorized to make this request.
	 *
	 * @return bool
	 */
	public function authorize() {
		return true;
	}
	
	/**
	 * Get the validation rules that apply to the request.
	 *
	 * @return array
	 */
	public function rules() {
		return [
			'title' => 'required',
			'slug' => 'required|unique:permissions'.($this->method() == 'POST' ? '' : ',id,'.$this->permission),
			'description' => 'present',
			'roles'     => 'required|exists:roles,id',
		];
	}
}
