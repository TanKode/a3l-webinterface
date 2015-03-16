<?php

class Movie extends Eloquent {

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'movies';

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = array();

    public static $rules = array(
        'type'=>'required',
        'name'=>'required|min:2',
        'year'=>'required|digits:4',
        'runtime'=>'integer|min:2',
        'genre'=>'required|min:2',
        'description'=>'min:25',
    );

}
