<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class GitPull extends Command
{
    protected $signature = 'git:pull';
    protected $description = 'Pull the latest changes from GitHub';

    public function handle()
    {
        $projectPath = base_path(); // atau ganti path-nya jika di luar Laravel
        $output = [];

        exec("cd {$projectPath} && git pull origin main 2>&1", $output);

        Log::info('Git Pull Output:', $output);
        $this->info(implode("\n", $output));
    }
}
