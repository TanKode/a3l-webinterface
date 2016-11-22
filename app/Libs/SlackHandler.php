<?php

namespace App\Libs;

use Monolog\Handler\AbstractProcessingHandler;
use Monolog\Logger;

class SlackHandler extends AbstractProcessingHandler
{
    public function __construct($level = Logger::WARNING, $bubble = true)
    {
        parent::__construct($level, $bubble);
    }

    protected function write(array $record)
    {
        try {
            \Slack::to(config('slack.channel'))->withIcon(':beetle:')->attach([
                'fallback' => $record['formatted'],
                'color' => 'danger',
                'fields' => [
                    [
                        'title' => 'Server',
                        'value' => array_get($record, 'server', env('APP_ENV', 'cali')),
                        'short' => true,
                    ],
                    [
                        'title' => 'Level',
                        'value' => array_get($record, 'level_name', 'WARNING'),
                        'short' => true,
                    ],
                    [
                        'title' => 'URL',
                        'value' => array_get($record, 'extra.url'),
                        'short' => true,
                    ],
                    [
                        'title' => 'Request-IP',
                        'value' => array_get($record, 'extra.ip'),
                        'short' => true,
                    ],
                ],
            ])->send(explode("\n", array_get($record, 'message'))[0]);
        } catch (\Exception $e) {
            // ignore it
        }
    }
}
