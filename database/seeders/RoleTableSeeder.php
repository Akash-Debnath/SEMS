<?php
namespace Database\Seeders;

use App\Helpers\Helper;
use App\Models\Role;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;

class RoleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Schema::disableForeignKeyConstraints();
        Role::truncate();

        $roles = [
            'Super Admin',
            'Admin',
            'Moderator',
            'Editor',
            'Agent'
        ];


        foreach ($roles as $role) {

            // Role::Create(['name' => $role, 'slug' => Helper::slugify($role)]);    //Stopped by Akash for slugify.

        }

        Schema::enableForeignKeyConstraints();
    }
}
