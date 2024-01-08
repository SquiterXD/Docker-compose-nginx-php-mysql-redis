<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class HelpersServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        foreach (glob(app_path() . '/Helpers/*.php') as $helpersfilename)
        {
            require_once($helpersfilename);
        }

        foreach (glob(app_path() . '/Helpers/IE/*.php') as $helpersfilename)
        {
            require_once($helpersfilename);
        }

        foreach (glob(app_path() . '/Helpers/OM/*.php') as $helpersfilename)
        {
            require_once($helpersfilename);
        }

        foreach (glob(app_path() . '/Helpers/IR/*.php') as $helpersfilename)
        {
            require_once($helpersfilename);
        }

        foreach (glob(app_path() . '/Helpers/EAM/*.php') as $helpersfilename)
        {
            require_once($helpersfilename);
        }

        foreach (glob(app_path() . '/Helpers/QM/*.php') as $helpersfilename)
        {
            require_once($helpersfilename);
        }

        foreach (glob(app_path() . '/Helpers/Planning/*.php') as $helpersfilename)
        {
            require_once($helpersfilename);
        }

        foreach (glob(app_path() . '/Helpers/PM/*.php') as $helpersfilename){
            require_once($helpersfilename);
        }

        foreach (glob(app_path() . '/Helpers/PD/*.php') as $helpersfilename)
        {
            require_once($helpersfilename);
        }

        foreach (glob(app_path() . '/Helpers/Reports/*.php') as $helpersfilename)
        {
            require_once($helpersfilename);
        }
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
