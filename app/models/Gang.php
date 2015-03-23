<?php

class Gang extends Eloquent {

    protected $table = 'gangs';
    protected $primaryKey = 'id';

    public static $rules = array(
        'id'=>'required|numeric|min:1|unique:gangs,id'
    );
}
