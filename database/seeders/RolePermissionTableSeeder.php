<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolePermissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // create role
        $roleSuperAdmin = Role::create(['name' => 'SuperAdmin']);
        // $role = Role::create(['name' => 'Admin']);
        // $role = Role::create(['name' => 'Marketer']);

        //permimssion list array

        $permissions=[
            [
                'group_name'=>'dashboard',
                'permission'=>[
                    'dashboard.view',
                ],
            ],
            [
                'group_name'=>'dataentry',
                'permission'=>[
                    'data.view',
                    'data.edit',
                    'data.create',
                    'data.delete',
                ],
            ],
            [
                'group_name'=>'report',
                'permission'=>[
                    'report.view',
                    'report.edit',
                    'report.create',
                    'report.delete',
                ],
            ],
            [
                'group_name'=>'user',
                'permission'=>[
                    'user.view',
                    'user.edit',
                    'user.create',
                    'user.delete',
                ],
            ]
        ];

        //create and assign permission

        for ($i=0; $i < count($permissions) ; $i++) {
            $permissionGroup=$permissions[$i]['group_name'];
            for ($j=0; $j < count($permissions[$i]['permission']); $j++) {
                $permission=Permission::create(['name'=>$permissions[$i]['permission'][$j],'group_name'=>$permissionGroup]);
                $roleSuperAdmin->givePermissionTo([$permission]);
                $permission->assignRole([$roleSuperAdmin]);
            }
        }
        DB::table('model_has_roles')->insert([
            'role_id'=>1,
            'model_type'=>'App\Models\User',
            'model_id'=>1
        ]);
    }
}