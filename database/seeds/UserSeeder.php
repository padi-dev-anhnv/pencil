<?php

use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // insert Roles
        $array_roles = [
            ['type' => 'admin', 'name'=> '管理者'],
            ['type' => 'worker', 'name'=> '業者用'],
            ['type' => 'file_manager', 'name'=> 'ファイルマネージャー用'],
            ['type' => 'instruction_manager', 'name'=> '指図書作成担当'],

        ];
        App\Role::insert($array_roles);

        // insert User by roles
        $admin = App\Role::where('type', 'admin')->first();
        factory(App\User::class, 1)->create([
            'role_id' => $admin->id,
            'username' => 'admin'
        ]);

        // $roles = App\Role::where('type','!=', 'admin')->get();
        factory(App\User::class, 10)->create();
    }
}
