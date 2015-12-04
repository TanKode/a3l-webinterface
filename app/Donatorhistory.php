<?php
namespace App;

use Illuminate\Database\Eloquent\Model;

class Donatorhistory extends Model
{
    protected $table = 'donator_history';

    protected $fillable = ['*'];
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
