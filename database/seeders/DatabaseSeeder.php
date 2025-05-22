<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Use this when used MySQL Database
        // Disable foreign key checks
        //DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        // Truncate tables
        DB::table('job_listings')->truncate();
        DB::table('users')->truncate();
        DB::table('job_user_bookmarks')->truncate();
        DB::table('applicants')->truncate();

        // Use this when used MySQL Database
        // Re-enable foreign key checks
        //DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $this->call(TestUserSeeder::class);
        $this->call(RandomUserSeeder::class);
        $this->call(JobSeeder::class);
        $this->call(BookmarkSeeder::class);
    }
}
