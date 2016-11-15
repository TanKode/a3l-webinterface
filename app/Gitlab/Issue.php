<?php
namespace App\Gitlab;

use Fenos\Notifynder\Builder\NotifynderBuilder;
use Illuminate\Support\Collection;
use Silber\Bouncer\Database\Role;

class Issue
{
    public static $rules = [
        'project_id' => 'required|numeric',
        'title' => 'required|string',
        'description' => 'required|string',
    ];

    public static function all($update = false)
    {
        try {
            if ($update) {
                $issues = new Collection();
                foreach (Projects::$IDS as $projectId) {
                    $tmp = \GitLab::api('issues')->all($projectId, 1, 100);
                    foreach ($tmp as $issue) {
                        $issues->put($issue['id'], $issue);
                    }
                }
                \Cache::put('gitlab.issues', $issues, 60);
            }
            return \Cache::remember('gitlab.issues', 60, function () {
                $issues = new Collection();
                foreach (Projects::$IDS as $projectId) {
                    $tmp = \GitLab::api('issues')->all($projectId, 1, 100);
                    foreach ($tmp as $issue) {
                        $issues->put($issue['id'], $issue);
                    }
                }
                return $issues;
            });
        } catch (\Exception $e) {
            return collect([]);
        }
    }

    public static function create($projectId, $attributes)
    {
        \Notifynder::loop(Role::where('name', 'super-admin')->first()->users, function (NotifynderBuilder $builder, $to) {
            $builder->category('issue.added')
                ->from(\Auth::User()->id)
                ->to($to->id)
                ->url('app/issue');
        })->send();
        \GitLab::api('issues')->create($projectId, $attributes);
        \Cache::forget('gitlab.issues');
    }
}