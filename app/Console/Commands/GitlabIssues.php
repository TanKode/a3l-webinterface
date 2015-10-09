<?php

namespace App\Console\Commands;

use App\Gitlab\Projects;
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
        try {
            $issues = collect(\GitLab::api('issues')->all())->filter(function ($item) {
                return in_array($item['project_id'], Projects::$IDS);
            });
            if(!is_null($issues)) {
                \Cache::put('gitlab.issues', $issues, 60);
            }
        } catch(\Exception $e) {
            $this->error('Gitlab is unreachable.');
        }
    }
}
