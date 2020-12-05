<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call('UserSeeder');
        $this->command->info('users table seeded');
        $this->call('WordSeeder');
        $this->command->info('words table seeded');
        // $this->call('RolePermission');
        // $this->command->info('role permission table seeded');
    }
}
