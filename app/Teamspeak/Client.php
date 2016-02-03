<?php
namespace App\Teamspeak;

class Client extends Model
{
    public function __construct(array $attributes)
    {
        $this->info = $attributes;
        $this->prepareAttributes();
    }

    private function prepareAttributes()
    {
        if(method_exists($this->info['client_nickname'], 'toString')) {
            $this->nickname = $this->info['client_nickname']->toString();
        } else {
            $this->nickname = $this->info['client_nickname'];
        }
        if(method_exists($this->info['client_country'], 'toString')) {
            $this->country = $this->info['client_country']->toString();
        } else {
            $this->country = $this->info['client_country'];
        }
    }
}