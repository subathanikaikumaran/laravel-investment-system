<?php
namespace App\Services;
 
use Illuminate\Support\ServiceProvider;
 
class BackendServiceProvider extends ServiceProvider 
{
	
    public function register()
    {
        $this->app->singleton('App\Services\ApiRepositoryInterface', 'App\Services\GuzzleApiRepository');
        
    }
}

