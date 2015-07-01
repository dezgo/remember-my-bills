<?php namespace App\Providers;

use App\Services\LeagueCSV;
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
            //$messages[] = ['validation.correct_num_columns' => 'this is a test'];
            return new \App\Validators\BillsImportValidator($translator, $data, $rules, $messages);
        });
		//Validator::extend('billimport', '\App\Validators\BillsImportValidator@validate');
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
