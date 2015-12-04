<?php
namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

class Gang extends Model
{
    protected $table = 'gangs';

    protected $fillable = ['*'];
    protected $hidden = [''];

    public static $rules = array(
        'name' => 'required|max:32',
        'owner' => 'required|numeric',
        'bank' => 'required|numeric',
        'maxmembers' => 'required|numeric',
    );

    public function owner()
    {
        return $this->hasOne(Player::class, 'playerid', 'owner');
    }

    public function allMembers()
    {
        $members = explode(',', str_replace(['"', '[', ']', '`'], '', $this->attributes['members']));
        $players = array();
        $players[] = Player::where('playerid', $this->attributes['owner'])->first();
        foreach ($members as $member) {
            $players[] = Player::where('playerid', $member)->first();
        }
        $players = array_unique($players);
        sort($players);
        return $players;
    }

}
