<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Color;
use App\Models\User;
use Illuminate\Database\Seeder;
use App\Models\Groups\Group;
use App\Models\Groups\GroupCategory;
use App\Models\Groups\Permission;
use App\Models\Groups\Role;
use App\Models\Image;
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
        // Global permissions
        Permission::createPermissionsForGroup('*');
        array_map(
            fn($permission_name) =>
                Permission::create(['name' => $permission_name]),
            array_keys(Permission::$global_permissions)
        );
        array_map(
            fn($permission_name) =>
                Permission::create(['name' => $permission_name]),
            array_keys(Permission::$implicit_permissions)
        );

        // Colors
        Color::create(['primary' => '#ff595e', 'secondary' => '#ff898d']);
        Color::create(['primary' => '#ffca3a', 'secondary' => '#ffda74']);
        Color::create(['primary' => '#8ac926', 'secondary' => '#afe160']);
        Color::create(['primary' => '#1982c4', 'secondary' => '#4bace8']);
        Color::create(['primary' => '#6a4c93', 'secondary' => '#967bbb']);
        Color::create(['primary' => '#3ac7da', 'secondary' => '#87dde8']);

        // System settings
        SystemSetting::create(['key' => 'site.name', 'value' => 'OpenMMA', 'type' => 'text']);
        SystemSetting::create(['key' => 'site.logo', 'value' => 'logo.png', 'type' => 'image']);
        SystemSetting::create(['key' => 'account.custom_fields', 'value' => json_encode([]), 'type' => 'json']);

        // Create super-admin role
        $admin_role = Role::create(['name' => ':admin', 'title' => 'Admin', 'group' => null]);
        $admin_role->givePermissionTo('*.event.*');
        $admin_role->givePermissionTo('*.registration.*');
        $admin_role->givePermissionTo('*.role.*');
        $admin_role->givePermissionTo('group.*');
        $admin_role->givePermissionTo('user.*');
        $admin_role->givePermissionTo('give_global_permissions');
        $admin_role->givePermissionTo('access_dashboard');

        // Create default groups
        $group_members = Group::create(['name' => 'members', 'label' => 'Members', 'color' => 6]);
        Permission::createPermissionsForGroup('members');
        Role::create(['name' => 'members.', 'title' => 'Member', 'isBaseRole' => true, 'group' => $group_members->id]);
        $group_alumni = Group::create(['name' => 'alumni', 'label' => 'Alumni', 'color' => 1]);
        Permission::createPermissionsForGroup('alumni');
        Role::create(['name' => 'alumni.', 'title' => 'Alumnus', 'isBaseRole' => true, 'group' => $group_alumni->id]);
        $group_board = Group::create(['name' => 'board', 'label' => 'Board', 'color' => 2]);
        Permission::createPermissionsForGroup('board');
        Role::create(['name' => 'board.', 'title' => 'Board member', 'isBaseRole' => true, 'group' => $group_board->id]);


        // !!!
        // Only run this in development, not in production!
        // !!!
        if (app()->environment(['local'])) {
            // Group categories
            GroupCategory::create(['label' => 'Committees']);
            GroupCategory::create(['label' => 'Societies']);

            // Groups & roles
            Role::create(['name' => 'board.chair', 'title' => 'Chair', 'isBaseRole' => false, 'group' => $group_board->id]);
            Role::create(['name' => 'board.secretary', 'title' => 'Secretary', 'isBaseRole' => false, 'group' => $group_board->id]);
            Role::create(['name' => 'board.treasurer', 'title' => 'Treasurer', 'isBaseRole' => false, 'group' => $group_board->id]);

            $group_committee_1 = Group::create(['name' => 'committee-1', 'label' => 'Committee 1', 'color' => 3, 'category' => 1]);
            Permission::createPermissionsForGroup('committee-1');
            Role::create(['name' => 'committee-1.', 'title' => 'Committee 1', 'isBaseRole' => true, 'group' => $group_committee_1->id]);
            $group_committee_2 = Group::create(['name' => 'committee-2', 'label' => 'Committee 2', 'color' => 4, 'category' => 1]);
            Permission::createPermissionsForGroup('committee-2');
            Role::create(['name' => 'committee-2.', 'title' => 'Committee 2', 'isBaseRole' => true, 'group' => $group_committee_2->id]);
            $group_committee_3 = Group::create(['name' => 'committee-3', 'label' => 'Committee 3', 'color' => 5, 'category' => 1]);
            Permission::createPermissionsForGroup('committee-3');
            Role::create(['name' => 'committee-3.', 'title' => 'Committee 3', 'isBaseRole' => true, 'group' => $group_committee_3->id]);

            // Users
            User::factory(20)->create();
            foreach (User::get() as $user) {
                $user->assignRole('members.');
            }
            $board = User::inRandomOrder()->limit(5)->get();
            foreach ($board as $user) {
                $user->assignRole('board.');
            }
            $board[0]->assignRole('board.chair');
            $board[1]->assignRole('board.secretary');
            $board[2]->assignRole('board.treasurer');

            foreach (User::inRandomOrder()->limit(3)->get() as $user) {
                $user->removeRole('members.');
                $user->assignRole('alumni.');
            }

            // Test images
            Image::create(['path' =>'https://mir-s3-cdn-cf.behance.net/project_modules/max_1200/dba49e79778043.5ccdb90d4adfc.jpg', 'external' => true, 'uploader_id' => 1]);
            Image::create(['path' =>'https://static.vecteezy.com/system/resources/previews/000/476/390/original/vector-summer-beach-vacation-club-poster.jpg', 'external' => true, 'uploader_id' => 2]);
            Image::create(['path' =>'https://static.vecteezy.com/system/resources/previews/000/669/980/original/vector-travel-poster-template.jpg', 'external' => true, 'uploader_id' => 3]);
            Image::create(['path' =>'https://s3.envato.com/files/229310228/01_preview.jpg', 'external' => true, 'uploader_id' => 4]);

            // Events
            \App\Models\Events\Event::factory(24)->create();

            // Admin user
            $admin = User::factory()->create([
                'first_name' => 'Test',
                'last_name' => 'Admin',
                'email' => 'admin@example.com',
                'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
                'remember_token' => 'rememberme',
            ]);
            $admin->assignRole(':admin');

            // Set custom account fields
            $account_custom_fields = [
                array(
                    'name' => 'persemail',
                    'label' => 'Personal Email address',
                    'type' => 'email',
                    'required' => true,
                ),
                array(
                    'name' => 'cohort',
                    'label' => 'Cohort',
                    'type' => 'number',
                    'min' => '2010',
                    'max' => '2030',
                    'required' => true,
                ),
                array(
                    'name' => 'mobile',
                    'label' => 'Mobile phone number',
                    'type' => 'tel',
                    'pattern' => '06-?[0-9]{8}',
                    'required' => false,
                ),
                array(
                    'name' => 'opleiding',
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
            SystemSetting::where(['key' => 'account.custom_fields'])->update(['value' => json_encode($account_custom_fields)]);
            User::syncCustomFields([], $account_custom_fields);
        }
    }
}
