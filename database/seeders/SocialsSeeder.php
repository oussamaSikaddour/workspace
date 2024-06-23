<?php

namespace Database\Seeders;

use App\Models\Social;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class SocialsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Schema::disableForeignKeyConstraints();
        DB::table('socials')->truncate();
        Schema::enableForeignKeyConstraints();
        Social::create([
           'youtube'=>"https://www.youtube.com/",
           'facebook'=>"https://www.facebook.com/",
           'github'=>"https://www.github.com/",
           'linkedin'=>"https://www.linkedin.com/",
        ]);
    }
}
