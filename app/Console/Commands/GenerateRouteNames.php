<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;

class GenerateRouteNames extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:generate-route-names';

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
        $routes = Route::getRoutes();
        foreach ($routes->get() as $route) {
            $name = $route->getName();
            if ($name && !Str::startsWith($name, ['admin.', 'ignition.', 'livewire.', 'sanctum.'])) {
                $name = Str::replace(['.'], '-', $name);
                if (config("routes.$name")) {
                    $this->info("'$name' => '" . config("routes.$name") . "',");
                } else {
                    $this->warn("'$name' => '',");
                }
            }
        }
        return Command::SUCCESS;
    }
}
