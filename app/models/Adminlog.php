<?php

class Adminlog extends Eloquent {

    protected $table = 'logs';
    protected $primaryKey = 'id';

    public static $rules = array(
        'id'=>'required|numeric|min:1|unique:logs,id'
    );

    public function getDifference( $oldvalues, $newvalues ) {
        $difference = array();
        foreach($oldvalues as $key => $value):
            if($value != $newvalues[$key]):
                $difference[$key] = array($value, $newvalues[$key]);
            endif;
        endforeach;
        return serialize($difference);
    }
}
