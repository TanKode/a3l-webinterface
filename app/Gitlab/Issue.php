<?php
namespace App\Gitlab;

use Fenos\Notifynder\Builder\NotifynderBuilder;
use Silber\Bouncer\Database\Role;

class Issue
{
    public static $rules = [
        'project_id' => 'required|numeric',
        'title' => 'required|string',
        'description' => 'required|string',
    ];

    public static function all()
    {
        try {
            return \Cache::remember('gitlab.issues', 60, function () {
                return collect(\GitLab::api('issues')->all())->filter(function ($item) {
                    return in_array($item['project_id'], Projects::IDS);
                });
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