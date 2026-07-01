<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Story;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        if (!User::where('email', 'test@example.com')->exists()) {
            User::factory()->create([
                'name' => 'Test User',
                'email' => 'test@example.com',
            ]);
        }

        Story::updateOrCreate(
            ['slug' => 'panganay-vs-bunso'],
            [
                'title' => 'Panganay vs. Bunsong Kapatid: Sino ang Dapat Magparaya sa College?',
                'content' => 'May kaunting drama sa pamilya namin ngayon. Ako ang panganay, at matagal ko nang pinag-ipunan ang pangarap kong mag-aral sa isang sikat na unibersidad. Kaso, biglang nagkasabay kami ng bunso kong kapatid na papasok din ng college ngayong taon. Sabi ng mga magulang ko, hindi kaya ng budget ang sabay kaming pag-aralin sa magastos na eskwelahan. Pinipilit nila akong mag-working student o lumipat sa mas murang state college para daw maibigay ang buong suporta sa bunso namin dahil mas \'sakitin\' daw ito. Tama bang magmatigas ako bilang panganay at ipaglaban ang pangarap ko, o ako ba talaga ang dapat magparaya dahil ako ang mas matanda?',
                'option_a' => 'Ipaglaban ang Pangarap',
                'option_b' => 'Magparaya sa Bunso',
            ]
        );
    }
}

