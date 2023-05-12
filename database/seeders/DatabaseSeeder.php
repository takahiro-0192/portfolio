<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(AccountTableSeeder::class);
        $this->call(AccountsTableSeeder::class);
        $this->call(SendChatTableSeeder::class);
        $this->call(TweetTableSeeder::class);
        $this->call(FriendListTableSeeder::class);
    }
}
