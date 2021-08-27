<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\InternalAdmin;

class InternalAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $internalAdmin = new InternalAdmin();
        $internalAdmin->minimum_price = 6.50;
        $internalAdmin->save();
    }
}
