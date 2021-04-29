<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use SystemTransactionsRepositoryInterface;
use SystemTransactionsRepository;
use UsersTransactionsRepositoryInterface;
use UsersTransactionsRepository;
use WalletRepository;
use WalletRepositoryInterface;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->registerWalletRepository();
        $this->registerUsersTransactionsRepository();
        $this->registerSystemTransactionRepository();
    }

    private function registerWalletRepository()
    {
        $this->app->bind(
            WalletRepositoryInterface::class,
            WalletRepository::class
        );
    }

    private function registerUsersTransactionsRepository()
    {
        $this->app->bind(
            UsersTransactionsRepositoryInterface::class,
            UsersTransactionsRepository::class
        );
    }

    private function registerSystemTransactionRepository()
    {
        $this->app->bind(
            SystemTransactionsRepositoryInterface::class,
            SystemTransactionsRepository::class
        );
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
