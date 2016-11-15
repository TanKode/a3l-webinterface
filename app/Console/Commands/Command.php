<?php
namespace App\Console\Commands;

use Illuminate\Console\Command as IlluminateCommand;

class Command extends IlluminateCommand
{
    public function comment($string)
    {
        parent::comment($string);
        \Log::debug($string, $this->getContext());
    }

    public function info($string)
    {
        parent::info($string);
        \Log::info($string, $this->getContext());
    }

    public function warn($string)
    {
        parent::warn($string);
        \Log::warning($string, $this->getContext());
    }

    public function error($string)
    {
        parent::error($string);
        \Log::error($string, $this->getContext());
    }

    protected function getContext()
    {
        return [
            'component' => 'artisan.command',
            'class' => get_called_class(),
            'signature' => $this->signature ?: $this->getName(),
        ];
    }
}