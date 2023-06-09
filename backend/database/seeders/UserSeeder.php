<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Schema::disableForeignKeyConstraints();
        DB::table('users')->truncate();
        Schema::enableForeignKeyConstraints();

        $user = User::create([
            'email' => 'oussamasikaddour@gmail.com',
            'password' => Hash::make('Vide=1342'),
            'name' => 'oussSika',
        ]);
        $user->roles()->attach(Role::where('slug', 'superAdmin')->first());
        // User::factory()
        //     ->count(30)
        //     ->create();
    }
}
