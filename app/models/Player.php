<?php

class Player extends Eloquent {

    protected $table = 'players';
    protected $primaryKey = 'uid';

    public static $rules = array(
        'uid'=>'required|numeric|min:1|unique:players,uid'
    );
}
