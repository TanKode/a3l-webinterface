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
        return collect(\GitLab::api('issues')->all())->filter(function ($item) {
            return in_array($item['project_id'], [503207]);
        });
    }

    public static function create($projectId, $attributes)
    {
        \Notifynder::loop(Role::where('name', 'super-admin')->first()->users, function(NotifynderBuilder $builder, $to) {
            $builder->category('issue.added')
                ->from(\Auth::User()->id)
                ->to($to->id)
                ->url('app/issue');
        })->send();
        \GitLab::api('issues')->create($projectId, $attributes);
    }
}