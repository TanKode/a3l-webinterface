<?php
namespace App\Gitlab;

class Issue
{
    public static function all()
    {
        return collect(\GitLab::api('issues')->all())->filter(function ($item) {
            return in_array($item['project_id'], [18, 16, 11]);
        });
    }

    public static function create($projectId, $attributes)
    {
        \GitLab::api('issues')->create($projectId, $attributes);
    }
}