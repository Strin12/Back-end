<?php

namespace Database\Seeders;
use App\Models\Roles;

use Illuminate\Database\Seeder;

class RolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $role = new Roles();
        $role->name = 'Admin';
        $role->save();

     $role = new Roles();
        $role->name = 'APP';
        $role->save();
    }
}
