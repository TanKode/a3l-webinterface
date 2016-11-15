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
        $this->nickname = $this->info['client_nickname']->toString();
        $this->country = $this->info['client_country']->toString();
    }
}