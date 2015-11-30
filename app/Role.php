<?php namespace A3LWebInterface;

use Zizaco\Entrust\EntrustRole;

class Role extends EntrustRole
{

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
        'name' => 'required|alpha_dash|max:255|unique:permissions',
        'display_name' => 'required|max:255',
        'description' => 'required|max:255',
        'comment' => 'required'
    );
}