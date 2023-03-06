<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Permission;
use App\Models\Group;
use App\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        Group::create(['name' => 'member', 'title' => 'Member', 'color' => '#3AC7DA']);
        Permission::createPermissionsForGroup('member');
        Role::create(['name' => 'member.', 'title' => '']);
        Group::create(['name' => 'alumni', 'title' => 'Alumni', 'color' => '#3A40DA']);
        Permission::createPermissionsForGroup('alumni');
        Role::create(['name' => 'alumni.', 'title' => '']);
        Group::create(['name' => 'board', 'title' => 'Board', 'color' => '#AB3ADA']);
        Permission::createPermissionsForGroup('board');
        Role::create(['name' => 'board.', 'title' => '']);
        
        \App\Models\User::factory(20)->create();
        \App\Models\Event::factory(8)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
    }
}
