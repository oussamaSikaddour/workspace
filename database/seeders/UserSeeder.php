<?php

namespace Database\Seeders;

use App\Models\Occupation;
use App\Models\PersonnelInfo;
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
            'email' => 'superAdmin@gmail.com',
            'password' => Hash::make('Vide=1342'),
            'name' => 'super Admin',
        ]);
        $user->roles()->attach(Role::where('slug', 'admin')->first());
        $user->roles()->attach(Role::where('slug', 'super_admin')->first());
        $user->roles()->attach(Role::where('slug', 'user')->first());
        $user->roles()->attach(Role::where('slug', 'approver')->first());
        PersonnelInfo::create(["user_id"=>$user->id]);
        Occupation::create(["user_id"=>$user->id]);
        // User::factory()
        //     ->count(30)
        //     ->create();
    }
}
