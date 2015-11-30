<?php namespace A3LWebInterface;

use Illuminate\Database\Eloquent\Model;

class Donatorhistory extends Model
{

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'donator_history';

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
        'player_id' => 'required|numeric',
        'date' => 'required',
        'amount' => 'required|numeric',
        'duration' => 'required|numeric',
        'method' => 'required',
        'comment' => 'required',
    );

}
