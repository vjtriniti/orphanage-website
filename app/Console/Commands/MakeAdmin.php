<?php

namespace App\Console\Commands;

use App\Models\Role;
use App\Models\User;
use Illuminate\Console\Command;

class MakeAdmin extends Command
{
    protected $signature = 'app:make-admin {email : Existing user email}';
    protected $description = 'Grant the super-admin role to an existing user';

    public function handle(): int
    {
        $user = User::where('email', $this->argument('email'))->first();
        if (!$user) {
            $this->error('User not found. Register the account first.');
            return self::FAILURE;
        }

        $role = Role::where('name', 'super-admin')->first();
        if (!$role) {
            $this->error('The super-admin role is not seeded yet. Run php artisan migrate first.');
            return self::FAILURE;
        }

        $user->forceFill(['is_admin' => true])->save();
        $user->roles()->syncWithoutDetaching([$role->id]);

        $this->info("{$user->email} is now an administrator.");
        return self::SUCCESS;
    }
}
