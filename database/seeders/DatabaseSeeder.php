<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
        DB::table('awards')->insert([
            [
                "award" => 'navegacion_telcel',
                "available_at" => date("d-m-Y"),
                "status" => 'available',
                "created_at" => now(),
                "updated_at" => null
            ],
            [
                "award" => 'navegacion_telcel',
                "available_at" => date("d-m-Y"),
                "status" => 'available',
                "created_at" => now(),
                "updated_at" => null
                ],
            [
                "award" => 'recarga_telefónica',
                "available_at" => date("d-m-Y"),
                "status" => 'available',
                "created_at" => now(),
                "updated_at" => null
            ],
            [
                "award" => 'recarga_telefónica',
                "available_at" => date("d-m-Y"),
                "status" => 'available',
                "created_at" => now(),
                "updated_at" => null
            ],
            [
                "award" => 'recarga_telefónica',
                "available_at" => date("d-m-Y"),
                "status" => 'not_available',
                "created_at" => now(),
                "updated_at" => '2022-02-02 13:45:20'
            ],
        ]);
    }
}
