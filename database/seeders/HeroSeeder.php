<?php

namespace Database\Seeders;
use App\Models\Hero;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class HeroSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Schema::disableForeignKeyConstraints();
        DB::table('heros')->truncate();
        Schema::enableForeignKeyConstraints();
        Hero::create([
           'title_ar'=>'الشراكة المعلوماتية',
           'title_fr'=>'PARTENAIRE INFORMATIQUE',
           'sub_title_ar'=>'أكثر من مستشار',
           'sub_title_fr'=>"Plus qu'un consultant",
        ]);
    }
}
