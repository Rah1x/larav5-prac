<?php

namespace App\Providers;

use Blade;
use Illuminate\Support\ServiceProvider;
use mainHelper;
use Illuminate\Http\Request;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //

        ##1./ Identify Browser and share with Views
        $browser = @$_SERVER['HTTP_USER_AGENT'];
        if((stristr($browser, 'msie')!=false) || (stristr($browser, 'trident')!=false)) {$browser = 'msie';}
        if(stristr($browser, 'chrome')!=false) {$browser = str_ireplace('safari', '', $browser);}
        view()->share('browser', $browser);
        #-
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
