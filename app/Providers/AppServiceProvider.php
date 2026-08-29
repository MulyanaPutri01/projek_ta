<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Blade;

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
        Paginator::useBootstrapFive();

        // Directive Blade Format Rupiah Indonesia: @rupiah($nominal)
        Blade::directive('rupiah', function ($expression) {
            return "<?php echo 'Rp ' . number_format((float)($expression ?? 0), 0, ',', '.'); ?>";
        });

        // Directive Blade Format Angka Indonesia (tanpa Rp): @angka($nominal)
        Blade::directive('angka', function ($expression) {
            return "<?php echo number_format((float)($expression ?? 0), 0, ',', '.'); ?>";
        });
    }
}
