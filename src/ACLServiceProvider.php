<?php

namespace NGiraud\ACL;

use App\User;
use Illuminate\Support\ServiceProvider;

class ACLServiceProvider extends ServiceProvider {

	protected $defer = false;

	/**
	 * Bootstrap the application services.
	 *
	 * @return void
	 */
	public function boot() {
		// Load migrations
		$this->loadMigrationsFrom(__DIR__.'/migrations');

		// Routing
		$this->loadRoutesFrom(__DIR__.'/routes/web.php');

		// Observer for User roles & permissions
		User::observe(UserObserver::class);

		// Publishing config file
		$this->publishes([
			__DIR__.'/config/' => config_path(),
			__DIR__.'/seeds/' => database_path('seeds'),
		], 'acl');
	}

	/**
	 * Register the application services.
	 *
	 * @return void
	 */
	public function register() {
		$this->mergeConfigFrom(
			__DIR__.'/config/acl.php', 'acl'
		);
	}
}
