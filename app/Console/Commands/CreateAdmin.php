<?php

namespace App\Console\Commands;

use App\Models\Admin;
use Illuminate\Console\Command;

class CreateAdmin extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:admin:create';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $name = $this->ask('Enter name');
        $email = $this->ask('Enter email');
        /** @var string $password */
        $password = $this->secret('Enter password');
        Admin::create([
            'name' => $name,
            'email' => $email,
            'password' => bcrypt($password),
        ]);
        $this->info('Admin created successfully');
        return Command::SUCCESS;
    }
}
