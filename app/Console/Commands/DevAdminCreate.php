<?php

namespace App\Console\Commands;

use App\Models\Admin;
use Illuminate\Console\Command;

class DevAdminCreate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'dev:admin-create';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        if (config('app.env') !== 'local') {
            $this->error('This command is only available in the local environment.');
            return;
        }
        $name = config('dev.admin.name');
        $email = config('dev.admin.email');
        $password = config('dev.admin.password');
        if (empty($email) || empty($password)) {
            $this->error('Please set the DEV_ADMIN_EMAIL and DEV_ADMIN_PASSWORD environment variables.');
            return;
        }
        if (Admin::where('name', $name)->exists()) {
            $this->error('An admin user with this name already exists.');
            return;
        }
        if (Admin::where('email', $email)->exists()) {
            $this->error('An admin user with this email already exists.');
            return;
        }
        $this->info('Creating an admin user...');
        Admin::create([
            'name' => 'developer',
            'email' => $email,
            'password' => bcrypt($password),
        ]);
        $this->info('Admin user created.');
    }
}
