<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionsTableSeeder extends Seeder
{    
    public function run()
    {
        $permission = [                
                // User Module
        	[
                        'name' => "manage-permissions",
                        'display_name' => "Manage Permissions",
                        'description' => "Manage permissions",
                        'type' => "Users"
                ],                    
                [
                        'name' => "add-users",
                        'display_name' => "Add Users",
                        'description' => "Add users",
                        'type' => "Users"
                ],    
                [
                        'name' => "edit-users",
                        'display_name' => "Edit Users",
                        'description' => "Edit users",
                        'type' => "Users"
                ],
                [
                        'name' => "view-users",
                        'display_name' => "View Users",
                        'description' => "View users",
                        'type' => "Users"
                ],                
                [
                        'name' => "delete-users",
                        'display_name' => "Delete Users",
                        'description' => "Delete users",
                        'type' => "Users"
                ],
                [
                        'name' => "add-roles",
                        'display_name' => "Add Roles",
                        'description' => "Add roles",
                        'type' => "Users"
                ],    
                [
                        'name' => "edit-roles",
                        'display_name' => "Edit Roles",
                        'description' => "Edit roles",
                        'type' => "Users"
                ],
                [
                        'name' => "view-roles",
                        'display_name' => "View Roles",
                        'description' => "View roles",
                        'type' => "Users"
                ],
                [
                        'name' => "delete-roles",
                        'display_name' => "Delete Roles",
                        'description' => "Delete roles",
                        'type' => "Users"
                ],
                // Auditlog Module
                [
                        'name' => "audit-logs",
                        'display_name' => "Audit Logs",
                        'description' => "Audit logs",
                        'type' => "Logs"
                ],

        ];
        
        foreach ($permission as $key => $value) {
        	Permission::create($value);
        }
    }
}
