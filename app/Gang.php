<?php namespace A3LWebInterface;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

class Gang extends Model
{

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'gangs';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['*'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [''];

    public static $rules = array(
        'name' => 'required|max:32',
        'owner' => 'required|numeric',
        'bank' => 'required|numeric',
        'maxmembers' => 'required|numeric',
    );

    public function owner()
    {
        return $this->hasOne('A3LWebInterface\Player', 'playerid', 'owner');
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
