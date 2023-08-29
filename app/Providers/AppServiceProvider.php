<?php

namespace App\Providers;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // force https
        
        DB::connection()
        ->getDoctrineSchemaManager()
        ->getDatabasePlatform()
        ->registerDoctrineTypeMapping('enum', 'string');


        Blade::directive('session', function ($session_name) {
            return '<?php if(session()->has('.$session_name.')): $message = session()->get('.$session_name.'); ?>';
        });
    
        Blade::directive('endsession', function () {
            return "<?php endif; ?>";
        });
    }
}
