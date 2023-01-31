<?php

namespace Database\Seeders;

use App\Models\Loto;
use App\Services\LoteriasService;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LotosTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $lotosNames = ['megasena', 'quina', 'lotofacil', 'lotomania', 'duplasena', 'timemania', 'diadesorte'];

        foreach ($lotosNames as $name) {
            Loto::create([
                'name' => $name
            ]);
        }
    }
}
