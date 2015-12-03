<?php
namespace A3LWebInterface;

use Zizaco\Entrust\EntrustRole;

class Role extends EntrustRole
{
    protected $fillable = ['*'];
    protected $hidden = [''];
    protected $guarded = [''];

    public static $rules = array(
        'name' => 'required|alpha_dash|max:255|unique:permissions',
        'display_name' => 'required|max:255',
        'description' => 'required|max:255',
        'comment' => 'required'
    );
}