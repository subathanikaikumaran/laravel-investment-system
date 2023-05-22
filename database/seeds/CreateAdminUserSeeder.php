<?php

use Illuminate\Database\Seeder;
use App\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class CreateAdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::create([
        	'username' => 'Admin',
            'email' => 'admin@test.lk',
            'password' => bcrypt('123456'),
            'active' => 1,            
            'pwd_changed' => 1,
            'phone' => 077,
            'gender' => 1,
            'dob' => '2021-08-08'
        ]);

        
  
        $role = Role::create(['name' => 'administrator',
                                'display_name' => 'Administrator',
                                'description' => 'Administrator Role',]);   
        $permissions = Permission::pluck('id','id')->all();  
        $role->syncPermissions($permissions);
        $user->assignRole([$role->id]);
    }
}
