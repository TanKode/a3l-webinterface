<?php namespace A3LWebInterface;

use Illuminate\Database\Eloquent\Model;

class Vehicle extends Model
{

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'vehicles';

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
        'side' => 'required',
        'classname' => 'required',
        'type' => 'required',
        'pid' => 'required|numeric',
        'color' => 'required|numeric',
        'plate' => 'required|numeric',
    );

    public function owner()
    {
        return $this->hasOne('A3LWebInterface\Player', 'playerid', 'pid');
    }

}
