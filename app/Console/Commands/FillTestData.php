<?php

namespace App\Console\Commands;

use App\Models\User;
use App\Models\Wallet;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;

class FillTestData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'fill:testData';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $userIds = [];
        $user = new User();
        $user->password = Hash::make('password');
        $user->email = 'the-email@example.com';
        $user->name = 'Vasya';
        $user->save();
        $userIds[] = $user->id;
        $userIds[] = $user->id;

        $user = new User();
        $user->password = Hash::make('password');
        $user->email = 'email@example.com';
        $user->name = 'Petya';
        $user->save();
        $userIds[] = $user->id;
        $userIds[] = $user->id;

        $user = new User();
        $user->password = Hash::make('password');
        $user->email = 'the@example.com';
        $user->name = 'Dima';
        $user->save();
        $userIds[] = $user->id;
        $userIds[] = $user->id;

        $hashes = [
            'g0MJ7HpSRh',
            'C4KCmvqNSd',
            'qPtljyeLz7',
            'FuvqtPKugf',
            'DOQli16WsW',
            'DOQli27WsW',
        ];
        $i = 0;
        foreach ($userIds as $userId) {
            $wallet = new Wallet;
            $wallet->user_id = $userId;
            $wallet->current_balance = 100000000;
            $wallet->hash = $hashes[$i];
            $wallet->save();
            $i++;
        }
    }
}
