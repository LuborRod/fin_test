<?php

namespace App\Providers;

use App\Contracts\DTO\Transaction\ITransactionData;
use App\Contracts\DTO\TransferSums\ITransferSumsData;
use App\Contracts\Services\Calculation\ICalculationService;
use App\Contracts\Services\SystemTransactions\ISystemTransService;
use App\Contracts\Services\TransferFunds\ITransferFundsService;
use App\Contracts\Services\UsersTransactions\IUsersTransService;
use App\Contracts\Services\Wallet\IWalletService;
use App\DTO\Transaction\TransactionData;
use App\DTO\TransferSums\TransferSumsData;
use App\Services\Calculation\CalculationService;
use App\Services\SystemTransactions\SystemTransService;
use App\Services\TransferFunds\TransferFundsService;
use App\Services\UsersTransactions\UsersTransService;
use App\Services\Wallet\WalletService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public array $singletons = [
        ICalculationService::class => CalculationService::class,
        ISystemTransService::class => SystemTransService::class,
        IUsersTransService::class => UsersTransService::class,
        IWalletService::class => WalletService::class,
        ITransferFundsService::class => TransferFundsService::class,
        ITransactionData::class => TransactionData::class,
        ITransferSumsData::class => TransferSumsData::class,
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
