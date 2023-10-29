<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class GroupRoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $groups = ['Device', 'Group', 'BorrowDevice', 'Borrow', 'User', 'Room', 'Role','DeviceType','Nest'];
        $actions = ['viewAny', 'view', 'create', 'update', 'delete', 'restore', 'forceDelete', 'trash'];
        foreach ($groups as $group) {
            foreach ($actions as $action) {
                $name = $group . '_' . $action;
                $group_name = $group;

                $check = DB::table('roles')->where('group_name',$group_name)
                ->where('name',$name)->limit(1)->first();

                if($check){
                    $role_id = $check->id;
                    DB::table('groups_roles')->insert([
                        'group_id' => 1,
                        'role_id' => $role_id,
                    ]);
                }
            }
        }


        $add_roles = [
            [
                'name' => 'Option_update',
                'group_name' => 'Option',
            ],
            [
                'name' => 'Borrow_update_status',
                'group_name' => 'Borrow',
            ],
            [
                'name' => 'Borrow_update_approved',
                'group_name' => 'Borrow',
            ]
        ];

        foreach( $add_roles as $add_role ){
            $name       = $add_role['name'];
            $group_name = $add_role['group_name'];
            $check = DB::table('roles')->where('group_name',$group_name)
                ->where('name',$name)->limit(1)->first();

            if($check){
                $role_id = $check->id;
                DB::table('groups_roles')->insert([
                    'group_id' => 1,
                    'role_id' => $role_id,
                ]);
            }
        }
    }
}
