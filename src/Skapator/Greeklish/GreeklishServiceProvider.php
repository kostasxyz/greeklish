<?php namespace Skapator\Greeklish;

use Illuminate\Support\ServiceProvider;

class GreeklishServiceProvider extends ServiceProvider {

	/**
	 * Indicates if loading of the provider is deferred.
	 *
	 * @var bool
	 */
	protected $defer = false;

    /**
    * Bootstrap the application events.
    *
    * @return void
    */
    public function boot()
    {
        $this->package('skapator/greeklish');
    }

	/**
	 * Register the service provider.
	 *
	 * @return void
	 */
	public function register()
	{
        $this->app['greeklish'] = $this->app->share(function($app)
        {
            return new Greeklish;
        });
	}

	/**
	 * Get the services provided by the provider.
	 *
	 * @return array
	 */
	public function provides()
	{
		return array('greeklish');
	}

}