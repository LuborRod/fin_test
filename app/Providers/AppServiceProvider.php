<?php

namespace App\Providers;

use App\Contracts\Services\Calculation\ICalculationService;
use App\Contracts\Services\Wallet\IWalletService;
use App\Services\Calculation\CalculationService;
use App\Services\Wallet\WalletService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public array $singletons = [
        ICalculationService::class => CalculationService::class,
        IWalletService::class => WalletService::class,
    ];


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
        //
    }
}
