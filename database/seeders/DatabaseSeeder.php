<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Permission;
use App\Models\Group;
use App\Models\Image;
use App\Models\Role;
use App\Models\SystemSetting;
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

        Image::create(['path' =>'https://mir-s3-cdn-cf.behance.net/project_modules/max_1200/dba49e79778043.5ccdb90d4adfc.jpg', 'external' => true, 'uploader_id' => 1]);
        Image::create(['path' =>'https://static.vecteezy.com/system/resources/previews/000/476/390/original/vector-summer-beach-vacation-club-poster.jpg', 'external' => true, 'uploader_id' => 2]);
        Image::create(['path' =>'https://static.vecteezy.com/system/resources/previews/000/669/980/original/vector-travel-poster-template.jpg', 'external' => true, 'uploader_id' => 3]);
        Image::create(['path' =>'https://s3.envato.com/files/229310228/01_preview.jpg', 'external' => true, 'uploader_id' => 4]);

        \App\Models\Event::factory(8)->create();

        \App\Models\User::factory()->create([
            'first_name' => 'Test',
            'last_name' => 'Admin',
            'email' => 'admin@example.com',
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'remember_token' => 'rememberme',
        ]);

        $account_custom_fields = [
            array(
                'name' => 'personal_email',
                'label' => 'Personal Email address',
                'type' => 'email',
                'required' => true,
            ),
            array(
                'name' => 'start_year',
                'label' => 'Starting year',
                'type' => 'number',
                'min' => '2010',
                'max' => '2030',
                'required' => true,
            ),
            array(
                'name' => 'phone_number',
                'label' => 'Mobile phone number',
                'type' => 'tel',
                'pattern' => '06-?[0-9]{8}',
                'required' => false,
            ),
            array(
                'name' => 'bachelor',
                'label' => 'Bachelor(s)',
                'type' => 'select',
                'multiple' => true,
                'options' => [
                    'BA' => 'BSc A', 
                    'BB' => 'BSc B', 
                    'BC' => 'BSc C', 
                    'BD' => 'BSc D', 
                    'BE' => 'BSc E'
                ],
                'required' => true,
            )
        ];
        SystemSetting::create(['key' => 'site.name', 'value' => 'OpenMMA', 'type' => 'text']);
        SystemSetting::create(['key' => 'account.custom_fields', 'value' => json_encode($account_custom_fields), 'type' => 'json']);
    }
}
