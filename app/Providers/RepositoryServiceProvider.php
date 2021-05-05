<?php

namespace App\Providers;

use App\Contracts\Repositories\SystemTransactions\ISystemTransactionsRepository;
use App\Contracts\Repositories\UsersTransactions\IUsersTransactionsRepository;
use App\Contracts\Repositories\Wallet\IWalletRepository;
use App\Repositories\SystemTransactions\SystemTransactionsRepository;
use App\Repositories\UsersTransactions\UsersTransactionsRepository;
use App\Repositories\Wallet\WalletRepository;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(IWalletRepository::class, WalletRepository::class);
        $this->app->bind(ISystemTransactionsRepository::class, SystemTransactionsRepository::class);
        $this->app->bind(IUsersTransactionsRepository::class, UsersTransactionsRepository::class);
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
