<?php namespace A3LWebInterface;

use Illuminate\Database\Eloquent\Model;

class Weblog extends Model {

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'weblog';

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

}
