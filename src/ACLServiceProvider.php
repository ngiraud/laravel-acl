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
			__DIR__.'/config/acl.php' => config_path('acl.php'),
			__DIR__.'/seeds/ACLSeeder.php' => database_path('seeds/ACLSeeder.php'),
			__DIR__.'/seeds/UserTableSeeder.php' => database_path('seeds/UserTableSeeder.php'),
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
