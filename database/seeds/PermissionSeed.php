<?php

use Illuminate\Database\Seeder;

class PermissionSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $items = [
            
            ['id' => 1, 'title' => 'user_management_access',],
            ['id' => 2, 'title' => 'user_management_create',],
            ['id' => 3, 'title' => 'user_management_edit',],
            ['id' => 4, 'title' => 'user_management_view',],
            ['id' => 5, 'title' => 'user_management_delete',],
            ['id' => 6, 'title' => 'permission_access',],
            ['id' => 7, 'title' => 'permission_create',],
            ['id' => 8, 'title' => 'permission_edit',],
            ['id' => 9, 'title' => 'permission_view',],
            ['id' => 10, 'title' => 'permission_delete',],
            ['id' => 11, 'title' => 'role_access',],
            ['id' => 12, 'title' => 'role_create',],
            ['id' => 13, 'title' => 'role_edit',],
            ['id' => 14, 'title' => 'role_view',],
            ['id' => 15, 'title' => 'role_delete',],
            ['id' => 16, 'title' => 'user_access',],
            ['id' => 17, 'title' => 'user_create',],
            ['id' => 18, 'title' => 'user_edit',],
            ['id' => 19, 'title' => 'user_view',],
            ['id' => 20, 'title' => 'user_delete',],
            ['id' => 21, 'title' => 'property_access',],
            ['id' => 22, 'title' => 'property_create',],
            ['id' => 23, 'title' => 'property_edit',],
            ['id' => 24, 'title' => 'property_view',],
            ['id' => 25, 'title' => 'property_delete',],
            ['id' => 26, 'title' => 'document_access',],
            ['id' => 27, 'title' => 'document_create',],
            ['id' => 28, 'title' => 'document_edit',],
            ['id' => 29, 'title' => 'document_view',],
            ['id' => 30, 'title' => 'document_delete',],
            ['id' => 31, 'title' => 'note_access',],
            ['id' => 32, 'title' => 'note_create',],
            ['id' => 33, 'title' => 'note_edit',],
            ['id' => 34, 'title' => 'note_view',],
            ['id' => 35, 'title' => 'note_delete',],

        ];

        foreach ($items as $item) {
            \App\Permission::create($item);
        }
    }
}
