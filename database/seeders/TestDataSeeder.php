<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Wallet;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class TestDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
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
            $wallet->current_balance = Wallet::START_CURRENT_BALANCE;
            $wallet->hash = $hashes[$i];
            $wallet->save();
            $i++;
        }
    }
}
