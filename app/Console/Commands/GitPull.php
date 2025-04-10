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
        // $projectPath = base_path(); // atau ganti path-nya jika di luar Laravel
        // exec("cd {$projectPath} && git pull origin main 2>&1", $output);
        // $output = [];

        $command = 'export HOME=/home/digik3882 && cd /home/digikom.xyz/dev && git pull origin main 2>&1';
        $output = shell_exec($command);

        Log::channel('single')->info('Git Pull Output: ' . $output);
        $this->info($output);
    }
}
