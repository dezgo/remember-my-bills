<?php

namespace App\Providers;

use App\Services\LeagueCSV;
use App\Validators\BillsImportValidator;
use Illuminate\Support\ServiceProvider;
use App\Contracts\CSV;

class AppServiceProvider extends ServiceProvider {

	/**
	 * Bootstrap any application services.
	 *
	 * @return void
	 */
	public function boot()
	{
        \Validator::resolver(function($translator, $data, $rules, $messages)
        {
            return new BillsImportValidator($translator, $data, $rules, $messages);
        });

        \Validator::replacer('csvfile', function($message, $attribute, $rule, $parameters) {
            //return str_replace(...);
        });
	}

	/**
	 * Register any application services.
	 *
	 * This service provider is a great spot to register your various container
	 * bindings with the application. As you can see, we are registering our
	 * "Registrar" implementation here. You can add your own bindings too!
	 *
	 * @return void
	 */
	public function register()
	{
		$this->app->bind(
			'Illuminate\Contracts\Auth\Registrar'
		);

		$this->app->bind(CSV::class, function() {
			return new LeagueCSV();
		});
	}

}
