<?php namespace A3LWebInterface;

use Illuminate\Database\Eloquent\Model;

class Sysload extends Model
{

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'sysload';

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
        'cpu_load' => 'required|numeric|min:0|max:100',
        'ram_load' => 'required|numeric|min:0|max:100',
    );

}
