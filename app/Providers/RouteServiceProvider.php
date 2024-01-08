<?php

namespace App\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * The path to the "home" route for your application.
     *
     * This is used by Laravel authentication to redirect users after login.
     *
     * @var string
     */
    public const HOME = '/home';

    /**
     * The controller namespace for the application.
     *
     * When present, controller route declarations will automatically be prefixed with this namespace.
     *
     * @var string|null
     */
    // protected $namespace = 'App\\Http\\Controllers';

    /**
     * Define your route model bindings, pattern filters, etc.
     *
     * @return void
     */
    public function boot()
    {
        $this->configureRateLimiting();

        $this->routes(function () {

            Route::prefix('ajax/pm')
                ->middleware(['web'])
                ->namespace($this->namespace)
                ->name('ajax.pm.')
                ->group(base_path('routes/ajax_pm_plans.php'));

            Route::prefix('ajax/pm')
                ->middleware(['web'])
                ->namespace($this->namespace)
                ->name('ajax.pm.')
                ->group(base_path('routes/ajax_pm_products.php'));

            Route::prefix('api')
                ->middleware('api')
                ->namespace($this->namespace)
                ->group(base_path('routes/api.php'));

            Route::prefix('api/eam')
                ->middleware('api')
                ->name('api.eam.')
                ->namespace($this->namespace)
                ->group(base_path('routes/api/_eam.php'));

            Route::prefix('api/kms')
                ->middleware('api')
                ->name('api.kms.')
                ->namespace($this->namespace)
                ->group(base_path('routes/api_kms.php'));

            Route::prefix('api/pd')
                ->middleware(['web'])
                ->namespace($this->namespace)
                ->name('api.pd.')
                ->group(base_path('routes/api_pd.php'));

            Route::prefix('api/pm')
                ->middleware(['web'])
                ->namespace($this->namespace)
                ->name('api.pm.')
                ->group(base_path('routes/api_pm.php'));

            Route::prefix('api/pp')
                ->middleware(['web'])
                ->namespace($this->namespace)
                ->name('api.pp.')
                ->group(base_path('routes/api_pp.php'));

            Route::middleware(['web'])
                ->namespace($this->namespace)
                ->group(base_path('routes/web.php'));

            Route::middleware(['web', 'auth'])
                ->namespace($this->namespace)
                ->prefix('example')
                ->name('example.')
                ->group(base_path('routes/example.php'));

            Route::middleware(['web', 'auth'])
                ->namespace($this->namespace)
                ->prefix('pd')
                ->name('pd.')
                ->group(base_path('routes/web_pd.php'));

            Route::middleware(['web', 'auth'])
                ->namespace($this->namespace)
                ->prefix('pm')
                ->name('pm.')
                ->group(base_path('routes/web_pm.php'));

            Route::middleware(['web', 'auth'])
                ->namespace($this->namespace)
                ->prefix('pm')
                ->name('pm.')
                ->group(base_path('routes/web_pm_plans.php'));

            Route::middleware(['web', 'auth'])
                ->namespace($this->namespace)
                ->prefix('pm')
                ->name('pm.')
                ->group(base_path('routes/web_pm_products.php'));

            Route::middleware(['web', 'auth'])
                ->namespace($this->namespace)
                ->prefix('pp')
                ->name('pp.')
                ->group(base_path('routes/web_pp.php'));

            Route::middleware(['web', 'auth'])
                ->namespace($this->namespace)
                ->prefix('eam')
                ->name('eam.')
                ->group(base_path('routes/eam.php'));

            Route::middleware(['web', 'auth'])
                ->namespace($this->namespace)
                ->prefix('ecom')
                ->name('ecom.')
                ->group(base_path('routes/ecom.php'));

            Route::middleware(['web', 'auth'])
                ->namespace($this->namespace)
                ->prefix('om')
                ->name('om.')
                ->group(base_path('routes/om.php'));

            Route::middleware(['web'])
                ->namespace($this->namespace)
                ->prefix('ir')
                ->name('ir.')
                ->group(base_path('routes/ir.php'));

            Route::middleware(['web', 'auth'])
                ->namespace($this->namespace)
                ->prefix('ie')
                ->name('ie.')
                ->group(base_path('routes/ie.php'));

            Route::middleware(['web', 'auth'])
                ->namespace($this->namespace)
                ->prefix('inv')
                ->name('inv.')
                ->group(base_path('routes/inv.php'));

            Route::middleware(['web', 'auth'])
                ->namespace($this->namespace)
                ->prefix('qm')
                ->name('qm.')
                ->group(base_path('routes/qm.php'));

            //PIYAWUT A. 01042021
            Route::middleware(['web', 'auth'])
                ->namespace($this->namespace)
                ->prefix('planning')
                ->name('planning.')
                ->group(base_path('routes/planning.php'));

            Route::middleware(['web', 'auth'])
                ->namespace($this->namespace)
                ->prefix('inv')
                ->name('inv.')
                ->group(base_path('routes/inv.php'));

            //NUTTASUTON S. 19052021
            Route::middleware(['web', 'auth'])
                ->namespace($this->namespace)
                ->prefix('pm')
                ->name('pm.')
                ->group(base_path('routes/pm.php'));

            Route::middleware(['web', 'auth'])
                ->namespace($this->namespace)
                ->prefix('pm')
                ->name('pm.')
                ->group(base_path('routes/pm_qr.php'));

            Route::prefix('ajax/pm')
                ->middleware(['web'])
                ->namespace($this->namespace)
                ->name('ajax.pm.')
                ->group(base_path('routes/ajax_pm_planning_jobs.php'));

            Route::middleware(['web', 'auth'])
                ->namespace($this->namespace)
                ->prefix('pm')
                ->name('pm.')
                ->group(base_path('routes/web_pm_planning_jobs.php'));

            Route::middleware(['web', 'auth'])
                ->namespace($this->namespace)
                ->prefix('pm')
                ->name('pm.')
                ->group(base_path('routes/pm1.php'));

            Route::middleware(['web', 'auth'])
                ->namespace($this->namespace)
                ->prefix('pm')
                ->name('pm.')
                ->group(base_path('routes/pm_wip_confirm.php'));

            Route::middleware(['web', 'auth'])
                ->namespace($this->namespace)
                ->prefix('pm')
                ->name('pm.')
                ->group(base_path('routes/pm_wip_issue.php'));

            Route::middleware(['web', 'auth'])
                ->namespace($this->namespace)
                ->prefix('pd')
                ->name('pd.')
                ->group(base_path('routes/pd.php'));

            Route::middleware(['web', 'auth'])
                ->namespace($this->namespace)
                ->prefix('ct')
                ->name('ct.')
                ->group(base_path('routes/ct.php'));
            Route::middleware(['web', 'auth'])
                ->namespace($this->namespace)
                ->prefix('pm')
                ->name('pm.')
                ->group(base_path('routes/pm-nuk.php'));

            Route::middleware(['web', 'auth'])
                ->namespace($this->namespace)
                ->prefix('pm')
                ->name('pm.')
                ->group(base_path('routes/pm-nick.php'));


            Route::middleware(['web', 'auth'])
                ->namespace($this->namespace)
                ->prefix('pm')
                ->name('pm.')
                ->group(base_path('routes/pm_wip_loss_quantity.php'));

            Route::middleware(['web', 'auth'])
                ->namespace($this->namespace)
                ->prefix('report')
                ->name('report.')
                ->group(base_path('routes/report.php'));

            Route::middleware(['web', 'auth'])
                ->prefix('pm')
                ->name('pm.')
                ->group(base_path('routes/pmp_0031.php'));

            Route::middleware(['web', 'auth'])
                ->namespace($this->namespace)
                ->prefix('om')
                ->name('om.')
                ->group(base_path('routes/om-nuk.php'));

            Route::prefix('api/om')
                ->middleware('api')
                ->name('api.om.')
                ->namespace($this->namespace)
                ->group(base_path('routes/api_om.php'));

            Route::namespace($this->namespace)
                ->prefix('om')
                ->name('om.')
                ->group(base_path('routes/om-nuk.php'));

            Route::middleware(['web', 'auth'])
                ->namespace($this->namespace)
                ->prefix('om')
                ->name('om.')
                ->group(base_path('routes/om_pakin.php'));

            Route::namespace($this->namespace)
                ->prefix('om')
                ->name('om.')
                ->group(base_path('routes/om_zun.php'));

            Route::namespace($this->namespace)
                ->prefix('ir')
                ->name('ir.')
                ->group(base_path('routes/ir_report_soft_berry.php'));


            //NUTTASUTON S. 19052021
            Route::middleware(['web', 'auth'])
                ->namespace($this->namespace)
                ->prefix('ct')
                ->name('ct.')
                ->group(base_path('routes/web_ct.php'));
            Route::prefix('ajax/ct')
                ->middleware(['web'])
                ->namespace($this->namespace)
                ->name('ajax.ct.')
                ->group(base_path('routes/ajax_ct.php'));

            Route::prefix('mobiles')
                ->middleware('mobile')
                ->namespace($this->namespace)
                ->name('mobiles.')
                ->group(base_path('routes/mobile.php'));

            Route::prefix('mobiles/pm')
                ->middleware(['mobile', 'auth.mobile'])
                ->namespace($this->namespace)
                ->name('mobiles.pm.')
                ->group(base_path('routes/mobile/pm.php'));
        });
    }

    /**
     * Configure the rate limiters for the application.
     *
     * @return void
     */
    protected function configureRateLimiting()
    {
        RateLimiter::for('api', function (Request $request) {
            return Limit::perMinute(60)->by(optional($request->user())->id ?: $request->ip());
        });
    }
}
