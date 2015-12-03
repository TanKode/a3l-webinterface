<?php
namespace A3LWebInterface;

use Zizaco\Entrust\EntrustPermission;

class Permission extends EntrustPermission
{
    protected $fillable = ['*'];
    protected $hidden = [''];

    public static $rules = array(
        'name' => 'required|alpha_dash|max:255|unique:permissions',
        'display_name' => 'required|max:255',
        'description' => 'required|max:255',
        'comment' => 'required'
    );

}