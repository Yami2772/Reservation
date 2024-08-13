<?php

namespace Database\Seeders;

use App\Models\Reservation;
use App\Models\Service;
use App\Models\Timing;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class FactorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $timings = Timing::factory()->count(6)->create();
        User::factory()->count(8)->create();
        Service::factory()->count(4)->hasAttached($timings)->create();

        for ($h = 0; $h < 18; $h++) {
            $user = User::inRandomOrder()->first();
            $timing = Timing::inRandomOrder()->first();
            $service = Service::inRandomOrder()->first();
            Reservation::factory()
                ->for($service)
                ->for($timing)
                ->for($user)
                ->create();
        }
    }
}
