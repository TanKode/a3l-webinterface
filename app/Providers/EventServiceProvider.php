<?php namespace A3LWebInterface\Providers;

use Illuminate\Contracts\Events\Dispatcher as DispatcherContract;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider {

	/**
	 * The event handler mappings for the application.
	 *
	 * @var array
	 */
	protected $listen = [
		// Vehicle
		'A3LWebInterface\Events\VehicleUpdated' => [
			'A3LWebInterface\Handlers\Events\WebLogAction',
			'A3LWebInterface\Handlers\Events\EmailLogAction',
		],
		'A3LWebInterface\Events\VehicleDeleted' => [
			'A3LWebInterface\Handlers\Events\WebLogAction',
            'A3LWebInterface\Handlers\Events\EmailLogAction',
		],

		// Player
		'A3LWebInterface\Events\PlayerUpdated' => [
			'A3LWebInterface\Handlers\Events\WebLogAction',
            'A3LWebInterface\Handlers\Events\EmailLogAction',
		],

		// Gang
		'A3LWebInterface\Events\GangUpdated' => [
			'A3LWebInterface\Handlers\Events\WebLogAction',
			'A3LWebInterface\Handlers\Events\EmailLogAction',
		],

		// User
		'A3LWebInterface\Events\UserCreated' => [
			'A3LWebInterface\Handlers\Events\WebLogAction',
            'A3LWebInterface\Handlers\Events\EmailLogAction',
		],
		'A3LWebInterface\Events\UserUpdated' => [
			'A3LWebInterface\Handlers\Events\WebLogAction',
            'A3LWebInterface\Handlers\Events\EmailLogAction',
		],
		'A3LWebInterface\Events\UserDeleted' => [
			'A3LWebInterface\Handlers\Events\WebLogAction',
            'A3LWebInterface\Handlers\Events\EmailLogAction',
		],

		// Role
		'A3LWebInterface\Events\RoleCreated' => [
			'A3LWebInterface\Handlers\Events\WebLogAction',
            'A3LWebInterface\Handlers\Events\EmailLogAction',
		],
		'A3LWebInterface\Events\RoleUpdated' => [
			'A3LWebInterface\Handlers\Events\WebLogAction',
            'A3LWebInterface\Handlers\Events\EmailLogAction',
		],

		// Permission
		'A3LWebInterface\Events\PermissionCreated' => [
			'A3LWebInterface\Handlers\Events\WebLogAction',
            'A3LWebInterface\Handlers\Events\EmailLogAction',
		],
		'A3LWebInterface\Events\PermissionUpdated' => [
			'A3LWebInterface\Handlers\Events\WebLogAction',
            'A3LWebInterface\Handlers\Events\EmailLogAction',
		],

		// Backup
		'A3LWebInterface\Events\BackupCreated' => [
			'A3LWebInterface\Handlers\Events\EmailBackup',
		],
	];

	/**
	 * Register any other events for your application.
	 *
	 * @param  \Illuminate\Contracts\Events\Dispatcher  $events
	 * @return void
	 */
	public function boot(DispatcherContract $events)
	{
		parent::boot($events);
	}

}
