<?php

namespace Database\Seeders;

use App\Models\City;
use App\Models\Country;
use App\Models\User;
use Faker\Factory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class UserAddressSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Stop foreign key constraints from preventing to remove table 
        Schema::disableForeignKeyConstraints();
        // DB::table('user_addresses')->truncate();
        

        $faker = Factory::create();

        $khaleel    = User::whereUsername('khaleel')->first();
        $ksa        = Country::with('states')->whereId(194)->first();
        $state      = $ksa->states->random()->id;
        // $state      = $ksa->states()->random()->id;
        $city       = City::whereStateId($state)->inRandomOrder()->first()->id;

        $khaleel->addresses()->create([
            'address_title'     =>  'Home',
            'default_address'   =>   true,
            'first_name'        =>  'khaleel',
            'last_name'         =>  'raweh',
            'email'             =>  $faker->email(),
            'mobile'            =>  $faker->phoneNumber(),
            'address'           =>  $faker->address,
            'address2'          =>  $faker->secondaryAddress,
            'country_id'        =>  $ksa->id,
            'state_id'          =>  $state,
            'city_id'           =>  $city,
            'zip_code'          =>  $faker->randomNumber(5),
            'po_box'            =>  $faker->randomNumber(4),

        ]);

        $khaleel->addresses()->create([
            'address_title'     =>  'Work',
            'default_address'   =>   false,
            'first_name'        =>  'khaleel',
            'last_name'         =>  'raweh',
            'email'             =>  $faker->email(),
            'mobile'            =>  $faker->phoneNumber(),
            'address'           =>  $faker->address,
            'address2'          =>  $faker->secondaryAddress,
            'country_id'        =>  $ksa->id,
            'state_id'          =>  $state,
            'city_id'           =>  $city,
            'zip_code'          =>  $faker->randomNumber(5),
            'po_box'            =>  $faker->randomNumber(4),

        ]);



        Schema::enableForeignKeyConstraints();


    }
}
