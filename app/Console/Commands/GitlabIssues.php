<?php

namespace App\Console\Commands;

use App\Gitlab\Issue;
use App\Gitlab\Projects;
use App\Log;
use Illuminate\Console\Command;

class GitlabIssues extends Command
{
    protected $signature = 'gitlab:issue';
    protected $description = 'Refresh the Gitlab issue cache.';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        Log::artisan($this->signature);
        try {
            $issues = Issue::all(true);
        } catch(\Exception $e) {
            $this->error('Gitlab is unreachable.');
        }
    }
}
