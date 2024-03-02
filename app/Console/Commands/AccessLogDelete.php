<?php

namespace App\Console\Commands;

use App\Models\AccessLog;
use Illuminate\Console\Command;

class AccessLogDelete extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:access-log-delete';

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
        if ($this->confirm('本当に削除しますか？')) {
            AccessLog::query()->withoutGlobalScope('ipIgnore')->delete();
            $this->info('削除しました');
        } else {
            $this->info('キャンセルしました');
        }
    }
}
