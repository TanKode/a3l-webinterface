<?php

class Vehicle extends Eloquent {

    protected $table = 'vehicles';
    protected $primaryKey = 'id';

    public static $rules = array(
        'id'=>'required|numeric|min:1|unique:vehicles',
        'active'=>'required|boolean',
        'alive'=>'required|boolean',
        'delete'=>'required|boolean'
    );
}
