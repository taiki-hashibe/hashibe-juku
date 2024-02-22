<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class CreateUser extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:user:create';

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
        \App\Models\User::create([
            'user_id' => $name,
            'name' => $name,
            'email' => $email,
            'password' => bcrypt($password),
            'default_password' => '----',
        ]);
        $this->info('User created successfully');
        return Command::SUCCESS;
    }
}
