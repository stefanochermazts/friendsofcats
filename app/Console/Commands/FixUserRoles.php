<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class FixUserRoles extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'users:test-registration {email} {name} {password}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Test user registration with NULL role';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $email = $this->argument('email');
        $name = $this->argument('name');
        $password = $this->argument('password');
        
        // Check if user already exists
        if (User::where('email', $email)->exists()) {
            $this->error('User with this email already exists.');
            return;
        }
        
        // Create user with NULL role (simulating registration)
        $user = User::create([
            'name' => $name,
            'email' => $email,
            'password' => Hash::make($password),
            'role' => null, // NULL role for new registrations
        ]);
        
        $this->info('Test user created successfully!');
        $this->info("Email: {$email}");
        $this->info("Password: {$password}");
        $this->info("Role: " . ($user->role ?? 'NULL'));
        $this->info("User ID: {$user->id}");
    }
}
